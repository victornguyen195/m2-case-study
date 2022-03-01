<?php

namespace Dev\Banner\Model;

class Banner extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'dev_banner_banner';

	protected $_cacheTag = 'dev_banner_banner';

	protected $_eventPrefix = 'dev_banner_banner';

    // Define resource model
	protected function _construct()
	{
		$this->_init('Dev\Banner\Model\ResourceModel\Banner');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}
