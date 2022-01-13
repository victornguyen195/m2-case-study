define([ 'jquery' ], function ($) {
    'use strict';

    $('a.action.showcart').click(function () {
        $(document.body).trigger('processStart');
    });
});
