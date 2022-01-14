<?php

namespace Nri\LowStock\Setup\Patch\Data;

use Exception;
use Magento\Cms\Model\BlockFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddLowStockMessage implements DataPatchInterface
{
    /**
     * ModuleDataSetupInterface
     *
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * EavSetupFactory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var BlockFactory 
     */
    protected $blockFactory;

    /**
     * AddProductAttribute constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        BlockFactory $blockFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function apply()
    {
        $this->addLowStockBlock();
        $this->addOutOfStockBlock();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function addOutOfStockBlock()
    {
        $outOfStockBlock = [
            'title' => 'Out of stock message',
            'identifier' => 'out-of-stock',
            'stores' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            'is_active' => 1,
            'content' => '<p style="color: red; font-size: 1.2rem;">在庫切れのため、お買い物カゴに投入できません。</p>'
        ];

        $this->moduleDataSetup->startSetup();
        $block = $this->blockFactory->create();
        $block->setData($outOfStockBlock)->save();
        $this->moduleDataSetup->endSetup();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function addLowStockBlock()
    {
        $lowStockBlock = [
            'title' => 'Low stock message',
            'identifier' => 'low-stock',
            'stores' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            'is_active' => 1,
            'content' => '<p style="color: red; font-size: 1.2rem;">在庫が残りわずかです。</p>'
        ];

        $this->moduleDataSetup->startSetup();
        $block = $this->blockFactory->create();
        $block->setData($lowStockBlock)->save();
        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
