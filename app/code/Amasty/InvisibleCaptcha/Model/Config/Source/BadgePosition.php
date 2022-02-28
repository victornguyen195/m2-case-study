<?php

declare(strict_types=1);

namespace Amasty\InvisibleCaptcha\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class BadgePosition implements OptionSourceInterface
{
    const BADGE_POSITION_BOTTOMRIGHT = 'bottomright';
    const BADGE_POSITION_BOTTOMLEFT = 'bottomleft';

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::BADGE_POSITION_BOTTOMRIGHT, 'label'=> __('Bottom Right')],
            ['value' => self::BADGE_POSITION_BOTTOMLEFT, 'label'=> __('Bottom Left')]
        ];
    }
}
