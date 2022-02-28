define([
    'Magento_Ui/js/lib/view/utils/async',
    'underscore',
    'ko',
    'Magento_Ui/js/form/element/abstract',
    'mage/adminhtml/events',
    'Magento_Variable/variables'
], function ($, _, ko, Abstract, varienGlobalEvents) {
    'use strict';

    return Abstract.extend({
        currentWysiwyg: undefined,
        defaults: {
            elementSelector: 'textarea',
            suffixRegExpPattern: '${ $.wysiwygUniqueSuffix }',
            $wysiwygEditorButton: '',
            links: {
                value: '${ $.provider }:${ $.dataScope }'
            },
            template: 'ui/form/field',
            elementTmpl: 'ui/form/element/wysiwyg',
            content:        '',
            showSpinner:    false,
            loading:        false,
            listens: {
                disabled: 'setDisabled'
            }
        },

        /**
         * Extends method show. Hide content at root category.
         */
        show: function () {
            this._super();

            if (this.level === 1) {
                this.visible(false);

                return false;
            }
        },

        /**
         * Hide notice.
         *
         * @returns {Abstract} Chainable.
         */
        hideNotice: function () {
            this.notice('');

            return this;
        },

        /**
         * Show notice.
         *
         * @returns {Abstract} Chainable.
         */
        showNotice: function () {
            this.notice(this.defaultNotice);

            return this;
        },

        /**
         *
         * @returns {} Chainable.
         */
        initialize: function () {
            this._super()
                .initNodeListener();

            $.async({
                component: this,
                selector: 'button'
            }, function (element) {
                this.$wysiwygEditorButton = this.$wysiwygEditorButton ?
                    this.$wysiwygEditorButton.add($(element)) : $(element);
            }.bind(this));

            if (varienGlobalEvents) {
                // disable editor completely after initialization if field is disabled
                varienGlobalEvents.attachEventHandler('wysiwygEditorInitialized', function () {
                    if (!_.isUndefined(window.tinyMceEditors)) {
                        this.currentWysiwyg = window.tinyMceEditors[this.wysiwygId];
                    }

                    if (this.disabled()) {
                        this.setDisabled(true);
                    }
                }.bind(this));
            }

            return this;
        },

        /** @inheritdoc */
        initConfig: function (config) {
            var pattern = config.suffixRegExpPattern || this.constructor.defaults.suffixRegExpPattern;

            pattern = pattern.replace(/\$/g, '\\$&');
            config.content = config.content.replace(new RegExp(pattern, 'g'), this.getUniqueSuffix(config));
            this._super();

            return this;
        },

        /**
         * Build unique id based on name, underscore separated.
         *
         * @param {Object} config
         */
        getUniqueSuffix: function (config) {
            return config.name.replace(/(\.|-)/g, '_');
        },

        /**
         * @inheritdoc
         */
        destroy: function () {
            this._super();
            var editor;

            if (varienGlobalEvents
                && typeof  window.tinyMceEditors !== 'undefined'
                && window.tinyMceEditors[this.wysiwygId]
            ) {
                editor = window.tinyMceEditors[this.wysiwygId];
                varienGlobalEvents.removeEventHandler('tinymceChange', editor.onChangeContent);
            }
        },

        /**
         *
         * @returns {exports}
         */
        initObservable: function () {
            this._super()
                .observe('value');

            return this;
        },

        /**
         *
         * @returns {} Chainable.
         */
        initNodeListener: function () {
            $.async({
                component: this,
                selector: this.elementSelector
            }, this.setElementNode.bind(this));

            return this;
        },

        /**
         *
         * @param {HTMLElement} node
         */
        setElementNode: function (node) {
            $(node).bindings({
                value: this.value
            });
        },

        /**
         * Set disabled property to wysiwyg component
         *
         * @param {Boolean} disabled
         */
        setDisabled: function (disabled) {
            if (this.$wysiwygEditorButton && disabled) {
                this.$wysiwygEditorButton.prop('disabled', 'disabled');
            } else if (this.$wysiwygEditorButton) {
                this.$wysiwygEditorButton.removeProp('disabled');
            }

            /* eslint-disable no-undef */
            if (!_.isUndefined(this.currentWysiwyg) && this.currentWysiwyg.activeEditor()) {
                this.currentWysiwyg.setEnabledStatus(!disabled);
                this.currentWysiwyg.getPluginButtons().prop('disabled', disabled);
            }
        }
    });
});
