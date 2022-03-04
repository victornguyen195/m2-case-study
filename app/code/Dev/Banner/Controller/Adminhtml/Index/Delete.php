<?php

namespace Dev\Banner\Controller\Adminhtml\Index;

use Dev\Banner\Model\BannerFactory;

class Delete extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    protected $bannerFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        BannerFactory $bannerFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->bannerFactory = $bannerFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!($banner = $this->bannerFactory->create()->load($id))) {
            $this->messageManager->addError(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('banner/index/index', array('_current' => true));
        }
        try{
            $banner->delete();
            $this->messageManager->addSuccess(__('Your banner has been deleted !'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete banner.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('banner/index/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('banner/index/index', array('_current' => true));
    }


}
