'use strict';

var themes = require('./amasty-path'),
    _ = require('underscore'),
    themeOptions = {},
    svgMinOptions = {};

_.each(themes, function (theme, name) {
    themeOptions[name] = {
        files: [{
            expand: true,
            cwd: theme['theme'] + '/web/svg/',
            src: ['*.svg'],
            dest: theme['theme'] + '/web/svg/min'
        }]
    };
});

svgMinOptions = {
    options: {
        plugins: [
            {removeViewBox: false},
            {removeUselessStrokeAndFill: false},
            {removeEmptyAttrs: false}
        ]
    }
};

module.exports = _.extend(themeOptions, svgMinOptions);
