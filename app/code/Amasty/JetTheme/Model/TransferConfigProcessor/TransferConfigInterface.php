<?php

declare(strict_types=1);

namespace Amasty\JetTheme\Model\TransferConfigProcessor;

interface TransferConfigInterface
{
    /**
     * Process styles config
     *
     * @return string
     */
    public function process(): string;

    /**
     * @return string
     */
    public function getFileNameToProcess(): string;

    /**
     * @param int|null $storeId
     * @return bool
     */
    public function isValidToProcess(?int $storeId): bool;
}
