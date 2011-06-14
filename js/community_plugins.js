/**
 * Javascript helpers for community_plugins plugin
 */

jQuery(document).ready(function () {

	$('form#plugin_search_form select.multiselect').dropdownchecklist({ 
		emptyText: "Any", 
		width: 220 
	}); 
	
/*	

    // Handle search-preserving pagination
    $('a.pagination_number, a.pagination_previous, a.pagination_next').click(function(e) {
        e.preventDefault();
        var targetUrl = $(this).attr('href');
        var regxp = /offset=(\d+)/;
        var matches = regxp.exec(targetUrl);
        var offset = matches[1];
        $('form#search_members_form').append('<input type="hidden" name="offset" value="' + offset + '" />');
        $('form#search_members_form').append('<input type="hidden" name="limit" value="' + current_limit + '" />');
        $('form#search_members_form').append('<input type="hidden" name="sort" value="' + current_sort + '" />');
        $('form#search_members_form').append('<input type="hidden" name="direction" value="' + current_direction + '" />');
        $('form#search_members_form').submit();
    });

    $('select[name="jumpto"]').change(function() {
        $('form#search_members_form').append('<input type="hidden" name="offset" value="' + $(this).val() + '" />');
        $('form#search_members_form').append('<input type="hidden" name="limit" value="' + current_limit + '" />');
        $('form#search_members_form').append('<input type="hidden" name="sort" value="' + current_sort + '" />');
        $('form#search_members_form').append('<input type="hidden" name="direction" value="' + current_direction + '" />');
        $('form#search_members_form').submit();
    });

    $('select[name="itemsperpage"]').change(function() {
        $('form#search_members_form').append('<input type="hidden" name="limit" value="' + $(this).val() + '" />');
        $('form#search_members_form').append('<input type="hidden" name="sort" value="' + current_sort + '" />');
        $('form#search_members_form').append('<input type="hidden" name="direction" value="' + current_direction + '" />');
        $('form#search_members_form').submit();
    });


    // Handle sorting
    // Handle sorting. Requested sort property and direction will be saved in to
    $('span.sort-item a.sort').live('click', function(e) {
        e.preventDefault();
        var targetUrl = $(this).attr('href');
        var regxp = /sort=(\w+)/;
        var matches = regxp.exec(targetUrl);
        var sort = matches[1];
        var regxp = /direction=(\w+)/;
        var matches = regxp.exec(targetUrl);
        var direction = matches[1];
        $('form#search_members_form').append('<input type="hidden" name="offset" value="' + current_offset + '" />');
        $('form#search_members_form').append('<input type="hidden" name="limit" value="' + current_limit + '" />');
        $('form#search_members_form').append('<input type="hidden" name="sort" value="' + sort + '" />');
        $('form#search_members_form').append('<input type="hidden" name="direction" value="' + direction + '" />');
        $('form#search_members_form').submit();
    });

    // Bulk actions for banning, unbanning and disabling users
    $("a#listing_select_all").click(function(e) {
        e.preventDefault();
        $('input[name^=user_guids]').attr('checked', 'checked');
        return false;
    });

    $("a#listing_deselect_all").click(function(e) {
        e.preventDefault();
        $('input[name^=user_guids]').removeAttr('checked');
        return false;
    });

    $("a#listing_ban").click(function(e) {
        e.preventDefault();
        do_bulk_function("ban");
        return false;
    });

    $("a#listing_unban").click(function(e) {
        e.preventDefault();
        do_bulk_function("unban");
        return false;
    });

    $("a#listing_disable").click(function(e) {
        e.preventDefault();
        do_bulk_function("disable");
        return false;
    });

    function do_bulk_function(action_str) {
        $('input[name^=user_guids]').each(function() {
            if ($(this).is(':checked')) {
                $('form#search_members_form').append('<input type="hidden" name="guids[]" value="' + $(this).val() + '" />');
            }
        });
        $('form#search_members_form').append('<input type="hidden" name="command" value="' + action_str + '" />');
        $('form#search_members_form').append('<input type="hidden" name="offset" value="' + current_offset + '" />');
        $('form#search_members_form').append('<input type="hidden" name="limit" value="' + current_limit + '" />');
        $('form#search_members_form').append('<input type="hidden" name="sort" value="' + current_sort + '" />');
        $('form#search_members_form').append('<input type="hidden" name="direction" value="' + current_direction + '" />');
        $('form#search_members_form').submit();
    }
    */
});