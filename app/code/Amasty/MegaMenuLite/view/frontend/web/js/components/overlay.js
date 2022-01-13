/**
 *  Amasty Menu Overlay UI Component
 */

define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Amasty_MegaMenuLite/components/overlay'
        },

        /**
         * Init observable variables
         *
         * @return {Object}
         */
        initObservable: function () {
            this._super()
                .observe({
                    'isVisible': false
                });

            return this;
        },

        /**
         * Overlay init method
         */
        initialize: function () {
            var self = this;

            self._super();

            if (self.source) {
                self.source.isOpen.subscribe(function (value) {
                    self.isVisible(value);
                });
            }
        },

        /**
         * Hamburger button toggling method
         */
        toggling: function () {
            this.source.isOpen(!this.source.isOpen());
        }
    });
});
