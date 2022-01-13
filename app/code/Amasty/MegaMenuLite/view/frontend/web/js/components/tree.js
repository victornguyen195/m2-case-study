/**
 *  Amasty Category Tree UI Component
 */

define([
    'jquery',
    'ko',
    'uiComponent'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Amasty_MegaMenuLite/components/tree/wrapper',
            templates: {
                treeItems: 'Amasty_MegaMenuLite/components/tree/items'
            },
            imports: {
                root_templates: "ammenu_wrapper:templates",
                color_settings: "ammenu_wrapper:color_settings",
                is_icons_available: "ammenu_wrapper:is_icons_available",
                is_hamburger: "ammenu_wrapper:is_hamburger"
            }
        },

        /**
         *  Init Item
         */
        initItem: function () {
            if (this.level() > 1) {
                this.isIconVisible(this.parent.isChildHasIcons);
            } else {
                this.isIconVisible(this.icon);
            }

            this.isHover.extend({ rateLimit: 50 });
            this.isActive.extend({ rateLimit: 100 });
        }
    });
});
