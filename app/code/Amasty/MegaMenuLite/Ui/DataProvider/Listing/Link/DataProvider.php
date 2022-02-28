<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Ui\DataProvider\Listing\Link;

use Magento\Framework\Api\Filter;

class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**
     * @var array
     */
    private $mappedFields = [
        'entity_id' => 'main_table.entity_id'
    ];

    public function addFilter(Filter $filter): void
    {
        if (array_key_exists($filter->getField(), $this->mappedFields)) {
            $mappedField = $this->mappedFields[$filter->getField()];
            $filter->setField($mappedField);
        }

        parent::addFilter($filter);
    }
}
