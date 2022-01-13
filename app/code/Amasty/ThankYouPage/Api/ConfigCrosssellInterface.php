<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Api;

interface ConfigCrosssellInterface extends ConfigBasicInterface
{

    /**
     * @return string
     */
    public function getProductLimit(): string;

    /**
     * @return bool
     */
    public function isShowOutOfStock(): bool;
}
