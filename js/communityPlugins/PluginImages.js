elgg.provide('elgg.communityPlugins.PluginImages');

elgg.communityPlugins.PluginImages.init = function() {
	$('.elgg-plugin-screenshot').lightBox({
		imageLoading: elgg.get_site_url() + 'mod/community_plugins/vendors/images/lightbox-ico-loading.gif',
		imageBtnClose: elgg.get_site_url() + 'mod/community_plugins/vendors/images/lightbox-btn-close.gif',
		imageBtnPrev: elgg.get_site_url() + 'mod/community_plugins/vendors/images/lightbox-btn-prev.gif',
		imageBtnNext: elgg.get_site_url() + 'mod/community_plugins/vendors/images/lightbox-btn-next.gif',
		imageBlank: elgg.get_site_url() + 'mod/community_plugins/vendors/images/lightbox-blank.gif',
		containerResizeSpeed: 200
	});
};

elgg.register_hook_handler('init', 'system', elgg.communityPlugins.PluginImages.init);