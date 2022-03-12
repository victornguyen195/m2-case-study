<?php

namespace Dev\ExpertReview\Model;

use Magento\Framework\Model\AbstractExtensibleModel;

class Expert extends AbstractExtensibleModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'dev_expert_expert';

    protected $_cacheTag = 'dev_expert_expert';

    protected $_eventPrefix = 'dev_expert_expert';

    protected function _construct()
    {
        $this->_init('Dev\ExpertReview\Model\ResourceModel\Expert');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
