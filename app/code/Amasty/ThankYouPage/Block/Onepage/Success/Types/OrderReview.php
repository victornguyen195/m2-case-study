<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Block\Onepage\Success\Types;

use Amasty\ThankYouPage\Api\ConfigBasicInterface;
use Magento\Framework\Module\Manager;
use Magento\Framework\View\Element\Template;
use Amasty\ThankYouPage\Model\Config\Blocks;

/**
 * Header block
 */
class OrderReview extends Template implements TypesInterface
{
    const NAME_OSC_BLOCK = 'amasty.checkout.success';
    const NAME_CHECKOUT_BLOCK = 'checkout.success';
    const NAME_MULTISHIPPING_BLOCK = 'checkout_success';
    const BLOCK_CONFIG_NAME = 'order_review';

    /**
     * @var ConfigBasicInterface
     */
    private $config;

    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * @var Blocks
     */
    private $blocksConfig;

    public function __construct(
        Template\Context $context,
        ConfigBasicInterface $config,
        Manager $moduleManager,
        Blocks $blocksConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = clone $config;
        $this->moduleManager = $moduleManager;
        $this->blocksConfig = $blocksConfig;
        $this->config->setGroupPrefix('block_' . self::BLOCK_CONFIG_NAME);
    }

    /**
     * @return null
     */
    public function getCacheLifetime()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getReviewBlockHtml(): string
    {
        // Use "Amasty_Checkout" success block in case the module is enabled
        $blockName = $this->moduleManager->isEnabled('Amasty_Checkout')
            ? self::NAME_OSC_BLOCK
            : self::NAME_CHECKOUT_BLOCK;

        if (!$this->getLayout()->getBlock(self::NAME_CHECKOUT_BLOCK)
            && !$this->getLayout()->getBlock(self::NAME_OSC_BLOCK)
        ) {
            $blockName = self::NAME_MULTISHIPPING_BLOCK;
        }

        return $this->getLayout()->getBlock($blockName)->toHtml();
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->blocksConfig->getWidthByBlockId(self::BLOCK_CONFIG_NAME);
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isBlockEnabled();
    }
}
