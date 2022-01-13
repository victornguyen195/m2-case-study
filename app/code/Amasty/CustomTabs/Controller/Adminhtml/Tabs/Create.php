<?php

namespace Amasty\CustomTabs\Controller\Adminhtml\Tabs;

use Amasty\CustomTabs\Controller\Adminhtml\Tabs;

/**
 * Class Index
 */
class Create extends Tabs
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
