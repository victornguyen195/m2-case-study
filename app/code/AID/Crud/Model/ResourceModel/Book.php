<?php
 
namespace AID\Crud\Model\ResourceModel;
 
class Book extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('books', 'entity_id');
    }
}
