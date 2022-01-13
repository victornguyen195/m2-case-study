<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Model\Menu\Content\Resolver;

class GetChildCategoriesContent implements ResolverInterface
{
    public function execute(): string
    {
        return '<!-- ko scope: "index = tree_wrapper" --> '
            . '<!-- ko template: getTemplate() --><!-- /ko --> '
            . '<!-- /ko -->';
    }
}
