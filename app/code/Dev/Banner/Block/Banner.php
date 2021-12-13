<?php

namespace Dev\Banner\Block;

class Banner extends \Magento\Framework\View\Element\Template
{
    protected $bannerRepository;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Dev\Banner\Api\BannerRepositoryInterface $bannerRepository
    ) {
        parent::__construct($context);
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * @return \Dev\Banner\Api\Data\BannerInterface
     */
    public function getBanner()
    {
        $id = $this->_request->getParam('id');
        return $this->bannerRepository->getById($id);
    }
}
