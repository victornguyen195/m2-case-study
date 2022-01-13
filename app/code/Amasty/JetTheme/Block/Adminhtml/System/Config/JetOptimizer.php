<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template;
use Magento\Config\Block\System\Config\Form\Fieldset;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\Manager;

class JetOptimizer extends Fieldset
{
    /**
     * Render fieldset html
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $moduleManager = ObjectManager::getInstance()->get(Manager::class);
        if ($moduleManager->isEnabled('Amasty_JetOptimizer')) {
            return parent::render($element);
        }

        $message = $this->getLayout()->createBlock(Template::class)
            ->setTemplate('Amasty_JetTheme::jet_optimizer.phtml')
            ->toHtml();
        $html = $this->_getHeaderHtml($element);
        $html .= $message;
        $html .= $this->_getFooterHtml($element);

        return $html;
    }
}
