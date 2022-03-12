<?php

namespace Dev\ExpertReview\Controller\Adminhtml\Index;

use Dev\ExpertReview\Model\ExpertFactory;

class Delete extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    protected $expertFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ExpertFactory $expertFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->expertFactory = $expertFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!($expert = $this->expertFactory->create()->load($id))) {
            $this->messageManager->addError(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('expert/index/index', array('_current' => true));
        }
        try{
            $expert->delete();
            $this->messageManager->addSuccess(__('Your expert has been deleted !'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete expert.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('expert/index/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('expert/index/index', array('_current' => true));
    }


}
