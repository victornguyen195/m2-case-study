<?php
 
namespace AID\Crud\Model\ResourceModel\Book;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
 
    protected function _construct()
    {
        $this->_init('AID\Crud\Model\Book', 'AID\Crud\Model\ResourceModel\Book');
    }
}
