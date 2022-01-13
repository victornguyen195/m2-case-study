/**
 * Mixin for deferred rendering breadcrumbs after loading the menu
 */

define([
    'jquery',
    'rjsResolver',
    'Magento_Theme/js/model/breadcrumb-list',
], function ($, resolver, breadcrumbList) {
    'use strict';

    var breadcrumbsMixin = {

        /**
         * Initialization
         */
        _init: function () {
            var self = this;

            self._super();

            resolver(function () {
                breadcrumbList.splice(1);
                self._render();
            });
        }
    };

    return function (targetWidget) {
        $.widget('mage.breadcrumbs', targetWidget, breadcrumbsMixin);

        return $.mage.breadcrumbs;
    };
});
