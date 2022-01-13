<?php

namespace Amasty\CustomTabs\Controller\Adminhtml\Tabs;

use Amasty\CustomTabs\Api\Data\TabsInterface;

/**
 * Class MassDelete
 */
class MassEnable extends AbstractMassAction
{
    /**
     * {@inheritdoc}
     */
    protected function itemAction(TabsInterface $tab)
    {
        $tab->setStatus(1);
        $this->repository->save($tab);
    }
}
