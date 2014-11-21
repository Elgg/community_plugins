/**
 *  General jquery bindings for plugin page screenshots
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
    };

    elgg.register_hook_handler('init', 'system', init);

    return {
        init: init
    };
});
