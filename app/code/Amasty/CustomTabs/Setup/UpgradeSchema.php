<?php

declare(strict_types=1);

namespace Amasty\CustomTabs\Setup;

use Amasty\CustomTabs\Model\Tabs\ResourceModel\Tabs;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.2.0', '<')) {
            $this->addAnchorColumn($setup);
        }

        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     * @return void
     */
    public function addAnchorColumn(SchemaSetupInterface $setup): void
    {
        $tableName = $setup->getTable(Tabs::TABLE_NAME);
        $setup->getConnection()
            ->addColumn(
                $tableName,
                'anchor',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => '255',
                    'nullable' => true,
                    'default' => '',
                    'comment' => 'Anchor'
                ]
            );
    }
}
