var config = {
    config: {
        mixins: {
            'mage/gallery/gallery': {
                'js/gallery/gallery-mixin': true
            },
            'mage/collapsible': {
                'js/mage/collapsible-mixin': true
            },
            'mage/validation': {
                'js/mage/validation-mixin': true
            }
        }
    },
    map: {
        '*': {
            amPopup: 'js/am-popup',
            amCollapsible: 'js/am-collapsible',
            'fotorama/fotorama': 'js/gallery/fotorama-custom'
        }
    },
    paths: {
        slick: 'Amasty_Base/vendor/slick/slick.min'
    },
    shim: {
        slick: {
            deps: [ 'jquery' ]
        }
    }
};
