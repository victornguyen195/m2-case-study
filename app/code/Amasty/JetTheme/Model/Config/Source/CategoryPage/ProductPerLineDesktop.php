<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\Config\Source\CategoryPage;

use Magento\Framework\Data\OptionSourceInterface;

class ProductPerLineDesktop implements OptionSourceInterface
{
    const TWO = 2;
    const THREE = 3;

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::TWO, 'label' => 2],
            ['value' => self::THREE, 'label' => 3],
        ];
    }
}
