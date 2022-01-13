'use strict';

var themes = require('../tools/files-router').get('themes'),
    _ = require('underscore'),
    themesArea = 'app/design/',
    amastyUtilsArea = 'Magento_Theme/web/js/utils/',
    amastyThemes = {},
    themeData = {};

_.each(themes, function (theme, name) {
    if (theme.name.match(/^Amasty/)) {
        themeData['theme'] =  themesArea + theme.area + '/' + theme.name;
        themeData['utils'] = themesArea + theme.area + '/' + theme.name + '/' + amastyUtilsArea;

        amastyThemes[name] = themeData;
    }
});

module.exports = amastyThemes;
