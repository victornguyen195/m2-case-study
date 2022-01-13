<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Api\Data\Menu;

interface ItemSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Amasty\MegaMenuLite\Api\Data\Menu\ItemInterface[]
     */
    public function getItems();

    /**
     * @param \Amasty\MegaMenuLite\Api\Data\Menu\ItemInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
