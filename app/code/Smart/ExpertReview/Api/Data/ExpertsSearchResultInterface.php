<?php

namespace Smart\ExpertReview\Api\Data;

/**
 * Interface ExpertsSearchResultInterface
 * @package Smart\ExpertReview\Api\Data
 */
interface ExpertsSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Smart\ExpertReview\Api\Data\ExpertsInterface[]
     */
    public function getItems();

    /**
     * @param \Smart\ExpertReview\Api\Data\ExpertsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
