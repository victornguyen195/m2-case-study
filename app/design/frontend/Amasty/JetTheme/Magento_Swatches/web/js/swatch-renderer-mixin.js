/*
 * Swatch renderer mixin
 */
define([
    'jquery',
    'underscore'
], function ($, _) {
    'use strict';

    return function (SwatchRenderer) {
        $.widget('mage.SwatchRenderer', SwatchRenderer, {

            /**
             * Moving product options (swatches) on product grid -> Override product data method
             * @returns {{isInProductView: boolean, productId: (undefined|String)}}
             * @private
             */
            _determineProductData: function () {
                var productId,
                    isInProductView = false;

                productId = this.element.parents('.product-item-info')
                    .find('.product-item-details .price-box.price-final_price').attr('data-product-id');

                if (!productId) {
                    productId = $('[name=product]').val();
                    isInProductView = productId > 0;
                }

                return {
                    productId: productId,
                    isInProductView: isInProductView
                };
            },

            /**
             * Adding css modifiers for old price and special price
             * @inheritDoc
             */
            _UpdatePrice: function () {
                var $widget = this,
                    $product = $widget.element.parents($widget.options.selectorProduct),
                    priceBox = $product.find(this.options.selectorProductPrice),
                    options,
                    result,
                    isShow;

                if ($widget._getNewPrices) { // Magento 2.3.0 compatibility
                    result = $widget._getNewPrices();
                } else {
                    options = _.object(_.keys($widget.optionsMap), {});

                    $widget.element
                        .find('.' + $widget.options.classes.attributeClass + '[option-selected]')
                        .each(function () {
                            var attributeId = $(this).attr('attribute-id');

                            options[attributeId] = $(this).attr('option-selected');
                        });

                    result = $widget.options.jsonConfig.optionPrices[_.findKey(
                        $widget.options.jsonConfig.index,
                        options
                    )];
                }

                this._super();

                // Override Magento
                isShow = typeof result != 'undefined' && result.oldPrice.amount !== result.finalPrice.amount;

                // Adding modifier for special price in product
                priceBox.toggleClass('-am-special-price', isShow);

                // Adding modifier when price label is hidden
                priceBox.addClass('-am-no-price-label');

                // Extend Magento
                _.each($('.' + this.options.classes.attributeOptionsWrapper), function (attribute) {
                    if ($(attribute).find('.' + this.options.classes.optionClass + '.selected').length === 0) {
                        if ($(attribute).find('.' + this.options.classes.selectClass).length > 0) {
                            _.each($(attribute).find('.' + this.options.classes.selectClass), function (dropdown) {
                                if ($(dropdown).val() === '0') {
                                    // Removing modifier when price label is shown
                                    priceBox.removeClass('-am-no-price-label');
                                }
                            });
                        } else {
                            // Removing modifier when price label is shown
                            priceBox.removeClass('-am-no-price-label');
                        }
                    }
                }.bind(this));
            },

            /** @inheritDoc */
            updateBaseImage: function (images, context, isInProductView) {
                var justAnImage = images[0],
                    gallery = context.find(this.options.mediaGallerySelector).data('gallery');

                if (isInProductView) {
                    if (_.isUndefined(gallery)) {
                        context.find(this.options.mediaGallerySelector).on('gallery:loaded', function () {
                            this.updateBaseImage(images, context, isInProductView);
                        }.bind(this));

                        return;
                    }
                } else if (justAnImage && justAnImage.img) {
                    context.find('.product-image-photo').attr('src', justAnImage.img);
                }

                this._super(images, context, isInProductView);
            }
        });

        return $.mage.SwatchRenderer;
    };
});
