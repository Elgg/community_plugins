/**
 *  General jquery bindings for plugins pages
 */
define(function(require) {
    var $ = require('jquery');
    var elgg = require('elgg');

    var init = function() {

        $('form#plugin_search_form').accordion({ 
		header: 'div.filter_label' 
	});
	$('form#plugin_search_form').submit(function(e) {
		// Remove all input and select elements that are outside of the active accordion
		$('form#plugin_search_form').find('.filter_label:not(.ui-state-active)').next().find('input, select').remove();
	});
    };

    elgg.register_hook_handler('init', 'system', init);

    return {
        init: init
    };
});
