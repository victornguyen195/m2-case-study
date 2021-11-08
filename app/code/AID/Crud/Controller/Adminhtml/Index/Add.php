<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AID\Crud\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
/**
 * Create CMS page action.
 */
class Add extends \Magento\Backend\App\Action implements HttpGetActionInterface
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
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Add Book')));

        return $resultPage;
    }
}
