<?php
/**
 * Sidebar box for project images
 */

elgg_load_js('jquery.lightbox');
elgg_load_js('elgg.communityPlugins.lightboxInit');

$project = $vars['entity'];

// ordering by guid does not guarantee the correct order
$img_files = elgg_get_entities_from_relationship(array(
	'relationship_guid' => $project->getGUID(),
	'relationship' => 'image',
	'order_by' => 'guid',
));

foreach ($img_files as $file) {
	$thumb = get_entity($file->thumbnail_guid);
	if (!$thumb) {
		continue;
	}

	$src = elgg_get_site_url() . "mod/community_plugins/image.php?guid={$thumb->getGUID()}";
	$link = elgg_get_site_url() . "mod/community_plugins/image.php?guid={$file->getGUID()}";

	echo "<div class=\"project_image_wrapper\">";
	echo "<a class=\"project_image\" title=\"$file->title\" href=\"$link\"><img src=\"$src\" /></a>";

	if ($project->canEdit()) {
		$url = "/action/plugins/delete_project_image?project_guid={$project->getGUID()}&image_guid={$file->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		echo elgg_view('output/confirmlink',array(
				'href' => $url,
				'text' => 'delete',
				'confirm' => elgg_echo("plugins:delete_project_image:confirm"),
		));
	}
	echo "</div>";
}
