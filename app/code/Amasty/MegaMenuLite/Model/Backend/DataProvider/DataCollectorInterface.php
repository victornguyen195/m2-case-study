<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Model\Backend\DataProvider;

interface DataCollectorInterface
{
    public function execute(array $data, int $storeId, int $entityId): array;
}
