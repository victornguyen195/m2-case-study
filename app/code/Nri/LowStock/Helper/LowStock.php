<?php

namespace Nri\LowStock\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class LowStock extends AbstractHelper
{
    const XML_PATH_LOW_STOCK = 'low-stock-config/general/low-stock-quantity';

    /**
     * @param string $field
     * @param $storeId
     * @return mixed
     */
    public function getLowStockConfigValue(string $field = self::XML_PATH_LOW_STOCK, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }
}
