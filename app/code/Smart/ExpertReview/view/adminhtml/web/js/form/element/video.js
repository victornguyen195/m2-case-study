/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/form/element/abstract'
], function (Abstract) {
    'use strict';

    return Abstract.extend({
        defaults: {
            valueUpdate: 'input',
            isstring: true,
            validation: {
                'validate-url': true
            }
        },

        /**
         * @inheritdoc
         */
        onUpdate: function () {
            console.log(2);
            // this.validation['validate-digits'] = this.isInteger;
            // this._super();
        },
    });
});
