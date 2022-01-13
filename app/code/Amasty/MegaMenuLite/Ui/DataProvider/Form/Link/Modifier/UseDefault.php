<?php

namespace Amasty\MegaMenuLite\Ui\DataProvider\Form\Link\Modifier;

use Amasty\MegaMenuLite\Api\Data\Menu\ItemInterface;
use Amasty\MegaMenuLite\Api\ItemRepositoryInterface;
use Amasty\MegaMenuLite\Api\Data\Menu\LinkInterface;
use Amasty\MegaMenuLite\Model\Provider\FieldsByStore;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Framework\Registry;
use Magento\Framework\App\RequestInterface;

class UseDefault implements ModifierInterface
{
    const ROW_ID = 'row_id';

    const SYSTEM_FIELDS = [
        ItemInterface::ID => null,
        ItemInterface::ENTITY_ID => null,
        ItemInterface::TYPE => null,
        ItemInterface::STORE_ID => null,
        ItemInterface::USE_DEFAULT => null
    ];

    /**
     * @var int
     */
    private $entityId;

    /**
     * @var string
     */
    private $type = '';

    /**
     * @var string
     */
    private $entityIdField = '';

    /**
     * @var int
     */
    private $storeId;

    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    /**
     * @var FieldsByStore
     */
    private $fieldsByStore;

    public function __construct(
        Registry $registry,
        RequestInterface $request,
        ItemRepositoryInterface $itemRepository,
        FieldsByStore $fieldsByStore,
        MetadataPool $metadataPool,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->itemRepository = $itemRepository;
        $this->storeId = (int)$request->getParam('store', 0);
        $this->fieldsByStore = $fieldsByStore;
        $this->init($registry, $metadataPool, $request, $categoryRepository);
    }

    private function init(
        Registry $registry,
        MetadataPool $metadataPool,
        RequestInterface $request,
        CategoryRepositoryInterface $categoryRepository
    ): void {
        $this->entityIdField = $metadataPool->getMetadata(CategoryInterface::class)->getLinkField();
        if ($registry->registry(LinkInterface::PERSIST_NAME)) {
            $this->entityId = $registry->registry(LinkInterface::PERSIST_NAME)->getId();
            $this->type = ItemInterface::CUSTOM_TYPE;
        } else {
            if ($registry->registry('current_category')) {
                $this->entityId = $registry->registry('current_category')->getData($this->entityIdField);
            } else {
                $id = $request->getParam('id');
                $this->entityId = $categoryRepository->get($id)->getData($this->entityIdField);
            }
            $this->type = ItemInterface::CATEGORY_TYPE;
        }
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data)
    {
        $defaultData = $this->getItem() ? $this->getItem()->getData() : [];
        $perStoreData = [];
        if ($this->storeId) {
            $perStoreData = $this->getItem($this->storeId) ? $this->getItem($this->storeId)->getData() : [];
        }
        $notnull = function ($var) {
            return $var !== null;
        };

        if (isset($perStoreData[ItemInterface::USE_DEFAULT])) {
            $useDefault = $perStoreData[ItemInterface::USE_DEFAULT];
            unset($perStoreData[ItemInterface::USE_DEFAULT]);
            $useDefault = array_flip(explode(ItemInterface::SEPARATOR, $useDefault ?: ''));
            $unsetValues = array_diff_key($defaultData, array_merge($useDefault, self::SYSTEM_FIELDS));
            foreach ($unsetValues as $key => $field) {
                $defaultData[$key] = null;
            }
        }

        $changedData = array_merge(
            $defaultData,
            array_filter($perStoreData, $notnull)
        );

        if (!empty($changedData)) {
            $data = $this->type == ItemInterface::CATEGORY_TYPE
                ? $this->modifyCategoryData($data, $changedData)
                : $this->modifyItemData($data, $changedData);
        }

        if ($this->storeId) {
            reset($data);
            $data[key($data)]['store_id'] = $this->storeId;
        }

        return $data;
    }

    private function modifyCategoryData(array $currentData, array $changedData): array
    {
        $fieldsets = $this->fieldsByStore->getCategoryFields();

        return $this->collectData($currentData, $changedData, $fieldsets);
    }

    private function modifyItemData(array $currentData, array $changedData): array
    {
        $fieldsets = $this->fieldsByStore->getCustomFields();

        return $this->collectData($currentData, $changedData, $fieldsets);
    }

    private function collectData(array $currentData, array $changedData, array $fieldsets): array
    {
        if ($this->entityIdField === self::ROW_ID && $this->type == ItemInterface::CATEGORY_TYPE) {
            foreach ($currentData as $entityData) {
                if (isset($entityData[self::ROW_ID])
                    && $entityData[self::ROW_ID] === $changedData[LinkInterface::ENTITY_ID]
                ) {
                    $entityId = $entityData[LinkInterface::ENTITY_ID];
                }
            }
        } else {
            $entityId = $changedData[LinkInterface::ENTITY_ID];
        }
        unset($currentData[$entityId][ItemInterface::USE_DEFAULT]);
        foreach ($fieldsets as $fieldset) {
            foreach ($changedData as $field => $value) {
                if (in_array($field, $fieldset)) {
                    $currentData[$entityId][$field] = $value;
                }
            }
        }

        return $currentData;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        if ($this->isShowDefaultCheckbox()) {
            $fieldsByStore = $this->type == ItemInterface::CATEGORY_TYPE
                ? $this->fieldsByStore->getCategoryFields()
                : $this->fieldsByStore->getCustomFields();
            $item = $this->getItem($this->storeId);
            $useDefault = $item ? explode(ItemInterface::SEPARATOR, $item->getUseDefault() ?: '') : [];
            $useDefault = empty($useDefault) ? [] : array_flip($useDefault);
            foreach ($fieldsByStore as $fieldSetCode => $fieldSet) {
                foreach ($fieldSet as $field) {
                    $meta[$fieldSetCode]['children'][$field]['arguments']['data']['config']['service'] =
                        [
                            'template' => 'ui/form/element/helper/service'
                        ];
                    if ((!$item || $item->getData($field) === null) && !$useDefault || isset($useDefault[$field])) {
                        $meta[$fieldSetCode]['children'][$field]['arguments']['data']['config']['disabled'] = true;
                    }
                }
            }
        }

        return $meta;
    }

    /**
     * @return bool
     */
    private function isShowDefaultCheckbox()
    {
        return (bool)$this->storeId;
    }

    /**
     * @param int $storeId
     *
     * @return ItemInterface
     */
    private function getItem($storeId = 0)
    {
        $item = $this->itemRepository->getByEntityId($this->entityId, $storeId, $this->type);
        if ($item && $item->getType() === ItemInterface::CATEGORY_TYPE && $item->getContent() === null) {
            $item->setContent('{{child_categories_content}}'); // set default value
        }

        return $item;
    }

    public function isNeedCategory(): bool
    {
        return false;
    }
}
