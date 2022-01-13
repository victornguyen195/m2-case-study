"use strict";

var themes = require('./amasty-path'),
    _ = require('underscore'),
    themeOptions = {},
    svgOptions = {};

_.each(themes, function (theme, name) {
    themeOptions[name] = {
        files: {
            [theme['theme'] + '/web/svg/sprite/icons.min.svg']:
                [theme['theme'] + '/web/svg/min/*.svg']
        }
    };
});

svgOptions = {
    options: {
        prefix: 'icon-',
        includedemo: false,
        includeTitleElement: false,
        cleanup: ['fill']
    }
};

module.exports = _.extend(themeOptions, svgOptions);
