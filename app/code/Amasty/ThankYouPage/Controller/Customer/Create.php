<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Controller\Customer;

use Amasty\ThankYouPage\Api\OrderCustomerManagementInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Encryption\EncryptorInterface;

class Create extends Action
{

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var OrderCustomerManagementInterface
     */
    private $orderCustomerService;

    /**
     * @var EncryptorInterface
     */
    private $encryptor;

    public function __construct(
        Context $context,
        Session $customerSession,
        OrderCustomerManagementInterface $orderCustomerService,
        EncryptorInterface $encryptor
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
        $this->orderCustomerService = $orderCustomerService;
        $this->encryptor = $encryptor;
    }

    /**
     * Execute request
     *
     * @throws \Exception
     * @return Json
     */
    public function execute(): Json
    {
        /** @var Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        if ($this->customerSession->isLoggedIn()) {
            return $resultJson->setData(
                [
                    'errors'  => true,
                    'message' => __('Customer is already registered'),
                ]
            );
        }
        $orderId = $this->encryptor->decrypt(urldecode($this->getRequest()->getParam('order_id')));
        if (!$orderId) {
            return $resultJson->setData(
                [
                    'errors'  => true,
                    'message' => __('Your session has expired'),
                ]
            );
        }
        try {
            $this->orderCustomerService->create(
                (int)$orderId,
                $this->getRequest()->getParam('create_account_email'),
                $this->getRequest()->getParam('password'),
                $this->getRequest()->getParam('amasty-thank-you-page-dob')
            );

            return $resultJson->setData(
                [
                    'errors'  => false,
                    'message' => __('A letter with further instructions will be sent to your email.'),
                ]
            );
        } catch (\Exception $e) {
            return $resultJson->setData(
                [
                    'errors'  => true,
                    'message' => __($e->getMessage())
                ]
            );
        }
    }
}
