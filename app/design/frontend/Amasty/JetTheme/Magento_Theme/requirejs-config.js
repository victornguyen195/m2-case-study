var config = {
    map: {
        '*': {
            backTop: 'Magento_Theme/js/components/back-to-top',
            amMenu: 'Magento_Theme/js/components/am-menu',
            amQty: 'Magento_Theme/js/components/am-qty',
            amSelect: 'Magento_Theme/js/components/am-select',
            amFileUpload: 'Magento_Theme/js/components/am-file-upload',
            amStickyHeader: 'Magento_Theme/js/components/am-sticky-header'
        }
    },

    config: {
        mixins: {
            'mage/validation': {
                'Magento_Theme/js/lib/mage/validation-mixin': true
            },
            'mage/menu': {
                'Magento_Theme/js/lib/mage/menu-mixin': true
            }
        }
    }
};
