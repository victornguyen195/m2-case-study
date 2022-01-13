<?php

namespace Amasty\CustomTabs\Plugin\Faq\Plugin;

class TabPositionPlugin
{
    /**
     * @phpstan-ignore-next-line
     * @param \Amasty\Faq\Plugin\TabPosition $subject
     * @param \Closure $proceed
     * @param $result
     *
     * @return mixed
     */
    public function aroundAfterGetGroupChildNames(
        \Amasty\Faq\Plugin\TabPosition $subject,
        \Closure $proceed,
        $plugin,
        $childNamesSortOrder
    ) {
        //disable module plugin
        return $childNamesSortOrder;
    }
}
