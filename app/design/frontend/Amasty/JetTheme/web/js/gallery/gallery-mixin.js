/**
 *  Magento gallery mixin for set max-height of gallery
 *  and set fixed height for vertical thumbnail
 */

define([
    'underscore'
], function (_) {
    'use strict';

    return function (gallery) {
        return gallery.extend({
            initialize: function (config) {
                if (_.has(config, 'amGalleryConfig')) {
                    this._getThumbsPosition(config);
                }

                this._super();
            },

            /**
             * Update thumbs position base on provided config
             * @param {Object} config
             * @returns {Object}
             * @private
             */
            _getThumbsPosition: function (config) {
                var amGalleryPosition = _.has(config.amGalleryConfig, 'position')
                    ? config.amGalleryConfig.position
                    : '';

                if (amGalleryPosition) {
                    config.options.navposition = amGalleryPosition;
                }

                if (amGalleryPosition === 'bottom') {
                    config.options.navdir = 'horizontal';
                    config.fullscreen.navdir = 'horizontal';
                    config.options.navwidth = '80%';
                } else {
                    config.options.maxheight = config.options.height;
                    config.options.navdir = 'vertical';
                    config.fullscreen.navdir = 'vertical';
                }

                return config;
            }
        });
    };
});
