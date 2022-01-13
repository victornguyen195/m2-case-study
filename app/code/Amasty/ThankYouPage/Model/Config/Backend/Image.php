<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Model\Config\Backend;

use Magento\Config\Model\Config\Backend\Image as ImageConfig;

class Image extends ImageConfig
{

    /**
     * @return string[]
     */
    protected function _getAllowedExtensions()
    {
        return ['png', 'jpg', 'jpe', 'jpeg', 'gif'];
    }
}
