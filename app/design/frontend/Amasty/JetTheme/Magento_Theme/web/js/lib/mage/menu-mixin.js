/**
 * Expand active submenu for mobile
 */

define([
    'jquery',
    'matchMedia'
], function ($, mediaCheck) {
    'use strict';

    var mixin = {
        options: {
            mediaBreakpoint: '(max-width: 767px)',
            menuStaticWrapperClass: 'amtheme-menustatic-wrapper',
            selectors: {
                itemActiveSelector: 'li.level0.active, li.level0.has-active',
                activeAllCategorySelector: '.level0.active .ui-menu-item.all-category',
                allSelectorsForWrapper: '.header.content .logo, '
                    + '.header.content .amtheme-icons-container, '
                    + '.header.content .amtheme-navigation-icon'
            }
        },

        /**
         * Toggle.
         * @returns {void}
         */
        toggle: function () {
            var html = $('html');

            if (this._checkIsMobile()) {
                if (!html.hasClass('nav-open')) {
                    this._expandActiveSubmenu();
                    this._wrapElement();
                } else {
                    this._unwrapElement();
                }
            }

            this._super();
        },

        /**
         * Private
         * Check mobile device
         * @returns {boolean}
         */
        _checkIsMobile: function () {
            var self = this,
                isMobile = false;

            mediaCheck({
                media: self.options.mediaBreakpoint,
                entry: function () {
                    isMobile = true;
                },
                exit: function () {
                    isMobile = false;

                    if ($('.' + self.options.menuStaticWrapperClass).length) {
                        self._unwrapElement();
                    }
                }
            });

            return isMobile;
        },

        /**
         * Private
         * Expand active submenu.
         * @returns {void}
         */
        _expandActiveSubmenu: function () {
            var activeItemMenu = $(this.options.selectors.itemActiveSelector),
                activeAllCategory = $(this.options.selectors.activeAllCategorySelector);

            if (activeItemMenu.children('a').attr('aria-haspopup')) {
                activeItemMenu.trigger('click');
            }

            if (window.location.href.includes(activeAllCategory.children('a').attr('href'))) {
                activeAllCategory.addClass('active');
            }
        },

        /**
         * Private
         * Wrap elements.
         * @returns {void}
         */
        _wrapElement: function () {
            $(this.options.selectors.allSelectorsForWrapper)
                .wrapAll('<div class=" ' + this.options.menuStaticWrapperClass + ' " />');
        },

        /**
         * Private
         * Unwrap element.
         * @returns {void}
         */
        _unwrapElement: function () {
            $(this.options.selectors.allSelectorsForWrapper).unwrap();
        }
    };

    return function (MobileMenu) {
        $.widget('mage.menu', MobileMenu.menu, mixin);

        return {
            menu: $.mage.menu,
            navigation: $.mage.navigation
        };
    };
});
