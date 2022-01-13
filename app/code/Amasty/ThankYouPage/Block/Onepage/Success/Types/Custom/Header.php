<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Block\Onepage\Success\Types\Custom;

use Amasty\ThankYouPage\Block\Onepage\Success\Types\CustomAbstract;

/**
 * Header block
 */
class Header extends CustomAbstract
{
    const BLOCK_CONFIG_NAME = 'header';

    /**
     * Related group name in admin settings
     *
     * @return string
     */
    protected function getGroupPrefix(): string
    {
        return 'block_' . self::BLOCK_CONFIG_NAME;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->blockConfig->getWidthByBlockId(self::BLOCK_CONFIG_NAME);
    }
}
