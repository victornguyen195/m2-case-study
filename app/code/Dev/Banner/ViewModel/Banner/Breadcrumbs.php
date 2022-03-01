<?php

namespace Dev\Banner\ViewModel\Banner;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Url\Helper\Data as UrlHelper;

/**
 * Check is available add to compare.
 */
class Breadcrumbs implements ArgumentInterface
{
    /**
     * @return array[]
     */
    public function getBreadcrumbs()
    {
        return [
            [
                'name' => 'dev',
                'label' => 'Dev',
                'title' => 'Dev',
                'link' => '#'
            ],
            [
                'name' => 'banner',
                'label' => 'Banner',
                'title' => 'Banner',
                'link' => '#'
            ],
            [
                'name' => 'banner_detail',
                'label' => 'Banner Detail',
                'title' => 'Banner Detail',
                'link' => '#'
            ]
        ];
    }
}
