<?php
 
namespace AID\Crud\Model;
 
class Book extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('AID\Crud\Model\ResourceModel\Book');
    }
}
