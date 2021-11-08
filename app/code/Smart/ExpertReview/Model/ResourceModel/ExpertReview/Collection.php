<?php
namespace Smart\ExpertReview\Model\ResourceModel\ExpertReview;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init('Smart\ExpertReview\Model\ExpertReview', 'Smart\ExpertReview\Model\ResourceModel\ExpertReview');
    }
    /**
     * Add entity filter
     *
     * @param int $entityId
     * @return $this
     */
    public function addEntityFilter($entityId)
    {
        $this->getSelect()->where('product_id = ?', $entityId);
        return $this;
    }

}
