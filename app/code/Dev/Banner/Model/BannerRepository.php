<?php

namespace Dev\Banner\Model;

use Dev\Banner\Api\BannerRepositoryInterface;
use Dev\Banner\Api\Data\BannerInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Dev\Banner\Model\BannerFactory;
use Dev\Banner\Model\ResourceModel\Banner as BannerResource;
use Dev\Banner\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Dev\Banner\Api\Data\BannerSearchResultInterfaceFactory;

class BannerRepository implements BannerRepositoryInterface
{
    /**
     * @var \Dev\Banner\Model\BannerFactory
     */
    protected $bannerFactory;

    /**
     * @var BannerResource
     */
    protected $bannerResource;

    /**
     * @var BannerCollectionFactory
     */
    protected $bannerCollectionFactory;

    /**
     * @var BannerSearchResultInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    public function __construct(
        BannerFactory $bannerFactory,
        BannerResource $bannerResource,
        BannerCollectionFactory $bannerCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        BannerSearchResultInterfaceFactory $bannerSearchResultInterfaceFactory

    ) {
        $this->bannerFactory = $bannerFactory;
        $this->bannerResource = $bannerResource;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $bannerSearchResultInterfaceFactory;
    }

    /**
     * @param int $id
     * @return \Dev\Banner\Api\Data\BannerInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $banner = $this->bannerFactory->create();
        $this->bannerResource->load($banner, $id, 'banner_id');
        if (!$banner->getId()) {
            throw new NoSuchEntityException(__('Unable to find Banner with ID "%1"', $id));
        }
        return $banner;
    }

    /**
     * @param \Dev\Banner\Api\Data\BannerInterface $banner
     * @return \Dev\Banner\Api\Data\BannerInterface
     */
    public function save(BannerInterface $banner)
    {
        $this->bannerResource->save($banner);
        return $banner;
    }

    /**
     * @param \Dev\Banner\Api\Data\BannerInterface $banner
     * @return void
     * @throws CouldNotDeleteException
     */
    public function delete(BannerInterface $banner)
    {
        try {
            $this->bannerResource->delete($banner);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Dev\Banner\Api\Data\BannerSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->bannerCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }
}
