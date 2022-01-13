<?php

namespace Amasty\MegaMenuLite\Controller\Adminhtml\Link;

use Magento\Backend\App\Action;

class NewAction extends Edit
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Amasty_MegaMenu::menu_links';
}
