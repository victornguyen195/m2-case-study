<?php

namespace Smart\ExpertReview\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Smart\ExpertReview\Api\Data\ExpertsInterface;

/**
 * Interface ExpertsRepositoryInterface
 * @package Smart\ExpertReview\Api
 */
interface ExpertsRepositoryInterface
{
    /**
     * @param int $id
     * @return \Smart\ExpertReview\Api\Data\ExpertsInterface
     */
    public function getById($id);

    /**
     * @param \Smart\ExpertReview\Api\Data\ExpertsInterface $expert
     * @return \Smart\ExpertReview\Api\Data\ExpertsInterface
     */
    public function save(ExpertsInterface $expert);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Smart\ExpertReview\Api\Data\ExpertsSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
