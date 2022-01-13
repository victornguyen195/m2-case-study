<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\Config\Source\ProductPage;

use Magento\Framework\Data\OptionSourceInterface;

class StickyAddToCart implements OptionSourceInterface
{
    const DISABLED = 0;
    const SIDEBAR = 'sidebar';
    const HORIZONTAL = 'horizontal';

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::DISABLED, 'label' => __('Disabled')],
            ['value' => self::SIDEBAR, 'label' => __('Sidebar')],
            ['value' => self::HORIZONTAL, 'label' => __('Horizontal Bar')],
        ];
    }
}
