<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface SocialLinkSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get SocialLink list.
     * @return SocialLinkInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param SocialLinkInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
