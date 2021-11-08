<?php

namespace AID\Crud\Controller\Test;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $bookFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \AID\Crud\Model\BookFactory $bookFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->bookFactory = $bookFactory;  
        return parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->bookFactory->create()->getCollection();
        foreach ($data as $value) {
            echo "<pre>";
            print_r($value->getData());
            echo "</pre>";
        }
        return $this->_pageFactory->create();
    }
}
