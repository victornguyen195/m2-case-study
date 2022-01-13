<?php

namespace Amasty\CustomTabs\Model\Tabs\Indexer;

class ProductIndexer extends AbstractIndexer
{
    /**
     * @inheritdoc
     */
    protected function cleanList($ids)
    {
        $this->getIndexResource()->cleanByProductIds($ids);
    }

    /**
     * @inheritdoc
     */
    protected function setProductsFilter($rule, $productIds)
    {
        $rule->setProductsFilter($productIds);
    }

    /**
     * @inheritdoc
     */
    protected function getProcessedTabs($ids = [])
    {
        return $this->getTabs()->getItems();
    }
}
