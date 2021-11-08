<?php
namespace Smart\ExpertReview\Model;

class ExpertReview extends \Magento\Framework\Model\AbstractModel// implements \Magento\Framework\DataObject\IdentityInterface
{
    protected function _construct()
    {
        $this->_init('Smart\ExpertReview\Model\ResourceModel\ExpertReview');
    }
}
