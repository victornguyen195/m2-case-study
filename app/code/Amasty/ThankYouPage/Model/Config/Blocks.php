<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Model\Config;

use Amasty\ThankYouPage\Model\Config;
use Magento\Framework\Config\ReaderInterface;
use Magento\Framework\Config\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;

class Blocks extends Data
{
    const PERCENT_OF_WIDTH = 100;

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        ReaderInterface $reader,
        CacheInterface $cache,
        SerializerInterface $serializer,
        $cacheId,
        Config $config
    ) {
        parent::__construct($reader, $cache, $serializer, $cacheId);
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getSortedBlocks(): array
    {
        if ($this->config->isMarkupEnabled()) {
            $sortingBlocks = $this->replaceMarkupBraces();
        } else {
            $sortingBlocks = $this->config->getBlockSorting();
        }

        return $this->getSortedBlocksByConfigValue($sortingBlocks);
    }

    /**
     * Sort blocks according to settings
     *
     * @param string $configValue
     *
     * @return array
     */
    public function getSortedBlocksByConfigValue(string $configValue): array
    {
        // Get blocks configuration from block_types.xml
        $blocks = $this->getBlockTypes();

        // Sorting setting value represented as comma separated block ids
        $currentValueKeys = array_flip(preg_split('/[.|,]/', (string)$configValue));

        // Ignore blocks which do not exist in block_types.xml
        $currentValueKeys = array_intersect_key($currentValueKeys, $blocks);

        // Pick up new blocks which were just added to block_types.xml but are missing in $currentValueKeys
        $newBlocks = array_diff_key($blocks, $currentValueKeys);

        // Sorting blocks based on $currentValueKeys
        $sortedBlocks = array_merge($currentValueKeys, $blocks);

        $resultBlocks = $newBlocks + $sortedBlocks;

        if ($this->config->isMarkupEnabled()) {
            foreach ($resultBlocks as $key => $block) {
                if (!array_key_exists($key, $currentValueKeys)) {
                    unset($resultBlocks[$key]);
                }
            }
        }

        return $resultBlocks;
    }

    /**
     * @return array
     */
    private function getBlockTypes(): array
    {
        return $this->get('types');
    }

    /**
     * @param string $blockId
     *
     * @return int
     */
    public function getWidthByBlockId(string $blockId): int
    {
        $width = self::PERCENT_OF_WIDTH;

        if ($this->config->isMarkupEnabled()) {
            $blockLine = [];

            $blockLines = $this->splitMarkupBlocks();
            $this->deleteDisabledBlocks($blockLines);

            foreach ($blockLines as $blockLine) {
                if (in_array($blockId, $blockLine)) {
                    break;
                }
            }

            $blockLineCount = count($blockLine) != 0 ? count($blockLine) : 1;
            $width = floor(self::PERCENT_OF_WIDTH / $blockLineCount);
        }

        return (int)$width;
    }

    /**
     * @return array
     */
    private function splitMarkupBlocks(): array
    {
        $blocksLines = explode('.', $this->replaceMarkupBraces());

        foreach ($blocksLines as $key => $blockLine) {
            $blocksLines[$key] = explode(',', $blockLine);
        }

        return $blocksLines;
    }

    /**
     * @param array $blockLines
     */
    private function deleteDisabledBlocks(array &$blockLines): void
    {
        foreach ($blockLines as $blockLineKey => $blockLine) {
            foreach ($blockLine as $blockKey => $block) {
                if (!$this->config->isBlockEnabled($block)) {
                    unset($blockLines[$blockLineKey][$blockKey]);
                }
            }
        }
    }

    /**
     * @return string
     */
    private function replaceMarkupBraces(): string
    {
        return str_replace(['{{', '}}'], '', $this->config->getMarkupEditor());
    }

    /**
     * @return bool
     */
    public function isMarkupEnabled(): bool
    {
        return $this->config->isMarkupEnabled();
    }
}
