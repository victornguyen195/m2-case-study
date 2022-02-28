<?php

namespace Amasty\CustomTabs\Model\Tabs\Indexer;

class TabIndexer extends AbstractIndexer
{
    /**
     * @inheritdoc
     */
    protected function cleanList($ids)
    {
        $this->getIndexResource()->cleanByRuleIds($ids);
    }

    /**
     * @inheritdoc
     */
    protected function setProductsFilter($rule, $productIds)
    {
        $rule->setProductsFilter(null);
    }

    /**
     * @inheritdoc
     */
    protected function getProcessedTabs($ids = [])
    {
        return $this->getTabs($ids)->getItems();
    }
}
