/**
 *  General jquery bindings for plugin page screenshots and plugin page events
 */
define(function(require) {
    var $ = require('jquery');
    var elgg = require('elgg');
    require('smoothproducts');

    var init = function() {
        $(window).load(function() {
            $('.sp-wrap').smoothproducts();
        });

        $(document).on('click', '.sp-thumbs a', function() {
            $('.sp-large').slideDown();
        });

        $(document).on('click', '*', function(e) {
            var container = $(".sp-wrap");

            if (!container.is(e.target) // if the target of the click isn't the container...
                    && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                container.find('.sp-large').slideUp();
            }
        });
        
        
        $(document).on('click', '.plugins-show-all', function(e) {
            e.preventDefault();
            
            var wrapper = $(this).parents('.plugins-download-table-wrapper').eq(0);
            var html = wrapper.html();
            var guid = wrapper.attr('data-guid');
            
            wrapper.find('table > tbody').html('<div class="elgg-ajax-loader"></div>');
            
            elgg.get('ajax/view/object/plugin_project/release_table', {
                data: {
                    guid: guid
                },
                success: function(result) {
                    wrapper.html(result);
                },
                error: function(result) {
                    wrapper.html(html);
                }
            });
        });
    };

    elgg.register_hook_handler('init', 'system', init);

    return {
        init: init
    };
});
