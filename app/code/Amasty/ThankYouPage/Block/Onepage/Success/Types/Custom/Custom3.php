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
 * Abstraction for Header and custom blocks
 */
class Custom3 extends CustomAbstract
{
    const BLOCK_CONFIG_NAME = 'custom3';

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
