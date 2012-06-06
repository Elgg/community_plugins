<?php
/**
 * Sidebar box for project images
 */

elgg_load_js('jquery.lightbox');
elgg_load_js('elgg.communityPlugins.PluginImages');

$project = $vars['entity'];

// ordering by guid does not guarantee the correct order
$img_files = $project->getScreenshots();

echo '<ul class="elgg-gallery elgg-plugin-screenshots float-alt">';
foreach ($img_files as $file) {
	$thumb = get_entity($file->thumbnail_guid);
	if (!$thumb) {
		continue;
	}

	$src = elgg_get_site_url() . "mod/community_plugins/image.php?guid={$thumb->getGUID()}";
	$link = elgg_get_site_url() . "mod/community_plugins/image.php?guid={$file->getGUID()}";

	echo "<li>";
	echo "<a class=\"elgg-plugin-screenshot\" href=\"$link\"><img src=\"$src\" alt=\"$file->title\" title=\"$file->title\" height=\"60\" width=\"60\"/></a>";

	if ($project->canEdit()) {
		echo "<br/>";
		$url = "/action/plugins/delete_project_image?project_guid={$project->getGUID()}&image_guid={$file->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		echo elgg_view('output/confirmlink', array(
				'href' => $url,
				'text' => 'delete',
				'confirm' => elgg_echo("plugins:delete_project_image:confirm"),
		));
	}
	echo "</li>";
}
echo '</ul>';
