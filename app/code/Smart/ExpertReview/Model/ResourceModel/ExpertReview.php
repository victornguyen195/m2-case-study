<?php
namespace Smart\ExpertReview\Model\ResourceModel;
use Magento\Framework\App\ResourceConnection;
class ExpertReview extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('smart_expertreview', 'entity_id');
    }
}
