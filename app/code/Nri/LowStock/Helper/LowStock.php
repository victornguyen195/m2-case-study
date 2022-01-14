<?php

namespace Nri\LowStock\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class LowStock extends AbstractHelper
{
    const XML_PATH_LOW_STOCK = 'low_stock_config/general/';

    /**
     * @param $field
     * @param $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @param $code
     * @param $storeId
     * @return mixed
     */
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_LOW_STOCK . $code, $storeId);
    }
}
