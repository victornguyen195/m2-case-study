<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Block\Onepage\Success\Types;

interface TypesInterface
{

    /**
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * @return string
     */
    public function toHtml();
}
