<?php

namespace Dev\Banner\Model;

use Dev\Banner\Api\Data\BannerInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Banner extends AbstractExtensibleModel implements \Magento\Framework\DataObject\IdentityInterface, BannerInterface
{
    const CACHE_TAG = 'dev_banner_banner';
    const NAME = 'name';
    const STATUS = 'status';
    const IMAGE = 'image';
    const SHORT_DESCRIPTION = 'short_description';

    protected $_cacheTag = 'dev_banner_banner';

    protected $_eventPrefix = 'dev_banner_banner';

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

    /**
     * @return mixed|string|null
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @param $name
     * @return $this|Banner
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    /**
     * @return mixed|string|null
     */
    public function getImage()
    {
        return $this->_getData(self::IMAGE);
    }

    /**
     * @param $image
     * @return $this|Banner
     */
    public function setImage($image)
    {
        $this->setData(self::IMAGE, $image);
        return $this;
    }

    /**
     * @return mixed|string|null
     */
    public function getStatus()
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * @param $status
     * @return $this|Banner
     */
    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
        return $this;
    }

    /**
     * @return mixed|string|null
     */
    public function getShortDescription()
    {
        return $this->_getData(self::SHORT_DESCRIPTION);
    }

    /**
     * @param $shortDescription
     * @return $this|Banner
     */
    public function setShortDescription($shortDescription)
    {
        $this->setData(self::SHORT_DESCRIPTION, $shortDescription);
        return $this;
    }
}
