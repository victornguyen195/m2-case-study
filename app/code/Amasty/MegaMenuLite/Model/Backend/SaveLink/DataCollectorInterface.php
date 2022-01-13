<?php

declare(strict_types=1);

namespace Amasty\MegaMenuLite\Model\Backend\SaveLink;

interface DataCollectorInterface
{
    public function execute(array $data): array;
}
