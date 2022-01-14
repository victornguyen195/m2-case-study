<?php

namespace Nri\LowStock\ViewModel\LowStock;

use Magento\Framework\Registry;
use Nri\LowStock\Helper\LowStock as LowStockHelper;
use Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku;
use Magento\Cms\Block\Block as CmsBlock;

class LowStock implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    const LOW_STOCK_QUANTITY_KEY_CONFIG = 'low_stock_quantity';
    const LOW_STOCK_MESSAGE_KEY = 'low-stock';
    const OUT_OF_STOCK_MESSAGE_KEY = 'out-of-stock';

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
     * @var
     */
    protected $cms;

    /**
     * @param Registry $registry
     * @param LowStockHelper $lowStockHelper
     * @param GetSalableQuantityDataBySku $getSalableQuantityDataBySku
     * @param CmsBlock $cmsblock
     */
    public function __construct(
        Registry $registry,
        LowStockHelper $lowStockHelper,
        GetSalableQuantityDataBySku $getSalableQuantityDataBySku,
        CmsBlock $cmsblock
    ) {
        $this->_registry = $registry;
        $this->lowStockHelper = $lowStockHelper;
        $this->getSalableQuantityDataBySku = $getSalableQuantityDataBySku;
        $this->cmsblock = $cmsblock;
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
            return $this->cmsblock->setBlockId(self::OUT_OF_STOCK_MESSAGE_KEY)->toHtml();
        }

        if ($quantity <= $lowStockQuantity) {
            return $this->cmsblock->setBlockId(self::LOW_STOCK_MESSAGE_KEY)->toHtml();
        }

        return '';
    }
}
