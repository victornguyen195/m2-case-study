<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\Config\Source\Footer;

use Magento\Framework\Data\OptionSourceInterface;

class AlignPaymentMethodsBlock implements OptionSourceInterface
{
    const LEFT = 'left';
    const RIGHT = 'right';
    const CENTER = 'center';

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::LEFT, 'label' => __('Left')],
            ['value' => self::RIGHT, 'label' => __('Right')],
            ['value' => self::CENTER, 'label' => __('Center')],
        ];
    }
}
