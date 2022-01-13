<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\TransferConfigProcessor;

use Amasty\JetTheme\Model\Config\Source\Fonts\FontType;
use Amasty\JetTheme\Model\ConfigProvider;

class GoogleFont implements TransferConfigInterface
{
    const OUTPUT_LESS_FILE = 'css/source/_fonts-system.less';
    const TEMPLATE_FILE = '_fonts-system.template';

    /**
     * @var FileProcessor
     */
    private $fileProcessor;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(
        FileProcessor $fileProcessor,
        ConfigProvider $configProvider
    ) {
        $this->fileProcessor = $fileProcessor;
        $this->configProvider = $configProvider;
    }

    /**
     * Process styles config
     *
     * @return string
     */
    public function process(): string
    {
        return $this->fileProcessor->processFile(self::TEMPLATE_FILE);
    }

    public function getFileNameToProcess(): string
    {
        return self::OUTPUT_LESS_FILE;
    }

    /**
     * @param int|null $storeId
     * @return bool
     */
    public function isValidToProcess(?int $storeId): bool
    {
        return $this->configProvider->getFontType($storeId) == FontType::GOOGLE;
    }
}
