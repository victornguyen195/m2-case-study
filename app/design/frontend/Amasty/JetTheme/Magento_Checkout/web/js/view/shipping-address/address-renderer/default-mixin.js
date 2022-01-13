/**
 * Mixin for shipping address form visibility, instead popup view
 */
define([
    'Magento_Checkout/js/model/form-address-state',
    'Magento_Checkout/js/model/shipping-address/form-popup-state'
], function (formState, formPopUpState) {
    'use strict';

    var mixin = {
        isEditVisible: formState.isVisible,

        /*
         * Trigger form visibility
         * return {void}
         */
        editNewAddress: function () {
            var amCheckout = window.amasty_checkout_disabled;

            if (!amCheckout && typeof amCheckout !== 'undefined') {
                formPopUpState.isVisible(true);
            } else {
                formState.isVisible(true);
            }
        }
    };

    return function (AddressRenderer) {
        return AddressRenderer.extend(mixin);
    };
});
