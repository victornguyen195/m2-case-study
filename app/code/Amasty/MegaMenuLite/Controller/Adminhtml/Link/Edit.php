<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Controller\Adminhtml\Link;

use Amasty\MegaMenuLite\Model\Menu\Link;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Amasty_MegaMenu::menu_links';

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var \Amasty\MegaMenuLite\Api\LinkRepositoryInterface
     */
    private $linkRepository;

    /**
     * @var \Amasty\MegaMenuLite\Model\Menu\LinkFactory
     */
    private $linkFactory;

    public function __construct(
        Action\Context $context,
        \Amasty\MegaMenuLite\Api\LinkRepositoryInterface $linkRepository,
        \Amasty\MegaMenuLite\Model\Menu\LinkFactory $linkFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->dataPersistor = $dataPersistor;
        $this->linkRepository = $linkRepository;
        $this->linkFactory = $linkFactory;
    }

    /**
     * @return Redirect|ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $linkId = (int)$this->getRequest()->getParam('id');
        if ($linkId) {
            try {
                $model = $this->linkRepository->getById($linkId);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This Custom Menu Item no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/index');
            }
        } else {
            /** @var Link $model */
            $model = $this->linkFactory->create();
        }

        // set entered data if was error when we do save
        $data = $this->dataPersistor->get(Link::PERSIST_NAME);
        if (!empty($data) && !$model->getEntityId()) {
            $model->addData($data);
        }

        $this->coreRegistry->register(Link::PERSIST_NAME, $model);

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $text = $model->getEntityId() ?
            __('Edit Custom Menu Item # %1', $model->getEntityId())
            : __('New Custom Menu Item');
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE);
        $resultPage->getConfig()->getTitle()->prepend($text);

        return $resultPage;
    }
}
