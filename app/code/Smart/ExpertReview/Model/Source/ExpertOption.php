<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Smart\ExpertReview\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Smart\ExpertReview\Model\ResourceModel\Experts\CollectionFactory;

/**
 * Class ExpertOption
 */
class ExpertOption implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create();
        $options = [];
        foreach ($collection->getItems() as $expert) {
            $options[] = [
                'label' => $expert->getName(),
                'value' => $expert->getEntityId(),
            ];
        }
        return $options;
    }
}
