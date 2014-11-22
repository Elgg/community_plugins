<?php
/**
 * Project details to be used in a form body.
 */
$sticky_values = elgg_get_sticky_values('community_plugins');

// set defaults for new or editing
if (array_key_exists('project', $vars) && $vars['project'] instanceof ElggObject && $vars['project']->getSubtype() == 'plugin_project') {
	$project = $vars['project'];
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

	$msglink = elgg_view('output/url', array(
		'text' => elgg_echo('plugins:link:here'),
		'href' => elgg_get_site_url() . "plugins/new/release/{$project->getGUID()}",
		'is_trusted' => true
	));
	$msg = elgg_echo('plugins:edit:helptext', array($project->title, $msglink));
} else {
	$project = NULL;
	$title = $description = $homepage = $plugin_type = '';
	$license = $donate = $tags = '';

	$plugincat = 'uncategorized';
	$access_id = ACCESS_PUBLIC;
	$username = elgg_get_logged_in_user_entity()->username;

	$msglink = elgg_view('output/url', array(
		'text' => elgg_echo('plugins:link:here'),
		'href' => elgg_get_site_url() . "plugins/developer/{$username}",
		'is_trusted' => true
	));
	$msg = elgg_echo('plugins:add:helptext', array($msglink));
}
?>
<p>
<?php echo $msg; ?>
</p>

<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:name'); ?></label><br/>
	<?php
	echo elgg_view("input/text", array(
		"name" => "title",
		"value" => $sticky_values['title'] ? $sticky_values['title'] : $title,
	));
	?>
</label>
</div>

<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:project_summary'); ?></label>
	<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:project_summary'); ?></span><br/>
<?php
echo elgg_view("input/text", array(
	"name" => "summary",
	"value" => $sticky_values['summary'] ? $sticky_values['summary'] : $summary,
	'maxlength' => 250,
));
?>
</div>

	<?php
	$policylink = elgg_view('output/url', array(
		'text' => elgg_echo('policy'),
		'href' => 'http://community.elgg.org/terms#plugins'
	));
	?>
<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:description'); ?></label>
	<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:description'); ?></span><br/>
<?php
echo elgg_view("input/longtext", array(
	"name" => "description",
	"value" => $sticky_values['description'] ? $sticky_values['description'] : $description,
));
?>
</div>
<div class="elgg-input-wrapper">
	<label for="license"><?php echo elgg_echo("license"); ?>*</label><br/>
	<em class="elgg-subtext">
		<a href="http://www.gnu.org/philosophy/license-list.html#GPLCompatibleLicenses" target="_blank"><?php echo elgg_echo('license:blurb'); ?></a>
	</em>
	<br />
<?php
echo elgg_view("input/dropdown", array(
	"name" => "license",
	"value" => $sticky_values['license'] ? $sticky_values['license'] : $license,
	'options_values' => elgg_get_config('gpllicenses'),
));
?>
</div>
<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:plugin_type'); ?></label><br/>
	<?php
	echo elgg_view("input/dropdown", array(
		"name" => "plugin_type",
		"value" => $sticky_values['plugin_type'] ? $sticky_values['plugin_type'] : $plugin_type,
		'options_values' => array(
			'plugin' => elgg_echo('plugins:plugin'),
			'theme' => elgg_echo('plugins:theme'),
			'languagepack' => elgg_echo('plugins:languagepack'),
		),
	));
	?>
</div>
<div class="elgg-input-wrapper">
	<label for="category"><?php echo elgg_echo("plugins:category"); ?></label><br />
	<?php
	echo elgg_view("input/dropdown", array(
		"name" => "plugincat",
		"value" => $sticky_values['plugincat'] ? $sticky_values['plugincat'] : $plugincat,
		'options_values' => elgg_get_config('plugincats'),
		'id' => 'category',
	));
	?>
</div>
<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:project_homepage'); ?></label><br/>
	<?php
	echo elgg_view("input/text", array(
		"name" => "homepage",
		"value" => $sticky_values['homepage'] ? $sticky_values['homepage'] : $homepage,
	));
	?>
</div>
<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo("plugins:repo"); ?><br />
	<?php
	echo elgg_view("input/text", array(
		"name" => "repo",
		"value" => $sticky_values['repo'] ? $sticky_values['repo'] : $repo
	));
	?>
	</label>
</div>

<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:donate'); ?><br />
		<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:donate'); ?></span>
<?php
echo elgg_view("input/text", array(
	"name" => "donate",
	"value" => $sticky_values['donate'] ? $sticky_values['donate'] : $donate,
));
?>
	</label>
</div>
<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo("tags"); ?></label>
	<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:tags'); ?></span>
<?php
echo elgg_view("input/tags", array(
	"name" => "tags",
	"value" => $sticky_values['tags'] ? $sticky_values['tags'] : $tags,
));
?>
</div>
<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('access'); ?></label>
	<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:access'); ?></span>
	<br />
<?php
echo elgg_view('input/access', array(
	'name' => 'project_access_id',
	'value' => $sticky_values['project_access_id'] ? $sticky_values['project_access_id'] : $access_id
));
?>
</div>
	<?php
	if ($project && ($entities = elgg_get_entities(array('container_guid' => $project->getGUID()))) && is_array($entities) && (count($entities) > 0)) {

		$releases = array(0 => elgg_echo('plugins:edit:recommended:none'));

		$recommended = ($project->recommended_release_guid) ? $project->recommended_release_guid : 0;
		foreach ($entities as $entity) {
			$time = elgg_view_friendly_time($entity->time_created);
			$releases[$entity->guid] = "{$entity->version} ($time)";
		}
	}
	?>
<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:project_images'); ?></label>
	<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:project_images'); ?></span><br /><br />
<?php
$img_files = array();
if ($project) {
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

	echo '<div class="elgg-col elgg-col-1of2">';
	echo "<label>" . elgg_echo('plugins:edit:image') . " $i " . elgg_view('input/file', array('name' => "image_$i"))
	. "</label><br /><br /><br />";
	echo '</div>';
	echo '<div class="elgg-col elgg-col-1of2 center">';
	if ($display_img) {
		echo elgg_view('output/url', array(
			'text' => elgg_view('output/img', array(
				'src' => "plugins/icon/{$display_img->guid}/icon.jpg",
				'style' => "vertical-align:middle; margin-right: 8px;"
			)),
			'href' => "plugins/icon/{$link_img->guid}/icon.jpg",
			'target' => '_blank'
		));
			
		echo elgg_view('output/confirmlink', array(
			'text' => elgg_view_icon('delete'),
			'href' => 'action/plugins/delete_project_image?project_guid=' . $project->guid . '&image_guid=' . $link_img->guid
		));
	} else {
		echo '&nbsp;';
	}
	echo '</div>';

	echo '<div class="clearfloat"></div>';
}
?>
</div>