elgg.provide('elgg.communityPlugins');

elgg.communityPlugins.init = function() {
    // Bind multiselect plugin to multi-selectable fields
    $('form#plugin_search_form select.multiselect').chosen();

    // "Clear search" button loads search page without parameters
    $('form#plugin_search_form .elgg-button-cancel').live('click', function() {
        window.location.href = elgg.get_site_url() + "plugins/search";
    });
};

elgg.register_hook_handler('init', 'system', elgg.communityPlugins.init);