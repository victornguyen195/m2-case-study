<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Block\Adminhtml\System\Config\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Text;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Template;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Api\RuleRepositoryInterface;

/**
 * Block for ordering sorting component in Admin System Configuration
 */
class CartPriceRules extends Field
{
    /**
     * @var Text
     */
    private $textElement;

    /**
     * @var RuleRepositoryInterface
     */
    private $ruleRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        Context $context,
        Text $textElement,
        RuleRepositoryInterface $ruleRepository,
        SerializerInterface $serializer,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->textElement = $textElement;
        $this->ruleRepository = $ruleRepository;
        $this->serializer = $serializer;
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return parent::_getElementHtml($element)
            . $this->getElementAfterHtml($element);
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getElementAfterHtml(AbstractElement $element): string
    {
        $htmlId = $element->getHtmlId();
        $selectorOptions = $this->serializer->serialize($this->getSelectorOptions($element));
        $textElement = $this->textElement->setForm($element->getForm())
            ->setId($htmlId . '-suggest');

        return $this->getLayout()->createBlock(Template::class)
            ->setTemplate('Amasty_ThankYouPage::system/config/field/rule.phtml')
            ->setHtmlId($htmlId)
            ->setSelectedOptions($selectorOptions)
            ->setSelectedRuleName($this->getSelectedRuleName($element))
            ->setTextElementHtml($textElement->getElementHtml())
            ->toHtml();
    }

    /**
     * Get selector options
     *
     * @param AbstractElement $element
     *
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getSelectorOptions(AbstractElement $element): array
    {
        $ruleId = null;
        if ($rule = $this->getSelectedRule($element)) {
            $ruleId = $rule->getRuleId();
        }

        return [
            'source'            => $this->getUrl('thankyoupage/salesRule/suggest'),
            'valueField'        => '#' . $element->getHtmlId(),
            'minLength'         => 1,
            'currentlySelected' => $ruleId,
        ];
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    private function getSelectedRuleName(AbstractElement $element): string
    {
        if ($rule = $this->getSelectedRule($element)) {
            return ' #' . $rule->getRuleId() . ' - ' . $rule->getName();
        }

        return '';
    }

    /**
     * @param AbstractElement $element
     *
     * @return RuleInterface|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    private function getSelectedRule(AbstractElement $element): ?RuleInterface
    {
        if ($selectedId = $element->getEscapedValue()) {
            $rule = $this->ruleRepository->getById($selectedId);
            if ($rule->getRuleId()) {
                return $rule;
            }
        }

        return null;
    }
}
