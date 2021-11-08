<?php

namespace Smart\ExpertReview\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ExpertsInterface
 * @package Smart\ExpertReview\Api\Data
 */
interface ExpertsInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getPosition();

    /**
     * @param string $position
     * @return $this
     */
    public function setPosition($position);

    /**
     * @return string
     */
    public function getCompany();

    /**
     * @param string $company
     * @return $this
     */
    public function setCompany($company);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);
}
