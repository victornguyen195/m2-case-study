<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Model\Config\Source;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Convert\DataObject;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;

class CmsBlock implements OptionSourceInterface
{
    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;

    /**
     * @var DataObject
     */
    private $objectConverter;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        SearchCriteriaInterface $searchCriteria,
        DataObject $objectConverter
    ) {
        $this->blockRepository = $blockRepository;
        $this->searchCriteria = $searchCriteria;
        $this->objectConverter = $objectConverter;
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function toOptionArray(): array
    {
        $result = ['value' => 0, 'label' => __('Please, select a static block')];
        $items = $this->blockRepository->getList($this->searchCriteria)->getItems();

        $options = $this->prepapreOptions($items);
        if (empty($options) || array_shift($options) === null) {
            $options = $this->objectConverter->toOptionArray(
                $items,
                'block_id',
                'title'
            );
        }

        array_unshift($options, $result);

        return $options;
    }

    /**
     * The method inits options for old version of magento
     *
     * @param array $items
     *
     * @return array
     */
    private function prepapreOptions(array $items = []): array
    {
        $options = array_map(function ($item) {
            if (is_array($item)) {
                $value = $item['identifier'] ?: '';
                $label = $item['title'] ?: '';
                if ($value && $label) {
                    return ['value' => $value, 'label' => $label];
                }
            }
        }, $items);

        return $options;
    }
}
