module.exports = function (grunt) {
    'use strict';

    var themes = require('../configs/amasty-path'),
        _ = require('underscore'),
        sprite,
        content,
        jsonContent,
        iconName,
        iconsId = [];

    grunt.registerTask('svgsprite', 'Transform SVG sprite to JS file', function () {
        _.each(themes, function (themeData, name) {
            sprite = grunt.file.read(themeData.theme + '/web/svg/sprite/icons.min.svg');

            grunt.file.recurse(themeData.theme + '/web/svg/min/',
                function (abspath, rootdir, subdir, filename) {
                    iconName = 'icon-' + filename.replace(/.svg/g, '');
                    iconsId.push(iconName);
            });

            sprite = sprite.replace(/>\s*/g, '>');
            content = '(function () {var svgSprite = \'' + sprite + '\';' +
                ' var svgDiv = document.createElement("div");' +
                ' svgDiv.innerHTML = svgSprite;' +
                ' svgDiv.className = "svgi-sprite";' +
                ' svgDiv.style.display = "none";' +
                ' document.body.insertBefore(svgDiv, document.body.firstChild);})();';
            jsonContent = JSON.stringify(iconsId);

            grunt.file.write(themeData.utils + 'svg-sprite.min.js', content);
            grunt.file.write(themeData.theme + '/web/svg/sprite/svg-sprite.json', jsonContent);
        });
    });
};
