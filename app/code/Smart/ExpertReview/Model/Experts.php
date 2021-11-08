<?php

namespace Smart\ExpertReview\Model;

use Magento\Framework\Model\AbstractModel;
use Smart\ExpertReview\Api\Data\ExpertsInterface;

class Experts extends AbstractModel implements ExpertsInterface
{
    const ENTITY_ID = 'entity_id';
    const NAME = 'name';
    const COMPANY = 'company';
    const POSITION = 'position';
    const CREATED_AT = 'created_at';

    protected function _construct()
    {
        $this->_init(\Smart\ExpertReview\Model\ResourceModel\Experts::class);
    }

    /**
     * @return int
     */
    public function getEntityId(){
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId){
        $this->setData(self::ENTITY_ID,$entityId);
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->getData(self::NAME);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name){
        $this->setData(self::NAME,$name);
        return $this;
    }

    /**
     * @return string
     */
    public function getPosition(){
        return $this->getData(self::POSITION);
    }

    /**
     * @param string $position
     * @return $this
     */
    public function setPosition($position){
        $this->setData(self::POSITION,$position);
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany(){
        return $this->getData(self::COMPANY);
    }

    /**
     * @param string $company
     * @return $this
     */
    public function setCompany($company){
        $this->setData(self::COMPANY,$company);
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(){
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt){
        $this->setData(self::CREATED_AT,$createdAt);
        return $this;
    }
}
