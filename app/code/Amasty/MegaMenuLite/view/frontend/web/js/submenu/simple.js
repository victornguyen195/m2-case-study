/**
 *  Amasty simple submenu UI Component
 */

define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            activeElem: false,
            template: 'Amasty_MegaMenuLite/submenu/simple/wrapper',
            imports: {
                color_settings: "ammenu_wrapper:color_settings",
                is_icons_available: "ammenu_wrapper:is_icons_available",
                root_templates: "ammenu_wrapper:templates",
                animation_time: "ammenu_wrapper:animation_time"
            }
        },

        /**
         * Applying Bindings in target element
         */
        applyBindings: function (element) {
            ko.applyBindingsToDescendants(this, element);
            $(element).trigger('contentUpdated');
        }
    });
});
