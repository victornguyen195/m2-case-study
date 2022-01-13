var config = {
    config: {
        mixins: {
            'quickSearch': {
                'Magento_Search/js/form-mini-mixin': true
            },
            'Magento_Search/js/form-mini': {
                'Magento_Search/js/form-mini-mixin': true
            }
        }
    },
    map: {
        '*': {
            amSearch: 'Magento_Search/js/am-search'
        }
    }
};
