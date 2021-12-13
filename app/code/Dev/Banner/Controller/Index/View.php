<?php

namespace Dev\Banner\Controller\Index;

class View extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $bannerRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Dev\Banner\Api\BannerRepositoryInterface $bannerRepository
    ) {
        $this->_pageFactory = $pageFactory;
        $this->bannerRepository = $bannerRepository;
        return parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->_request->getParam('id');
        $banner = $this->bannerRepository->getById($id);
        var_dump($banner->getId());
        var_dump($banner->getStatus());
        var_dump($banner->getShortDescription());
        var_dump($banner->getName());
        var_dump($banner->getImage());

        die;
        return $this->_pageFactory->create();
    }
}
