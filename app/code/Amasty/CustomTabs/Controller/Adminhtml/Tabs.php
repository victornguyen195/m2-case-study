<?php

namespace Amasty\CustomTabs\Controller\Adminhtml;

abstract class Tabs extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Amasty_CustomTabs::tabs';
}
