<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\Config\Source\ProductPage;

use Magento\Framework\Data\OptionSourceInterface;

class SwatchesType implements OptionSourceInterface
{
    const ROUND = 'round';
    const SQUARE = 'square';

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::ROUND, 'label' => __('Round')],
            ['value' => self::SQUARE, 'label' => __('Square')],
        ];
    }
}
