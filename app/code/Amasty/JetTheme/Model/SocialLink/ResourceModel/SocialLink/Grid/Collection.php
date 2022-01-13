<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\SocialLink\ResourceModel\SocialLink\Grid;

use Amasty\JetTheme\Api\Data\SocialLinkInterface;
use Amasty\JetTheme\Model\SocialLink\ResourceModel\SocialLink;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\DB\Helper;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

class Collection extends SearchResult
{
    /**
     * @var Helper
     */
    protected $dbHelper;

    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        Helper $dbHelper,
        $mainTable = SocialLinkInterface::TABLE_NAME,
        $resourceModel = SocialLink::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
        $this->dbHelper = $dbHelper;
    }

    /**
     * Set resource model and determine field mapping
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_map['fields']['stores'] = 'stores.store_id';
        parent::_construct();
    }

    /**
     * @inheritdoc
     */
    protected function _renderFiltersBefore()
    {
        $this->joinStores();
        parent::_renderFiltersBefore();
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
