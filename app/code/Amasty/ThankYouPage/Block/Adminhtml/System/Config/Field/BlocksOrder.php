<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Block\Adminhtml\System\Config\Field;

use Amasty\ThankYouPage\Model\Config\Blocks;
use Magento\Backend\Block\Template\Context;
use Amasty\ThankYouPage\Model\Config;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;

/**
 * Block for ordering sorting component in Admin System Configuration
 */
class BlocksOrder extends Field
{

    /**
     * @const string
     */
    const ELEMENT_TEMPLATE = 'Amasty_ThankYouPage::system/config/field/blocks_order.phtml';

    /**
     * @var Blocks
     */
    private $blocksConfig;

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Context $context,
        Blocks $blocksConfig,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->blocksConfig = $blocksConfig;
        $this->config = $config;
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     * @throws LocalizedException
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $blocks = $this->blocksConfig->getSortedBlocksByConfigValue($element->getEscapedValue());

        $templateBlock = $this->getLayout()->createBlock(
            Template::class,
            'amthankyoublocks_sort_order',
            [
                'data' => [
                    'template' => self::ELEMENT_TEMPLATE,
                ],
            ]
        );

        $form = $this->getForm();

        if ($this->config->isMarkupEnabled($form->getScopeCode(), $form->getScope())) {
            $templateBlock->setData('markup', 1);
        }

        return $templateBlock->setBlocks($blocks)
            ->setElementName($element->getName())
            ->toHtml();
    }
}
