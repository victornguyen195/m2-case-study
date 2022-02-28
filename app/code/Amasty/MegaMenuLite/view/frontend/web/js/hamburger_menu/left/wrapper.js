/**
 *  Amasty Hamburger Wrapper UI Component
 */

define([
    'jquery',
    'ko',
    'underscore',
    'uiComponent',
    'uiRegistry',
    'ammenu_helpers'
], function ($, ko, _, Component, registry, helpers) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Amasty_MegaMenuLite/hamburger_menu/left/wrapper',
            templates: {
                link: 'Amasty_MegaMenuLite/hamburger_menu/left/items/link',
                items: 'Amasty_MegaMenuLite/hamburger_menu/left/items/wrapper',
                submenu: 'Amasty_MegaMenuLite/submenu/wrapper'
            },
            imports: {
                root_templates: "ammenu_wrapper:templates",
                welcome_message: "ammenu_wrapper:welcome_message",
                isChildHasIcons: "ammenu_wrapper:isChildHasIcons",
                color_settings: "ammenu_wrapper:color_settings",
                isMobile: "ammenu_wrapper:isMobile",
                is_hamburger: "ammenu_wrapper:is_hamburger",
                is_icons_available: "ammenu_wrapper:is_icons_available",
                mobile_class: "ammenu_wrapper:mobile_class",
                isOpen: "hamburger_toggle:isOpen"
            },
            components: [
                'index = ammenu_wrapper'
            ]
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
                    welcome_message: false,
                    isHeaderActive: true,
                    isTitleActive: true
                });

            this.welcome_message.backgroundColor = ko.observable(false);

            return this;
        },

        /**
         * Hamburger init method
         */
        initialize: function () {
            var self = this;

            self._super();

            registry.get(self.components, function () {
                helpers.initComponentsArray(arguments, self);

                self.welcome_message.backgroundColor(self.color_settings.category_hover_color);

                if (self.isMobile || !self.is_hamburger) {
                    return false;
                }

                self.isOpen.subscribe(function (value) {
                    if (!value) {
                        self.clearItems()
                    }
                });

                self.initElems();
            });
        },

        /**
         * Elements init method
         */
        initElems: function () {
            var self = this,
                elems = self.source.data.elems.filter(function (item) {
                    return item.is_category;
                });

            self.ammenu.initElems(elems, 0, self.source);

            self.elems(elems);

            self.elems.each(function (elem) {
                elem.isIconVisible(elem.parent.isChildHasIcons && self.is_icons_available);
            });
        },

        /**
         * Toggling button method
         *
         * @params {item}
         */
        toggleItem: function (item) {
            if (!item.isActive()) {
                this.clearItems();
            }

            item.isActive(!item.isActive());
        },

        /**
         * Clearing items method
         */
        clearItems: function () {
            this.elems.each(function (elem) {
                if (elem.isActive()) {
                    elem.isActive(false);

                    return false;
                }
            });
        }
    });
});
