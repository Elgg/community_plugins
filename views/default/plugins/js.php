<?php
/**
 * Community plugins repository JavaScript
 */

?>

jQuery(document).ready(function () {

	// Bind multiselect plugin to multi-selectable fields
	$('form#plugin_search_form select.multiselect').dropdownchecklist({
		emptyText: "Any",
		width: 220
	});

	// "Clear search" button loads search page without parameters
	$('form#plugin_search_form button#clear_search').click(function() {
        window.location.href = plugins.wwwroot + "plugins/search";
    });

});
