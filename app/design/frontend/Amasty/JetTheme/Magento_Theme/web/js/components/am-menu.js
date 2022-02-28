/**
 *   Navigation menu behavior
 */

define([
    'jquery',
    'matchMedia'
], function ($, mediaCheck) {
    'use strict';

    $.widget('mage.amMenu', {
        options: {
            mediaBreakpoint: '(min-width: 767px)',
            itemsSelector: 'li.level0',
            itemActiveSelector: 'li.level0.active, li.level0.has-active',
            submenuSelector: '.level0.submenu',
            activeCustomClass: 'amtheme-active-item',
            submenuClass: 'amtheme-menu-flex',
            mobile: {
                headerSelector: '.header .block-search.-header > .block-content',
                navSelector: '.sections.nav-sections',
                toogleNavSelector: '[data-action="toggle-nav"]',
                minicart: '[data-amtheme-js="minicart"]'
            }
        },

        /**
         * Widget initialization
         * @private
         * @returns {void}
         */
        _create: function () {
            var self = this,
                wasDesktop = false;

            mediaCheck({
                media: self.options.mediaBreakpoint,
                entry: function () {
                    self.desktopBehavior();
                    wasDesktop = true;
                },
                exit: function () {
                    if (wasDesktop) {
                        self.resetDesktopBehavior();
                    }

                    self.mobileBehavior();
                }
            });
        },

        /**
         * Visual hover behavior for desktop
         * @returns {void}
         */
        desktopBehavior: function () {
            var navigation = this.element,
                items = this.options.itemsSelector,
                itemActive = $(this.options.itemActiveSelector),
                cssClass = this.options.activeCustomClass;

            itemActive.addClass(cssClass);
            this.submenuAppereance();

            navigation.find(items).on('mouseover.ammenu', function () {
                itemActive.removeClass(cssClass);
            });

            navigation.find(items).on('mouseout.ammenu', function () {
                itemActive.addClass(cssClass);
            });
        },

        /**
         * Submenu styles for desktop
         * @returns {void}
         */
        submenuAppereance: function () {
            var navigation = this.element,
                submenu = navigation.find(this.options.submenuSelector),
                cssClass = this.options.submenuClass,
                item;

            $.each(submenu, function (index, menu) {
                item = $(menu);

                if (item.has('li.parent').length) {
                    item.addClass(cssClass).hide();
                }
            });
        },

        /**
         * Reset visual behavior for desktop
         * @returns {void}
         */
        resetDesktopBehavior: function () {
            var navigation = this.element,
                items = $(this.options.itemsSelector);

            navigation.find(items).off('.ammenu');
        },

        /**
         * Mobile behavior
         * @returns {void}
         */
        mobileBehavior: function () {
            var toogleNav = $(this.options.mobile.toogleNavSelector);

            this.setMobilePosition();

            toogleNav.on('touchstart.amtheme', function () {
                $('html, body').animate({
                    scrollTop: '0'
                });
            });

            $(this.options.mobile.minicart).on('touchstart.amtheme', function () {
                if ($('html').hasClass('nav-open')) {
                    toogleNav.trigger('click');
                }
            });
        },

        /**
         * Set top position of menu
         * @returns {void}
         */
        setMobilePosition: function () {
            var nav = $(this.options.mobile.navSelector),
                headerTop = $(this.options.mobile.headerSelector).position().top;

            nav.css({
                'top': headerTop
            });
        }
    });

    return $.mage.amMenu;
});
