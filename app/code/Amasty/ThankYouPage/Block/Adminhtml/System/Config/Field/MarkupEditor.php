<?php

namespace Amasty\ThankYouPage\Block\Adminhtml\System\Config\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class MarkupEditor extends Field
{
    /**
     * @var string
     */
    protected $_template = 'Amasty_ThankYouPage::system/config/field/blocks_order_comment.phtml';

    /**
     * @inheritdoc
     */
    public function render(AbstractElement $element)
    {
        $element->setComment($this->toHtml());

        return parent::render($element);
    }
}
