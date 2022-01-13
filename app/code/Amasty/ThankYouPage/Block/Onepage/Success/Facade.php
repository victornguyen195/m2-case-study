<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Block\Onepage\Success;

use Amasty\ThankYouPage\Block\Onepage\Success\Types\CreateAccount;
use Amasty\ThankYouPage\Block\Onepage\Success\Types\TypesInterface;
use Amasty\ThankYouPage\Model\Config;
use Amasty\ThankYouPage\Model\Config\Blocks;
use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;

class Facade extends Template
{
    /**
     * @var string
     */
    protected $_template = 'Amasty_ThankYouPage::onepage/success/facade.phtml';

    /**
     * @var Blocks
     */
    private $blocksConfig;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Session
     */
    private $checkoutSession;

    public function __construct(
        Context $context,
        Blocks $blocksConfig,
        Config $config,
        Session $checkoutSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blocksConfig = $blocksConfig;
        $this->config = $config;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @return string
     */
    public function getBlocksHtml(): string
    {
        $html = [];
        $isMultishipping = $this->checkoutSession->getCheckoutState() == 'multishipping_success';
        foreach ($this->getBlockInstances() as $block) {
            if ($block->isEnabled()) {
                if (!$isMultishipping) {
                    $html[] = $block->toHtml();
                } elseif ($isMultishipping && !$block instanceof CreateAccount) {
                    $html[] = $block->toHtml();
                }
            }
        }

        return implode('<br />', array_filter(array_map('trim', $html)));
    }

    /**
     * Instantiate blocks
     *
     * @return TypesInterface[]
     */
    private function getBlockInstances(): array
    {
        $instances = [];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        foreach ($this->blocksConfig->getSortedBlocks() as $blockConfig) {
            $blockInstance = $objectManager->create($blockConfig['class_name']);
            if (!empty($blockConfig['template'])) {
                $blockInstance->setTemplate($blockConfig['template']);
            }

            $instances[] = $blockInstance;
        }

        return $instances;
    }

    /**
     * @return string
     */
    public function getClassForBlock(): string
    {
        if ($this->config->isMarkupEnabled()) {
            if ($this->config->isForceOneColumnMobileViewEnabled()) {

                return 'amtypage-main-container -stretched-blocks';
            }

            return 'amtypage-main-container';
        }

        return '';
    }
}
