<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Block;

use Amasty\MegaMenuLite\Api\Data\Menu\ItemInterface;
use Amasty\MegaMenuLite\Model\ConfigProvider;
use Amasty\MegaMenuLite\Model\Detection\MobileDetect;
use Amasty\MegaMenuLite\Model\Menu\Content\Resolver;
use Amasty\MegaMenuLite\Model\Menu\TreeResolver;
use Amasty\MegaMenuLite\Model\OptionSource\Status;
use Magento\Customer\Model\Context;
use Magento\Customer\Model\Url as CustomerUrlModel;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\DataObject;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;

class Container extends Template
{
    const CONFIGURATION = 'config';

    const DATA = 'data';

    const IS_CHILD_HAS_ICON = 'isChildHasIcons';

    const IS_CATEGORY = 'is_category';

    /**
     * @var Node|null
     */
    private $menu = null;

    /**
     * @var array
     */
    private $nodesData = [];

    /**
     * @var array
     */
    private $jsConfig = [];

    /**
     * @var Json
     */
    private $json;

    /**
     * @var TreeResolver
     */
    private $treeResolver;

    /**
     * @var Resolver
     */
    private $contentResolver;

    /**
     * @var CustomerUrlModel
     */
    private $customerUrlModel;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var MobileDetect
     */
    private $mobileDetect;

    /**
     * @var HttpContext
     */
    private $httpContext;

    public function __construct(
        Template\Context $context,
        Json $json,
        TreeResolver $treeResolver,
        Resolver $contentResolver,
        CustomerUrlModel $customerUrlModel,
        ConfigProvider $configProvider,
        MobileDetect $mobileDetect,
        HttpContext $httpContext,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->json = $json;
        $this->treeResolver = $treeResolver;
        $this->contentResolver = $contentResolver;
        $this->customerUrlModel = $customerUrlModel;
        $this->configProvider = $configProvider;
        $this->mobileDetect = $mobileDetect;
        $this->httpContext = $httpContext;
    }

    public function getJsComponents()
    {
        $this->jsLayout = $this->getData('jsLayout')['components'] ?? [];

        return $this->json->serialize($this->jsLayout);
    }

    public function getJsSettings()
    {
        $settings = [
            'account' => [
                'is_logged_in' => $this->isLoggedIn(),
                'login' => $this->customerUrlModel->getLoginUrl(),
                'create' => $this->customerUrlModel->getRegisterUrl(),
                'logout' => $this->customerUrlModel->getLogoutUrl(),
                'account' => $this->customerUrlModel->getAccountUrl()
            ]
        ];

        $layoutSettings = $this->getData('jsLayout')['settings'] ?? [];
        foreach ($layoutSettings as $key => $layoutSettingModel) {
            $settings[$key] = $layoutSettingModel->getData();
        }

        return $this->json->serialize($settings);
    }

    public function getStoreLinks(): string
    {
        $block = $this->getLayout()->getBlock('store.links');
        if ($block) {
            $data = $block->getData();
        }

        return $this->json->serialize($data ?? []);
    }

    public function getJsConfig(): array
    {
        if (!$this->jsConfig) {
            $settings = [];
            $configs = $this->getData('jsLayout')['config'] ?? [];

            foreach ($configs as $config) {
                $config->modifyConfig($settings);
            }
            $this->jsConfig = $settings;
        }

        return $this->jsConfig;
    }

    public function getSerializedJsConfig(): string
    {
        return $this->json->serialize($this->getJsConfig());
    }

    public function getJsData(): string
    {
        return $this->json->serialize($this->getNodesData());
    }

    public function getMenuTree(): ?Node
    {
        if ($this->menu === null) {
            $this->menu = $this->treeResolver->get(
                (int) $this->_storeManager->getStore()->getId()
            );
        }

        return $this->menu;
    }

    public function getNodeData(Node $node): array
    {
        $data = [];
        if ($node->getChildren()->count()) {
            foreach ($node->getChildren() as $child) {
                $data[] = $this->getNodeData($child);
                if ($this->isChildHasIcon($child)) {
                    $node->setData(self::IS_CHILD_HAS_ICON, true);
                }
            }
        }

        return $this->getCurrentNodeData($node, $data);
    }

    /**
     * @return array
     */
    public function getAllNodesData(): array
    {
        $elems = $this->getNodesData()['elems'] ?? [];
        foreach ($elems as $key => $elem) {
            if ($elem[ItemInterface::STATUS] == Status::MOBILE) {
                unset($elems[$key]);
            }
        }

        return $elems;
    }

    /**
     * @return array
     */
    public function getHamburgerNodesData(): array
    {
        $nodes = [];
        foreach ($this->getAllNodesData() as $node) {
            if (!$node[self::IS_CATEGORY]) {
                $nodes[] = $node;
            }
        }

        return $nodes;
    }

    private function getCurrentNodeData(Node $node, array $elems = []): array
    {
        $data = [
            ItemInterface::NAME => $node->getData('name'),
            self::IS_CATEGORY => $node->getData(self::IS_CATEGORY),
            ItemInterface::ID => $node->getId(),
            self::IS_CHILD_HAS_ICON => (bool) $node->getData(self::IS_CHILD_HAS_ICON),
            ItemInterface::STATUS => $this->getNodeStatus($node),
            'content' => $this->contentResolver->resolve($node),
            'elems' => $elems,
            'url' => $node->getData('url'),
            'current' => $node->getData('has_active') || $node->getData('is_active')
        ];

        if ($node->getData(ItemInterface::LABEL)) {
            $data[ItemInterface::LABEL] = [
                ItemInterface::LABEL => $node->getData(ItemInterface::LABEL),
                ItemInterface::LABEL_TEXT_COLOR => $node->getData(ItemInterface::LABEL_TEXT_COLOR),
                ItemInterface::LABEL_BACKGROUND_COLOR => $node->getData(ItemInterface::LABEL_BACKGROUND_COLOR)
            ];
        }

        $transportObject = new DataObject();
        $this->_eventManager->dispatch(
            'am_mega_menu_update_node_data',
            [
                'node' => $node,
                'transport_object' => $transportObject->setData($data)
            ]
        );

        return $transportObject->getData();
    }

    private function getNodeStatus(Node $node): int
    {
        return $node->getData(self::IS_CATEGORY) ? 1 : (int) $node->getData(ItemInterface::STATUS);
    }

    private function isChildHasIcon(Node $child): bool
    {
        return $child->getData('icon')
            && !(
                $this->configProvider->isHamburgerEnabled()
                && !$this->mobileDetect->isMobile()
                && !$child->getData(self::IS_CATEGORY)
            );
    }

    /**
     * @return array
     */
    private function getNodesData(): array
    {
        if (!$this->nodesData) {
            $this->nodesData = $this->getNodeData($this->getMenuTree());
        }

        return $this->nodesData;
    }

    /**
     * Is customer logged in
     *
     * @return bool
     */
    private function isLoggedIn(): bool
    {
        return (bool) $this->httpContext->getValue(Context::CONTEXT_AUTH);
    }
}
