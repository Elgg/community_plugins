/**
 *  js for plotting download trends
 */
define(function(require) {
    var $ = require('jquery');
    var elgg = require('elgg');
    require('jquery.flot');

    var init = function() {
        $.plot($("#plugins_download_plot"), $('#plugins_download_plot').attr('data-plot'));
    };

    elgg.register_hook_handler('init', 'system', init);

    return {
        init: init
    };
});