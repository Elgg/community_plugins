/**
 *  General jquery bindings for plugins pages
 */
define(function(require) {
    var $ = require('jquery');
    var elgg = require('elgg');
    require('jquery.chosen');

    var init = function() {

        $('form#plugin_search_form select.multiselect').chosen();

        // "Clear search" button loads search page without parameters
        $(document).on('click', 'form#plugin_search_form .elgg-button-cancel', function() {
            window.location.href = elgg.get_site_url() + "plugins/search";
        });
    };

    elgg.register_hook_handler('init', 'system', init);

    return {
        init: init
    };
});
