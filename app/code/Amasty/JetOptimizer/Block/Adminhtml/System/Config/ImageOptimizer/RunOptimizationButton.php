<?php

declare(strict_types=1);

namespace Amasty\JetOptimizer\Block\Adminhtml\System\Config\ImageOptimizer;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class RunOptimizationButton extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->setTemplate('Amasty_JetOptimizer::imageOptimizer/progressBar.phtml')->_toHtml();
    }

    /**
     * @return string
     */
    public function getStartUrl(): string
    {
        return $this->_urlBuilder->getUrl('amasty_jetoptimizer/imageOptimizer/start');
    }

    /**
     * @return string
     */
    public function getProcessUrl(): string
    {
        return $this->_urlBuilder->getUrl('amasty_jetoptimizer/imageOptimizer/process');
    }
}
