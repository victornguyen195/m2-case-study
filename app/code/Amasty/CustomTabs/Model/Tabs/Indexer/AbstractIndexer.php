<?php

namespace Amasty\CustomTabs\Model\Tabs\Indexer;

use Amasty\CustomTabs\Api\Data\TabsInterface;
use Amasty\CustomTabs\Model\Tabs\Rule;
use Amasty\CustomTabs\Model\Tabs\RuleFactory;
use Amasty\CustomTabs\Model\Tabs\Tabs;
use Amasty\CustomTabs\Model\Tabs\ResourceModel\RuleIndex;
use Amasty\CustomTabs\Model\Tabs\ResourceModel\RuleIndexFactory;
use Amasty\CustomTabs\Api\TabsRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Indexer\ActionInterface;

abstract class AbstractIndexer implements ActionInterface, \Magento\Framework\Mview\ActionInterface
{
    /**
     * @var RuleIndex
     */
    private $resourceIndex;

    /**
     * @var TabsRepositoryInterface
     */
    private $tabRepository;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var int
     */
    protected $batchCount;

    /**
     * @var RuleFactory
     */
    private $ruleFactory;

    /**
     * @var CacheContext
     */
    private $cacheContext;

    /**
     * @var int
     */
    private $batchCacheCount;

    /**
     * @var ManagerInterface
     */
    private $eventManager;

    public function __construct(
        RuleIndexFactory $resourceIndexFactory,
        TabsRepositoryInterface $tabRepository,
        ProductCollectionFactory $productCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RuleFactory $ruleFactory,
        CacheContext $cacheContext,
        ManagerInterface $eventManager,
        $batchCount = 1000,
        $batchCacheCount = 100
    ) {
        $this->resourceIndex = $resourceIndexFactory->create();
        $this->tabRepository = $tabRepository;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->batchCount = $batchCount;
        $this->ruleFactory = $ruleFactory;
        $this->cacheContext = $cacheContext;
        $this->batchCacheCount = $batchCacheCount;
        $this->eventManager = $eventManager;
    }

    /**
     * Execute full indexation
     *
     * @return void
     */
    public function executeFull()
    {
        $this->doReindex();
    }

    /**
     * Execute partial indexation by ID list
     *
     * @param int[] $ids
     *
     * @return void
     */
    public function executeList(array $ids)
    {
        $this->doReindex($ids);
    }

    /**
     * Execute partial indexation by ID
     *
     * @param int $id
     *
     * @return void
     */
    public function executeRow($id)
    {
        $ids = [$id];
        $this->doReindex($ids);
    }

    /**
     * Execute materialization on ids entities
     *
     * @param int[] $ids
     *
     * @return void
     * @api
     */
    public function execute($ids)
    {
        $this->doReindex($ids);
    }

    /**
     * @param array $ids
     */
    protected function clean($ids = [])
    {
        if (empty($ids)) {
            $this->getIndexResource()->cleanAllIndex();
        } else {
            $this->cleanList($ids);
        }
    }

    /**
     * @return RuleIndex
     */
    protected function getIndexResource()
    {
        return $this->resourceIndex;
    }

    /**
     * @param $searchCriteria
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    private function loadRules($searchCriteria)
    {
        return $this->tabRepository->getList($searchCriteria);
    }

    /**
     * @param array $ids
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    protected function getTabs($ids = [])
    {
        if (!empty($ids)) {
            $this->searchCriteriaBuilder->addFilter(TabsInterface::TAB_ID, $ids, 'in');
        }

        return $this->loadRules($this->searchCriteriaBuilder->create());
    }

    /**
     * @param array $ids
     *
     * @return void
     */
    abstract protected function cleanList($ids);

    /**
     * @param array $ids
     *
     * @return void
     */
    protected function doReindex($ids = [])
    {
        $rows = [];
        $count = 0;
        $this->clean($ids);

        /** @var Tabs $tab */
        foreach ($this->getProcessedTabs($ids) as $tab) {
            if ($tab->getStores() && $tab->getConditionsSerialized()) {
                $tabId = $tab->getTabId();
                /** @var Rule $rule */
                $rule = $this->ruleFactory->create();
                $this->setProductsFilter($rule, $ids);
                $rule->setStores($tab->getStores());
                $rule->setConditionsSerialized($tab->getConditionsSerialized());
                $matchedProducts = $rule->getMatchingProductIdsByTab();
                foreach ($matchedProducts as $productId => $storeIds) {
                    while ($storeIds) {
                        $rows[] = [
                            RuleIndex::PRODUCT_ID => $productId,
                            RuleIndex::STORE_ID   => array_shift($storeIds),
                            RuleIndex::TAB_ID     => $tabId
                        ];
                        if (++$count > $this->batchCount) {
                            $this->getIndexResource()->insertIndexData($rows);
                            $count = 0;
                            $rows = [];
                        }
                    }
                    $this->registerEntities(Product::CACHE_TAG, [$productId]);
                }
                $this->registerEntities(Tabs::CACHE_TAG, [$tabId]);
            }
        }
        $this->cleanCache();

        if (!empty($rows)) {
            $this->getIndexResource()->insertIndexData($rows);
        }
    }

    /**
     * @param string $cacheTag
     * @param array $ids
     */
    private function registerEntities($cacheTag, $ids)
    {
        $this->cacheContext->registerEntities($cacheTag, $ids);
        if ($this->cacheContext->getSize() > $this->batchCacheCount) {
            $this->cleanCache();
            $this->cacheContext->flush();
        }
    }

    private function cleanCache()
    {
        $this->eventManager->dispatch('clean_cache_by_tags', ['object' => $this->cacheContext]);
    }

    /**
     * @param array $ids
     *
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    abstract protected function getProcessedTabs($ids = []);

    /**
     * @param Rule $rule
     * @param int|array $productIds
     */
    abstract protected function setProductsFilter($rule, $productIds);
}
