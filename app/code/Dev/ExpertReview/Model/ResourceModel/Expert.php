<?php

namespace Dev\ExpertReview\Model\ResourceModel;

class Expert extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	) {
		parent::__construct($context);
	}

	protected function _construct()
	{
        // <main-table>-<primary-key>
		$this->_init('experts', 'expert_id');
	}
}
