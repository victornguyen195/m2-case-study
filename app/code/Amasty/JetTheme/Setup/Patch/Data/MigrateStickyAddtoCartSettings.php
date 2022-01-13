<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Setup\Patch\Data;

use Amasty\JetTheme\Model\Config\Source\ProductPage\StickyAddToCart;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class MigrateStickyAddtoCartSettings implements DataPatchInterface
{
    const SETTING = 'amasty_jettheme/additional_elements/sticky_add_to_cart';

    /**
     * @var ConfigInterface
     */
    private $resourceConfig;

    public function __construct(ConfigInterface $resourceConfig)
    {
        $this->resourceConfig = $resourceConfig;
    }

    /**
     * @return $this
     */
    public function apply(): self
    {
        $connection = $this->resourceConfig->getConnection();
        $configTable = 'core_config_data';
        $select = $connection->select()->from($this->resourceConfig->getTable($configTable))
            ->where('path = ?', self::SETTING);

        foreach ($connection->fetchAll($select) as $config) {

            $connection->insertOnDuplicate(
                $this->resourceConfig->getTable($configTable),
                [
                    'scope_id' => $config['scope_id'],
                    'scope' => $config['scope'],
                    'value' => $config['value'] ? StickyAddToCart::SIDEBAR : StickyAddToCart::DISABLED,
                    'path' => $config['path']
                ]
            );
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
