<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PaymentLinkSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return PaymentLinkInterface[]
     */
    public function getItems();

    /**
     * @param PaymentLinkInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
