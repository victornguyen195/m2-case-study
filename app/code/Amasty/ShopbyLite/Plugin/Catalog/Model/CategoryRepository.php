<?php

namespace Amasty\ShopbyLite\Plugin\Catalog\Model;

use Magento\Catalog\Model\CategoryRepository as MagentoCategoryRepository;

/**
 * Class CategoryRepository
 */
class CategoryRepository
{
    /**
     * Categories filter multiselect
     *
     * @param CategoryRepository $subject
     * @param $categoryId
     * @param null $storeId
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormatParameter)
     */
    public function beforeGet(MagentoCategoryRepository $subject, $categoryId, $storeId = null)
    {
        if (is_array($categoryId)) {
            $categoryId = array_shift($categoryId);
        }
        return [$categoryId, $storeId];
    }
}
