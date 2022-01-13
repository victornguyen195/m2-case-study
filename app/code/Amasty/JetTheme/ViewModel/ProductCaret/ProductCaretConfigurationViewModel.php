<?php

declare(strict_types=1);

namespace Amasty\JetTheme\ViewModel\ProductCaret;

use Amasty\JetTheme\Model\ConfigProvider;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductCaretConfigurationViewModel implements ArgumentInterface
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * @return string
     */
    public function isProductCaretEnabled(): string
    {
        return $this->configProvider->isStickAddToCartEnabled();
    }
}
