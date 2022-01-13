<?php
/**
 * @author    Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package   Amasty_ThankYouPage
 */

declare(strict_types=1);

namespace Amasty\ThankYouPage\Model\Config\Backend;

use Magento\Framework\App\Config\Data\ProcessorInterface;
use Magento\Framework\App\Config\Value;

class Blocks extends Value implements ProcessorInterface
{

    /**
     * @return $this|\Magento\Framework\Model\AbstractModel
     */
    public function beforeSave()
    {
        $this->setValue(trim(implode(',', $this->getValue()), ','));

        return $this;
    }

    /**
     * Process config value
     *
     * @param string $value
     *
     * @return string
     */
    public function processValue($value)
    {
        return $value;
    }
}
