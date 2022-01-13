<?php

namespace Amasty\CustomTabs\Model\Layout;

/**
 * Class GeneratorPool
 */
class GeneratorPool extends \Magento\Framework\View\Layout\GeneratorPool
{
    /**
     * @inheritdoc
     */
    protected function addGenerators(array $generators)
    {
        $this->generators = [];
    }
}
