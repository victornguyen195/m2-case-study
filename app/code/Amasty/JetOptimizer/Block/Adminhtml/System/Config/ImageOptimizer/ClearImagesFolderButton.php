<?php

declare(strict_types=1);

namespace Amasty\JetOptimizer\Block\Adminhtml\System\Config\ImageOptimizer;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ClearImagesFolderButton extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $element->setData('value', __("Clear Generated Image Folders"));
        $element->setData('class', "action-default amoptimizer-btn");
        $element->setData('onclick', "location.href = '" . $this->getActionUrl() . "'");

        return parent::_getElementHtml($element);
    }

    /**
     * @return string
     */
    public function getActionUrl(): string
    {
        return $this->_urlBuilder->getUrl('amasty_jetoptimizer/imageOptimizer/clearImagesFolder');
    }
}
