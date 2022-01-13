/**
 *  Amasty Hamburger toggle UI Component
 */

define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            links: {
                color_settings: "ammenu_wrapper:color_settings"
            }
        },

        /**
         * Init observable variables
         *
         * @return {Object}
         */
        initObservable: function () {
            this._super()
                .observe({
                    isOpen: false,
                    color_settings: false
                });

            return this;
        },

        /**
         *  Toggling open state method
         */
        toggling: function () {
            this.isOpen(!this.isOpen());
        }
    });
});
