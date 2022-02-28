<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Block\Onepage\Success\Types;

use Amasty\ThankYouPage\Api\ConfigNewsletterInterface;
use Amasty\ThankYouPage\Model\Config\Blocks;
use Amasty\ThankYouPage\Model\Template\Filter;
use Magento\Customer\Model\Session;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Session\Generic as GenericSession;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Newsletter\Model\Subscriber;
use Magento\Newsletter\Model\SubscriberFactory;
use Magento\Sales\Model\OrderRepository;
use Magento\Store\Model\ScopeInterface;

/**
 * Newsletter block
 */
class Newsletter extends Template implements TypesInterface
{
    const BLOCK_CONFIG_NAME = 'newsletter';

    /**
     * @var ConfigNewsletterInterface
     */
    private $config;

    /**
     * Customer session
     *
     * @var Session
     */
    private $customerSession;

    /**
     * @var SubscriberFactory
     */
    private $subscriberFactory;

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var Blocks
     */
    private $blockConfig;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var GenericSession
     */
    private $session;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(
        Context $context,
        ConfigNewsletterInterface $config,
        Session $customerSession,
        SubscriberFactory $subscriberFactory,
        CheckoutSession $checkoutSession,
        Blocks $blockConfig,
        Filter $filter,
        GenericSession $session,
        OrderRepository $orderRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = clone $config;
        $this->customerSession = $customerSession;
        $this->subscriberFactory = $subscriberFactory;
        $this->checkoutSession = $checkoutSession;
        $this->blockConfig = $blockConfig;
        $this->config->setGroupPrefix('block_' . self::BLOCK_CONFIG_NAME);
        $this->filter = $filter;
        $this->session = $session;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return null
     */
    public function getCacheLifetime()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isBlockEnabled()
            && $this->isEnabledForGuests();
    }

    /**
     * @return bool
     */
    protected function isEnabledForGuests(): bool
    {
        $path = Subscriber::XML_PATH_ALLOW_GUEST_SUBSCRIBE_FLAG;
        $scopeType = ScopeInterface::SCOPE_STORE;

        return $this->_scopeConfig->isSetFlag($path, $scopeType)
            || $this->customerSession->isLoggedIn();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->filter->filter($this->config->getBlockTitle());
    }

    /**
     * @return string
     */
    public function getSubTitle(): string
    {
        return $this->filter->filter($this->config->getBlockSubTitle());
    }

    /**
     * @return string
     */
    public function getFormActionUrl(): string
    {
        return $this->getUrl('thankyoupage/newsletter/subscribe', ['_secure' => true]);
    }

    /**
     * @return string
     */
    public function getConfirmationMessage(): string
    {
        return $this->filter->filter($this->config->getConfirmationMessage());
    }

    /**
     * Checking if customer already subscribed
     *
     * @return bool
     */
    public function isAlreadySubscribed(): bool
    {
        /** @var \Magento\Newsletter\Model\Subscriber $subscriber */
        $subscriber = $this->subscriberFactory->create()->loadByEmail($this->getOrderEmail());

        return $subscriber->isSubscribed();
    }

    /**
     * @return string
     */
    public function getAlreadySubscribedText(): string
    {
        return $this->config->getAlreadySubscribedText();
    }

    /**
     * @return string
     */
    public function getOrderEmail(): string
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $this->checkoutSession->getLastRealOrder();
        return $this->emailResolver((string)$order->getCustomerEmail());
    }

    /**
     * @param string $email
     *
     * @return string
     */
    private function emailResolver(string $email): string
    {
        if (!$email) {
            $orderIds = $this->session->getOrderIds();
            foreach ($orderIds as $orderId) {
                $order = $this->orderRepository->get($orderId);

                if ($order->getCustomerEmail()) {
                    $email = $order->getCustomerEmail();
                    break;
                }
            }
        }

        return $email;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->blockConfig->getWidthByBlockId(self::BLOCK_CONFIG_NAME);
    }
}
