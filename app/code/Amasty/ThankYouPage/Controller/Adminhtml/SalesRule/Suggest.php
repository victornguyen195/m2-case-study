<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Controller\Adminhtml\SalesRule;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\SalesRule\Api\RuleRepositoryInterface;

class Suggest extends Action
{

    /**
     * @const int
     */
    const PAGE_SIZE = 20;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var RuleRepositoryInterface
     */
    private $ruleRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        RuleRepositoryInterface $ruleRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->ruleRepository = $ruleRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Category list suggestion based on already entered symbols
     *
     * @return Json
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(): Json
    {
        $resultJson = $this->resultJsonFactory->create();

        return $resultJson->setData($this->getRules($this->getRequest()->getParam('label_part')));
    }

    /**
     * @param string $searchString
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getRules(string $searchString): array
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('name', '%' . $searchString . '%', 'like')
            ->addFilter('use_auto_generation', 1)
            ->addFilter('is_active', 1)
            ->setPageSize(self::PAGE_SIZE)
            ->create();

        $rules = $this->ruleRepository->getList($searchCriteria);

        $result = [];

        /** @var \Magento\SalesRule\Api\Data\RuleInterface $rule */
        foreach ($rules->getItems() as $rule) {
            $result[] = [
                'label' => $rule->getName(),
                'id'    => $rule->getRuleId(),
            ];
        }

        return $result;
    }
}
