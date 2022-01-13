<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Api;

/**
 * Interface for managing cms blocks
 * @api
 */
interface CmsBlockManagementInterface
{
    /**
     * @return array
     */
    public function getAllBlocks(): array;

    /**
     * @param string $blockCode
     * @return array|null
     */
    public function getAttributesByBlockCode(string $blockCode): ?array;

    /**
     * @param string $blockCode
     * @param string $attributeCode
     * @return mixed
     */
    public function getAttributeValue(string $blockCode, string $attributeCode);
}
