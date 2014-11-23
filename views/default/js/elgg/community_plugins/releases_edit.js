/**
 *  General jquery bindings for releases edit page
 */
define(function(require) {
    var $ = require('jquery');
    var elgg = require('elgg');

    var init = function() {
        
        // disable any unchecked recommended checkboxes
        // we only want to enable them if a corresponding compatible option is selected
        $('input[name="recommended\[\]"]').each(function(index, item) {
            var val = $(this).val();
            
            if ($(this).is(':checked')) {
                return;
            }
            
            // if the corresponding elgg version is checked we also don't need to do anything
            if ($('input[name="elgg_version\[\]"][value="'+val+'"]').is(':checked')) {
                return;
            }
            
            // disable the checkbox
            $(this).attr('disabled', true);
        });
        
        $(document).on('click', 'input[name="elgg_version\[\]"]', function(e) {
            var val = $(this).val();
            var recommended = $('input[name="recommended\[\]"][value="'+val+'"]');
            if ($(this).is(':checked')) {
                // activate the corresponding recommended release
                recommended.removeAttr('disabled');
                
                // if this has a data-release guid then we're editing
                // if not then we're uploading a new plugin
                // in which case we want to auto-set for convenience
                var guid = $(this).attr('data-release');

                if (guid) {
                    recommended.attr('checked', true);
                }
            }
            else {
                // this was unchecked - uncheck the recommended box before disabling
                recommended.removeAttr('checked').attr('disabled', true);
            }
        });
    };

    elgg.register_hook_handler('init', 'system', init);

    return {
        init: init
    };
});
