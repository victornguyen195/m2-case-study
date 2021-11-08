<?php

namespace AID\Crud\Controller\Adminhtml\Index;
use AID\Crud\Model\Book;

class Delete extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!($book = $this->_objectManager->create(Book::class)->load($id))) {
            $this->messageManager->addError(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('crud/index/index', array('_current' => true));
        }
        try{
            $book->delete();
            $this->messageManager->addSuccess(__('Your book has been deleted !'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete book.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('crud/index/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('crud/index/index', array('_current' => true));
    }


}
