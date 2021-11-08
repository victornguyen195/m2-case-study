<?php
namespace Smart\ExpertReview\Model\ResourceModel\Experts;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    
    protected function _construct()
    {
        $this->_init('Smart\ExpertReview\Model\Experts', 'Smart\ExpertReview\Model\ResourceModel\Experts');       
    }

}
