/**
 *  General jquery bindings for plugin page screenshots and plugin page events
 */
define(function (require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	var init = function () {

		var lightbox = require('elgg/lightbox');

		var options = {
			photo: true,
		};

		lightbox.bind('a[rel="plugin-screenshots-gallery"]', options, false);


		// ajax fetch release info
		$(document).on('click', '.plugins-show-all', function (e) {
			e.preventDefault();

			var wrapper = $(this).parents('.plugins-download-table-wrapper').eq(0);
			var html = wrapper.html();
			var guid = wrapper.attr('data-guid');
			var stable = $(this).attr('data-stable');

			wrapper.find('table > tbody').html('<div class="elgg-ajax-loader"></div>');

			elgg.get('ajax/view/object/plugin_project/release_table', {
				data: {
					guid: guid,
					stable: stable
				},
				success: function (result) {
					wrapper.html(result);
				},
				error: function (result) {
					wrapper.html(html);
				},
				complete: function () {
					// scroll to the top of the results
					$('html,body').animate({scrollTop: wrapper.offset().top}, 'slow');
				}
			});
		});
	};

	elgg.register_hook_handler('init', 'system', init);

	return {
		init: init
	};
});
