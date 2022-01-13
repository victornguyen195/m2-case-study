var config = {
    map: {
        '*': {
            amProductTabCaret: 'Magento_Catalog/js/am-product-tab-caret',
            amReviewTab: 'Magento_Catalog/js/am-review-tab',
            productPriceBox: 'Magento_Catalog/js/product-price',
            amProductCaret: 'Magento_Catalog/js/am-product-caret',
            amStickyAddToCart: 'Magento_Catalog/js/am-sticky-addtocart',
            amCompareList: 'Magento_Catalog/js/am-compare-list',
            amStickyCompareLink: 'Magento_Catalog/js/am-sticky-compare-link',
            amAjaxCart: 'Magento_Catalog/js/am-ajax-cart',
            amAjaxCompare: 'Magento_Catalog/js/am-ajax-compare',
            amQuickView: 'Magento_Catalog/js/am-quick-view'
        }
    },

    config: {
        mixins: {
            'Magento_Catalog/js/price-options': {
                'Magento_Catalog/js/price-options-mixin': true
            },
            'Magento_Catalog/product/view/validation': {
                'Magento_Catalog/js/product/view/validation-mixin': true
            }
        }
    }
};
