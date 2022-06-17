<?php
namespace Integerbyte\MyRecaptcha\Controller\Index;
class Save extends \Magento\Framework\App\Action\Action
{
    protected $_request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->_request = $request;
        parent::__construct($context);
    }
    public function execute()
    {
        $formData = $this->_request->getPostValue();
        // your logic
        die();
    }
}
