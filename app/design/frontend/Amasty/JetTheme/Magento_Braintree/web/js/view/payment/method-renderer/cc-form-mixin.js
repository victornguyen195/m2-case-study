/**
 * Mixin for Braintree compatibility with Magento 2.3.0
 */

define([
    'jquery'
], function () {
    'use strict';

    var mixin = {
        /**
         * Check is it exist
         * @return {void}
         */
        amthemeHostedFields: function () {
            if (typeof this.initHostedFields === 'function') {
                this.initHostedFields();
            }
        }
    };

    return function (CcForm) {
        return CcForm.extend(mixin);
    };
});
