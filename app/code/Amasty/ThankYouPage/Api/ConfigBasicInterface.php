<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Api;

interface ConfigBasicInterface
{

    /**
     * @return bool
     */
    public function isBlockEnabled(): bool;

    /**
     * @param string $prefix
     *
     * @return ConfigBasicInterface
     */
    public function setGroupPrefix(string $groupPrefix): ConfigBasicInterface;
}
