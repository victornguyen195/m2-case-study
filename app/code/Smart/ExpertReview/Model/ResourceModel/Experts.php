<?php
namespace Smart\ExpertReview\Model\ResourceModel;
use Magento\Framework\App\ResourceConnection;
class Experts extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('smart_experts', 'entity_id');
    }
}
