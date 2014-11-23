<?php
/**
 * Release details for use inside a form body.
 */

elgg_require_js('elgg/community_plugins/releases_edit');

$sticky_values = elgg_get_sticky_values('community_plugins');

// see if we have a project
if (array_key_exists('project', $vars)
&& $vars['project'] instanceof ElggObject
&& $vars['project']->getSubtype() == 'plugin_project') {
	$project = $vars['project'];
} else {
	$project = NULL;
}

// default vars to use if editing or new
if (array_key_exists('release', $vars) && $vars['release'] instanceof PluginRelease) {
	$release = $vars['release'];
	$elgg_version = $release->elgg_version;
	$version = $release->version;
	$release_notes = $release->release_notes;
	$comments = $release->comments;

	$recommended = $release->recommended;
	$access_id = $release->access_id;
} else {
	$project = $release = $elgg_version = $version = $release_notes = NULL;

	$comments = 'yes';
	$recommended = array();
	$access_id = ($project) ? $project->access_id : ACCESS_PUBLIC;
}

echo elgg_view('output/longtext', array(
	'value' => elgg_echo('plugins:edit:help:release')
));

if (!$release) { ?>
	<div class="elgg-input-wrapper">
		<label><?php echo elgg_echo("plugins:file"); ?>*</label>
		<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:file'); ?></span><br />
		<?php
			echo elgg_view("input/file", array('name' => 'upload'));
		?>
	</div>
<?php } ?>

<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:release_version'); ?>*</label>
	<?php
		echo elgg_view("input/text",array(
			"name" => "version",
			"value" => $sticky_values['version'] ? $sticky_values['version'] : $version,
			'style' => 'width: 3em',
		));
	?>
</div>

<?php
	$release_link = elgg_view('output/url', array(
		'text' => elgg_echo('policy'),
		'href' => "http://community.elgg.org/expages/read/Terms/#plugins",
		'is_trusted' => true
	));
?>
<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:release_notes'); ?>:</label>
	<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:release_notes', array($release_link)); ?></span><br />

	<?php
		echo elgg_view("input/longtext",array(
			"name" => "release_notes",
			"value" => $sticky_values['release_notes'] ? $sticky_values['release_notes'] : $release_notes,
		));
	?>
</div>

<div class="elgg-input-wrapper">
	<div class="elgg-col elgg-col-1of2">
		<label><?php echo elgg_echo('plugins:edit:label:elgg_version'); ?>*</label><br>
	<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:elgg_version'); ?></span><br />
	<?php
		echo elgg_view("input/checkboxes",array(
			"name" => "elgg_version",
			"default" => false,
			"value" => $sticky_values['elgg_version'] ? $sticky_values['elgg_version'] : $elgg_version,
			'options' => elgg_get_config('elgg_versions'),
			'data-release' => $release ? $release->guid : 0
		));
	?>
	</div>
	<div class="elgg-col elgg-col-1of2">
		<label><?php echo elgg_echo('plugins:edit:label:recommended'); ?></label><br>
	<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:recommended'); ?></span><br />
	<?php
		echo elgg_view('input/checkboxes', array(
			'name' => 'recommended',
			'default' => false,
			'value' => $sticky_values['recommended'] ? $sticky_values['recommended'] : $recommended,
			'options' => elgg_get_config('elgg_versions'),
		));
	?>
	</div>
	<div class="clearfloat"></div>
</div>

<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('plugins:edit:label:comments'); ?></label><br />
		<?php
			echo elgg_view("input/radio",array(
				"name" => "comments",
				"value" => $sticky_values['comments'] ? $sticky_values['comments'] : $comments,
				'options' => array(
					elgg_echo('plugins:yes') => 'yes',
					elgg_echo('plugins:no') => 'no',
				),
			));
		?>
	</label>
</div>

<div class="elgg-input-wrapper">
	<label><?php echo elgg_echo('access'); ?></label>
	<span class="elgg-subtext"><?php echo elgg_echo('plugins:edit:help:access'); ?></span>
	<?php echo elgg_view('input/access', array(
		'name' => 'release_access_id',
		'value' => $sticky_values['release_access_id'] ? $sticky_values['release_access_id'] : $access_id
	)); ?>
</div>
