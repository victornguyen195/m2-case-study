<?php

namespace Amasty\CustomTabs\Model\Source;

use Magento\Customer\Ui\Component\Listing\Column\Group\Options;

class CustomerGroup extends Options
{
    const ALL = -1;

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = parent::toOptionArray();
        $options[] = [
            'value' => self::ALL,
            'label' => __('All')
        ];

        return $options;
    }
}
