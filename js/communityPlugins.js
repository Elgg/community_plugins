elgg.provide('elgg.communityPlugins');

elgg.communityPlugins.init = function() {
	// Bind multiselect plugin to multi-selectable fields
	$('form#plugin_search_form select.multiselect').dropdownchecklist({
		emptyText: "Any",
		width: 220
	});

	// "Clear search" button loads search page without parameters
	$('form#plugin_search_form button#clear_search').live('click', function() {
        window.location.href = elgg.get_site_url() + "plugins/search";
    });
};

elgg.register_hook_handler('init', 'system', elgg.communityPlugins.init);