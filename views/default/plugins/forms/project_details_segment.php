<?php
/**
 * Project details to be used in a form body.
 */
$sticky_values = elgg_get_sticky_values('community_plugins');

$project = elgg_extract('project', $vars);

// set defaults for new or editing
if ($project instanceof PluginProject) {
	$title = $project->title;
	$summary = $project->summary;
	$description = $project->description;
	$homepage = $project->homepage;
	$plugin_type = $project->plugin_type;
	$plugincat = $project->plugincat;
	$license = $project->license;
	$donate = $project->donate;
	$tags = $project->tags;
	$access_id = $project->access_id;
	$repo = $project->repo;

	$msglink = elgg_view('output/url', [
		'text' => elgg_echo('plugins:link:here'),
		'href' => "plugins/new/release/{$project->getGUID()}",
		'is_trusted' => true,
	]);
	$msg = elgg_echo('plugins:edit:helptext', [$project->title, $msglink]);
} else {
	$project = null;
	$title = $description = $homepage = $plugin_type = '';
	$license = $donate = $tags = '';

	$plugincat = 'uncategorized';
	$access_id = ACCESS_PUBLIC;
	$username = elgg_get_logged_in_user_entity()->username;

	$msglink = elgg_view('output/url', [
		'text' => elgg_echo('plugins:link:here'),
		'href' => "plugins/developer/{$username}",
		'is_trusted' => true,
	]);
	$msg = elgg_echo('plugins:add:helptext', [$msglink]);
}

echo elgg_view('output/longtext', [
	'value' => $msg,
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('plugins:edit:label:name'),
	'name' => 'title',
	'value' => elgg_extract('title', $sticky_values, $title),
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('plugins:edit:label:project_summary'),
	'#help' => elgg_echo('plugins:edit:help:project_summary'),
	'name' => 'summary',
	'value' => elgg_extract('summary', $sticky_values, $summary),
	'maxlength' => 250,
]);

$policylink = elgg_view('output/url', [
	'text' => elgg_echo('policy'),
	'href' => 'https://elgg.org/terms#plugins',
]);

echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('plugins:edit:label:description'),
	'#help' => elgg_echo('plugins:edit:help:description', [$policylink]),
	'name' => 'description',
	'value' => elgg_extract('description', $sticky_values, $description),
]);

$license_link = elgg_view('output/url', [
	'text' => elgg_echo('license:blurb'),
	'href' => 'http://www.gnu.org/philosophy/license-list.html#GPLCompatibleLicenses',
	'target' => '_blank',
]);
echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('license'),
	'#help' => $license_link,
	'name' => 'license',
	'value' => elgg_extract('license', $sticky_values, $license),
	'options_values' => elgg_get_config('gpllicenses'),
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('plugins:edit:label:plugin_type'),
	'name' => 'plugin_type',
	'value' => elgg_extract('plugin_type', $sticky_values, $plugin_type),
	'options_values' => [
		'plugin' => elgg_echo('plugins:plugin'),
		'theme' => elgg_echo('plugins:theme'),
		'languagepack' => elgg_echo('plugins:languagepack'),
	],
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('plugins:category'),
	'id' => 'category',
	'name' => 'plugincat',
	'value' => elgg_extract('plugincat', $sticky_values, $plugincat),
	'options_values' => elgg_get_config('plugincats'),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('plugins:edit:label:project_homepage'),
	'name' => 'homepage',
	'value' => elgg_extract('homepage', $sticky_values, $homepage),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('plugins:repo'),
	'name' => 'repo',
	'value' => elgg_extract('repo', $sticky_values, $repo),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('plugins:edit:label:donate'),
	'#help' => elgg_echo('plugins:edit:help:donate'),
	'name' => 'donate',
	'value' => elgg_extract('donate', $sticky_values, $donate),
]);

echo elgg_view_field([
	'#type' => 'tags',
	'#label' => elgg_echo('tags'),
	'#help' => elgg_echo('plugins:edit:help:tags'),
	'name' => 'tags',
	'value' => elgg_extract('tags', $sticky_values, $tags),
]);

echo elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('access'),
	'#help' => elgg_echo('plugins:edit:help:access'),
	'name' => 'project_access_id',
	'value' => elgg_extract('project_access_id', $sticky_values, $access_id),
	'entity' => $project,
	'entity_type' => 'object',
	'entity_subtype' => PluginProject::SUBTYPE,
]);

?>
<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:project_images'); ?></label>
	<div class="elgg-subtext mbm"><?php echo elgg_echo('plugins:edit:help:project_images'); ?></div>
<?php
$img_files = [];
if ($project instanceof PluginProject) {
	$img_files = $project->getScreenshots();
}

for ($i = 1; $i <= 4; $i++) {
	// show existing images if any
	$display_img = false;
	$link_img = false;
	if ($img_files) {
		foreach ($img_files as $img) {
			if ($img->project_image == $i) {
				$thumb = get_entity($img->thumbnail_guid);
				if ($thumb) {
					$link_img = $img;
					$display_img = $thumb;
				}
			}
		}
	}

	
	$input = elgg_view_field([
		'#type' => 'file',
		'#label' => elgg_echo('plugins:edit:image') . ' ' . $i,
		'name' => "image_{$i}",
	]);
	$input = elgg_format_element('div', [
		'class' => [
			'elgg-col',
			'elgg-col-1of2',
		],
	], $input);
	
	$image = '&nbsp';
	if ($display_img) {
		$image = elgg_view('output/url', [
			'text' => elgg_view('output/img', [
				'src' => "plugins/icon/{$display_img->guid}/icon.jpg",
				'style' => 'vertical-align:middle; margin-right: 8px;',
				'alt' => $display_img->getDisplayName(),
			]),
			'href' => "plugins/icon/{$link_img->guid}/icon.jpg",
			'target' => '_blank',
		]);
		
		$image .= elgg_view('output/url', [
			'text' => elgg_view_icon('delete'),
			'href' => elgg_http_add_url_query_elements('action/plugins/delete_project_image', [
				'project_guid' => $project->guid,
				'image_guid' => $link_img->guid,
			]),
			'confirm' => elgg_echo('deleteconfirm'),
		]);
	}
	$image = elgg_format_element('div', [
		'class' => [
			'elgg-col',
			'elgg-col-1of2',
			'center',
		],
	], $image);
	
	echo elgg_format_element('div', ['class' => 'clearfix'], $input . $image);
}
?>
</div>
