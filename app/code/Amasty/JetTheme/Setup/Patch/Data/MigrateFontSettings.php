<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Setup\Patch\Data;

use Amasty\JetTheme\Model\Config\Source\Fonts\FontType;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class MigrateFontSettings implements DataPatchInterface
{
    const GOOGLE_FONT_SETTING = 'amasty_jettheme/fonts/enable_google_fonts';
    const FONT_TYPE_SETTING = 'amasty_jettheme/fonts/font_type';

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
            ->where('path = ?', self::GOOGLE_FONT_SETTING);

        foreach ($connection->fetchAll($select) as $config) {
            if (!$config['value']) {
                continue;
            }

            $connection->insertOnDuplicate(
                $this->resourceConfig->getTable($configTable),
                [
                    'scope_id' => $config['scope_id'],
                    'scope' => $config['scope'],
                    'value' => FontType::GOOGLE,
                    'path' => self::FONT_TYPE_SETTING
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
