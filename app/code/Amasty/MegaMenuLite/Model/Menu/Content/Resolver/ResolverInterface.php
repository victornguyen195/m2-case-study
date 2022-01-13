<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Model\Menu\Content\Resolver;

interface ResolverInterface
{
    /**
     * @return string
     */
    public function execute(): string;
}
