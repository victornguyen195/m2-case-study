<?php

namespace Dev\ExpertReview\Model\ResourceModel\Expert;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'expert_id';

	protected $_eventObject = 'expert_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
        // <model>-<resource-model>
		$this->_init('Dev\ExpertReview\Model\Expert', 'Dev\ExpertReview\Model\ResourceModel\Expert');
	}
}
