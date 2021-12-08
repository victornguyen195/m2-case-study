<?php

namespace Dev\Banner\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface BannerInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param $image
     * @return $this
     */
    public function setImage($image);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getShortDescription();

    /**
     * @param $shortDescription
     * @return $this
     */
    public function setShortDescription($shortDescription);
}
