<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\SocialLink\ResourceModel\SocialLink;

use Amasty\JetTheme\Api\Data\SocialLinkInterface;
use Amasty\JetTheme\Model\SocialLink\ResourceModel\SocialLink as SocialLinkResource;
use Amasty\JetTheme\Model\SocialLink\SocialLink;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Helper;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Psr\Log\LoggerInterface;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var Helper
     */
    private $dbHelper;

    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        Helper $dbHelper,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {

        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->dbHelper = $dbHelper;
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            SocialLink::class,
            SocialLinkResource::class
        );
    }

    /**
     * @return Collection
     */
    protected function _beforeLoad()
    {
        $this->joinStores();

        return parent::_beforeLoad();
    }

    /**
     * @return void
     */
    public function joinStores(): void
    {
        $select = $this->getSelect();
        $select->joinLeft(
            ['stores' => $this->getTable(SocialLinkInterface::STORE_TABLE_NAME)],
            'main_table.'
            . SocialLinkInterface::ENTITY_ID
            . ' = stores.'
            . SocialLinkInterface::STORE_SOCIAL_ID_FIELD,
            []
        );

        $select->group('main_table.entity_id');
        $this->dbHelper->addGroupConcatColumn(
            $select,
            'stores',
            'stores.store_id'
        );
    }
}
