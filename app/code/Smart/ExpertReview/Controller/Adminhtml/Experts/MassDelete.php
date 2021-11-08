<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Smart\ExpertReview\Controller\Adminhtml\Experts;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Smart\ExpertReview\Model\ResourceModel\Experts\CollectionFactory;
use Smart\ExpertReview\Model\ExpertsRepository;
use Smart\ExpertReview\Api\ExpertsRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

/**
 * Class \Smart\ExpertReview\Controller\Adminhtml\Experts\MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ExpertsRepositoryInterface
     */
    private $expertsRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ExpertsRepository $expertsRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ExpertsRepositoryInterface $expertsRepository = null,
        LoggerInterface $logger = null
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->expertsRepository = $expertsRepository ?:
            \Magento\Framework\App\ObjectManager::getInstance()->create(ExpertsRepositoryInterface::class);
        $this->logger = $logger ?:
            \Magento\Framework\App\ObjectManager::getInstance()->create(LoggerInterface::class);
        parent::__construct($context);
    }

    /**
     * Mass Delete Action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $expertDeleted = 0;
        $expertDeletedError = 0;
        /** @var \Smart\ExpertReview\Model\Experts $expert */
        foreach ($collection->getItems() as $expert) {
            try {
                $this->expertsRepository->deleteById($expert->getEntityId());
                $expertDeleted++;
            } catch (LocalizedException $exception) {
                $this->logger->error($exception->getLogMessage());
                $expertDeletedError++;
            }
        }

        if ($expertDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $expertDeleted)
            );
        }

        if ($expertDeletedError) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $expertDeletedError
                )
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('smart_expertreview/*/index');
    }
}
