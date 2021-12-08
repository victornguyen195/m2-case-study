<?php

namespace Dev\Banner\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BannerSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Dev\Banner\Api\Data\BannerInterface[]
     */
    public function getItems();

    /**
     * @param \Dev\Banner\Api\Data\BannerInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
