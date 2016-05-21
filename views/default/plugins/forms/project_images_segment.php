<?php

echo elgg_format_element('p', [], elgg_echo('plugins:edit:help:project_images'));

$img_files = array();

$project = elgg_extract('project', $vars);

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

	$field = elgg_view_input('file', [
		'name' => "image_$i",
		'label' => elgg_echo('plugins:edit:image') . " $i",
	]);

	if ($display_img) {
		$screenshot = elgg_view('output/url', array(
			'text' => elgg_view('output/img', array(
				'src' => "plugins/icon/{$display_img->guid}/icon.jpg",
			)),
			'href' => "plugins/icon/{$link_img->guid}/icon.jpg",
			'target' => '_blank'
		));

		$screenshot .= elgg_view('output/confirmlink', array(
			'text' => elgg_view_icon('delete'),
			'href' => 'action/plugins/delete_project_image?project_guid=' . $project->guid . '&image_guid=' . $link_img->guid
		));
		echo elgg_view_image_block('', $field, [
			'image_alt' => $screenshot,
		]);
	} else {
		echo $field;
	}
}