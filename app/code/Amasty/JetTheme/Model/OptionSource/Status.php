<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\OptionSource;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @var array|null
     */
    private $options;

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        if (!$this->options) {
            $this->options = [
                ['value' => self::STATUS_INACTIVE, 'label' => __('Inactive')],
                ['value' => self::STATUS_ACTIVE, 'label' => __('Active')],
            ];
        }

        return $this->options;
    }
}
