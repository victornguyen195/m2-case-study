<?php

namespace Nri\LowStock\ViewModel\LowStock;

use Magento\Framework\Registry;
use Nri\LowStock\Helper\LowStock as LowStockHelper;
use Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku;

class LowStock implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    const LOW_STOCK_QUANTITY_KEY_CONFIG = 'low_stock_quantity';
    const LOW_STOCK_MESSAGE_KEY_CONFIG = 'low_stock_message';
    const OUT_OF_STOCK_MESSAGE_KEY_CONFIG = 'out_stock_message';

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var LowStockHelper
     */
    protected $lowStockHelper;

    /**
     * @var GetSalableQuantityDataBySku
     */
    protected $getSalableQuantityDataBySku;


    /**
     * @param Registry $registry
     * @param LowStockHelper $lowStockHelper
     * @param GetSalableQuantityDataBySku $getSalableQuantityDataBySku
     */
    public function __construct(
        Registry $registry,
        LowStockHelper $lowStockHelper,
        GetSalableQuantityDataBySku $getSalableQuantityDataBySku
    ) {
        $this->_registry = $registry;
        $this->lowStockHelper = $lowStockHelper;
        $this->getSalableQuantityDataBySku = $getSalableQuantityDataBySku;
    }

    /**
     * @return string
     */
    public function getLowStockMessageMessage(): string
    {
        $currentProduct = $this->_registry->registry('current_product');
        $lowStockQuantity = $this->lowStockHelper->getGeneralConfig(self::LOW_STOCK_QUANTITY_KEY_CONFIG);
        // Using salable quantity instead of normal quantity
        $salableQuantity = $this->getSalableQuantityDataBySku->execute($currentProduct->getSku());
        $quantity = 0;
        if (isset($salableQuantity[0]['qty']) && $salableQuantity[0]['qty']) {
            $quantity = $salableQuantity[0]['qty'];
        }

        if (!$quantity) {
            return $this->lowStockHelper->getGeneralConfig(self::OUT_OF_STOCK_MESSAGE_KEY_CONFIG);
        }

        if ($quantity <= $lowStockQuantity) {
            return $this->lowStockHelper->getGeneralConfig(self::LOW_STOCK_MESSAGE_KEY_CONFIG);
        }

        return '';
    }
}
