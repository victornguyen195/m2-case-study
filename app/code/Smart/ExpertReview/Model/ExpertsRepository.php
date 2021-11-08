<?php

namespace Smart\ExpertReview\Model;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Smart\ExpertReview\Api\Data\ExpertsInterface;
use Smart\ExpertReview\Api\ExpertsRepositoryInterface;
use Smart\ExpertReview\Model\ResourceModel\Experts\Collection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;

/**
 * Class ExpertsRepository
 * @package Smart\ExpertReview\Model
 */
class ExpertsRepository implements ExpertsRepositoryInterface
{
    /**
     * @var \Smart\ExpertReview\Model\ExpertsFactory
     */
    protected $expertsFactory;

    /**
     * @var ResourceModel\Experts
     */
    protected $expertsResource;

    /**
     * @var ResourceModel\Experts\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Smart\ExpertReview\Api\Data\ExpertsSearchResultInterface
     */
    protected $searchResultInterfaceFactory;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @param ExpertsFactory $expertsFactory
     * @param ResourceModel\Experts $epxertsResource
     * @param ResourceModel\Experts\CollectionFactory $collectionFactory
     * @param \Smart\ExpertReview\Api\Data\ExpertsSearchResultInterface $searchResultInterfaceFactory
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     */
    public function __construct(
        \Smart\ExpertReview\Model\ExpertsFactory $expertsFactory,
        \Smart\ExpertReview\Model\ResourceModel\Experts $expertsResource,
        \Smart\ExpertReview\Model\ResourceModel\Experts\CollectionFactory $collectionFactory,
        \Smart\ExpertReview\Api\Data\ExpertsSearchResultInterface $searchResultInterfaceFactory,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    ) {
        $this->expertsFactory = $expertsFactory;
        $this->expertsResource = $expertsResource;
        $this->collectionFactory = $collectionFactory;
        $this->filterBuilder = $filterBuilder;
        $this->searchResultInterfaceFactory = $searchResultInterfaceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $expertModel = $this->expertsFactory->create();
        $this->expertsResource->load($expertModel, $id);
        if (!$expertModel->getEntityId()) {
            throw new NoSuchEntityException(__('Unable to find expert data with ID "%1"', $id));
        }
        return $expertModel;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ExpertsInterface $experts)
    {
        $this->expertsResource->save($experts);
        return $experts;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        try {
            $expertModel = $this->expertsFactory->create();
            $this->expertsResource->load($expertModel, $id);
            $this->expertsResource->delete($expertModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
