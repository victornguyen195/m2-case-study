<?php

namespace Amasty\CustomTabs\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\System\Store;

class Stores implements OptionSourceInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    private $store;

    /**
     * @param Store $store
     */
    public function __construct(
        Store $store
    ) {
        $this->store = $store;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return $this->store->getStoreValuesForForm(false, true);
    }
}
