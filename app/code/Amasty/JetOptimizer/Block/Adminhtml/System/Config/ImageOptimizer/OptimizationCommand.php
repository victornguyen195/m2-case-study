<?php

declare(strict_types=1);

namespace Amasty\JetOptimizer\Block\Adminhtml\System\Config\ImageOptimizer;

use Amasty\JetOptimizer\Console\Command\ImageOptimizer\OptimizeCommand;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class OptimizationCommand extends Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }

    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        $this->setTemplate('Amasty_JetOptimizer::imageOptimizer/command.phtml');
        return parent::_toHtml();
    }

    /**
     * @return string
     */
    public function getCommandName(): string
    {
        return 'php bin/magento ' . OptimizeCommand::COMMAND_NAME;
    }
}
