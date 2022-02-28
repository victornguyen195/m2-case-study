<?php

namespace Amasty\MegaMenuLite\Controller\Adminhtml\Link;

use Amasty\MegaMenuLite\Api\Data\Menu\LinkInterface;

class MassDelete extends AbstractMassAction
{
    /**
     * @param LinkInterface $link
     */
    protected function itemAction(LinkInterface $link)
    {
        $this->repository->deleteById($link->getEntityId());
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    protected function getErrorMessage()
    {
        return __('We can\'t delete item right now. Please review the log and try again.');
    }

    /**
     * @param int $collectionSize
     *
     * @return \Magento\Framework\Phrase
     */
    protected function getSuccessMessage($collectionSize = 0)
    {
        if ($collectionSize) {
            return __('A total of %1 record(s) have been deleted.', $collectionSize);
        }

        return __('No records have been deleted.');
    }
}
