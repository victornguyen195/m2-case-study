<?php

namespace Amasty\ThankYouPage\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Widget;

class Tooltip extends Widget
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->setTemplate('Amasty_ThankYouPage::system/config/tooltip.phtml');
        parent::_construct();
    }
}
