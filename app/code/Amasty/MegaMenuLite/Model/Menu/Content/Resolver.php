<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Model\Menu\Content;

use Amasty\MegaMenuLite\Model\Menu\Content\Resolver\GetVariableResolver;
use Magento\Framework\Data\Tree\Node;

class Resolver
{
    const CHILD_CATEGORIES = '{{child_categories_content}}';

    // @codingStandardsIgnoreLine
    const CHILD_CATEGORIES_PAGE_BUILDER = '<div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-element="inner" style="justify-content: flex-start; display: flex; flex-direction: column; background-position: left top; background-size: cover; background-repeat: no-repeat; background-attachment: scroll; border-style: none; border-width: 1px; border-radius: 0px; margin: 0px 0px 10px; padding: 10px;"><div data-content-type="ammega_menu_widget" data-appearance="default" data-element="main" style="border-style: none; border-width: 1px; border-radius: 0px; margin: 0px; padding: 0px;">{{child_categories_content}}</div></div></div>';

    /**
     * @var GetVariableResolver
     */
    private $getVariableResolver;

    public function __construct(GetVariableResolver $getVariableResolver)
    {
        $this->getVariableResolver = $getVariableResolver;
    }

    public function resolve(Node $node): ?string
    {
        if ($node->getIsCategory()) {
            $content = $this->parseVariables($node, $this->getDefaultContent());
        }

        return $content ?? null;
    }

    private function getDefaultContent(): string
    {
        return self::CHILD_CATEGORIES;
    }

    protected function parseVariables(Node $node, ?string $content): string
    {
        preg_match_all('@\{{(.+?)\}}@', $content, $matches);

        if (isset($matches[1]) && !empty($matches[1])) {
            foreach ($matches[1] as $match) {
                $result = '';

                switch ($match) {
                    case 'child_categories_content':
                        $result = $node->hasChildren()
                            ? $this->getVariableResolver->get('child_categories_content')->execute()
                            : '';
                        break;
                }

                $content = str_replace('{{' . $match . '}}', $result, $content);
            }
        }

        return $content;
    }
}
