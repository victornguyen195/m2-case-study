/**
 * Amasty MegaMenu helpers
 */

define([
    'jquery',
    'mage/cookies'
], function ($) {
    'use strict';

    return {
        selectors: {
            formKeyInput: 'input[name="form_key"]'
        },
        formKey: $.mage.cookies.get('form_key'),

        /**
         * Update Form Key
         *
         * @params {Object} node
         *
         * @desc Updating inner form key inserting
         */
        updateFormKey: function (node) {
            var self = this,
                formKeyInput = $(node).find(self.selectors.formKeyInput);

            if (formKeyInput.val() !== self.formKey) {
                formKeyInput.val(self.formKey);
            }
        },

        /**
         * Components Array initialization and setting in target component
         *
         * @param {Array} array target uiClasses
         * @param {Object} component current uiClass
         */
        initComponentsArray: function (array, component) {
            _.each(array, function (item) {
                component[item.uniq_name] = item;
            });
        }
    }
});
