/**
 *  Amasty Top Menu Item elements UI Component
 */

define([
    'ko',
    'uiComponent',
    'uiRegistry',
    'ammenu_helpers'
], function (ko, Component, registry, helpers) {
    'use strict';

    return Component.extend({
        defaults: {
            imports: {
                root_templates: 'index = ammenu_wrapper:templates',
                is_icons_available: 'index = ammenu_wrapper:is_icons_available'
            },
            components: [
                'index = ammenu_wrapper'
            ]
        },

        /**
         * Hamburger init method
         */
        initialize: function () {
            var self = this;

            self._super();

            registry.get(self.components, function () {
                helpers.initComponentsArray(arguments, self);

                self.ammenu.initElem(self.item, 0, null, self.elemIndex);
                self.item.isActive.extend({ rateLimit: 100 });

                if (self.item.elems.length) {
                    self.ammenu.initElems(self.item.elems, 1, self.item);
                }
            });
        }
    });
});
