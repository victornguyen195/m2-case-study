<?php

namespace Dev\Banner\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Dev\Banner\Api\Data\BannerInterface;

/**
 * Interface BannerRepositoryInterface
 * @package Dev\Banner\Api
 */
interface BannerRepositoryInterface
{
    /**
     * @param int $id
     * @return \Dev\Banner\Api\Data\BannerInterface
     */
    public function getById($id);

    /**
     * @param \Dev\Banner\Api\Data\BannerInterface $banner
     * @return \Dev\Banner\Api\Data\BannerInterface
     */
    public function save(BannerInterface $banner);

    /**
     * @param \Dev\Banner\Api\Data\BannerInterface $banner
     * @return void
     */
    public function delete(BannerInterface $banner);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Dev\Banner\Api\Data\BannerSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
