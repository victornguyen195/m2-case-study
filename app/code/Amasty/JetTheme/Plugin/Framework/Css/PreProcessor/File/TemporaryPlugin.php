<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Plugin\Framework\Css\PreProcessor\File;

use Amasty\JetTheme\Model\ConfigProvider;
use Amasty\JetTheme\Model\StoreThemeMapper;
use Amasty\JetTheme\Model\TransferConfigProcessor\TransferConfigInterface;
use Magento\Framework\App\Area;
use Magento\Framework\Css\PreProcessor\File\Temporary;
use Magento\Store\Model\App\Emulation;

/**
 * Class TemporaryPlugin for transfer config values to static content deployed less file
 */
class TemporaryPlugin
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var array
     */
    private $transferConfigProcessors;

    /**
     * @var Emulation
     */
    private $emulation;

    /**
     * @var StoreThemeMapper
     */
    private $storeThemeMapper;

    public function __construct(
        ConfigProvider $configProvider,
        Emulation $emulation,
        StoreThemeMapper $storeThemeMapper,
        $transferConfigProcessors = []
    ) {
        $this->configProvider = $configProvider;
        $this->emulation = $emulation;
        $this->storeThemeMapper = $storeThemeMapper;
        $this->transferConfigProcessors = $transferConfigProcessors;
    }

    /**
     * @param Temporary $subject
     * @param string $relativePath
     * @param string $contents
     * @return string[]
     */
    public function beforeCreateFile(Temporary $subject, $relativePath, $contents): array
    {
        if (strpos($relativePath, "Amasty") !== false) {
            foreach ($this->transferConfigProcessors as $transferConfigProcessor) {
                $storeId = $this->storeThemeMapper->getStoreIdByThemeFilePath($relativePath);
                if (strpos($relativePath, $transferConfigProcessor->getFileNameToProcess()) !== false
                    && $transferConfigProcessor->isValidToProcess($storeId)
                ) {
                    $contents = $this->getFileContent($transferConfigProcessor, $storeId);
                    break;
                }
            }
        }

        return [$relativePath, $contents];
    }

    /**
     * @param TransferConfigInterface $transferConfigProcessor
     * @param string $storeId
     * @return string
     */
    private function getFileContent($transferConfigProcessor, $storeId): string
    {
        $this->configProvider->clean();
        $this->emulation->startEnvironmentEmulation($storeId, Area::AREA_FRONTEND);
        $content = $transferConfigProcessor->process();
        $this->emulation->stopEnvironmentEmulation();

        return $content;
    }
}
