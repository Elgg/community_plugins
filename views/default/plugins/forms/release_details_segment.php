<?php
/**
 * Release details for use inside a form body.
 */

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

	$recommended = ($release->getGUID() == $project->recommended_release_guid) ? 'yes' : 'no';
	$access_id = $release->access_id;
} else {
	$project = $release = $elgg_version = $version = $release_notes = NULL;

	$comments = 'yes';
	$recommended = 'yes';
	$access_id = ($project) ? $project->access_id : ACCESS_PUBLIC;
}

?>

<p>This information is specific to the release you are uploading right now.  To edit the
general project details, visit the edit section of the project page.</p>

<?php if (!$release) { ?>
	<div class="elgg-input-wrapper">
		<label><?php echo elgg_echo("plugins:file"); ?>*</label>
		<span class="elgg-subtext">Uploaded files must contain a working plugin or theme.  Any plugin containing ads will be deleted and the user banned.  Distribution packages must be .zip, .tar.gz, or .tgz files.</span><br />
		<?php
			echo elgg_view("input/file", array('name' => 'upload'));
		?>
	</div>
<?php } ?>

<div class="elgg-input-wrapper">
	<label>Release version*</label>
	<?php
		echo elgg_view("input/text",array(
			"name" => "version",
			"value" => $sticky_values['version'] ? $sticky_values['version'] : $version,
			'style' => 'width: 3em',
		));
	?>
</div>

<div class="elgg-input-wrapper">
	<label>Release Notes:</label>
	<span class="elgg-subtext">A list of changes, bugfixes, bugs, todos, and general release notes for this release. (As per <a href="http://community.elgg.org/expages/read/Terms/#plugins">policy</a>, images and links will be removed.)</span><br />

	<?php
		echo elgg_view("input/longtext",array(
			"name" => "release_notes",
			"value" => $sticky_values['release_notes'] ? $sticky_values['release_notes'] : $release_notes,
		));
	?>
</div>

<div class="elgg-input-wrapper">
	<label>Elgg compatibility</label>
	<span class="elgg-subtext">The version of Elgg this plugin was developed and tested on</span><br />
	<?php
		echo elgg_view("input/dropdown",array(
			"name" => "elgg_version",
			"value" => $sticky_values['elgg_version'] ? $sticky_values['elgg_version'] : $elgg_version,
			'options' => elgg_get_config('elgg_versions'),
		));
	?>
</div>

<div class="elgg-input-wrapper">
	<label>Allow comments</label><br />
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
	<span class="elgg-subtext">The access level of this release. Useful if you want to release only to a certain group or collection.</span>
	<?php echo elgg_view('input/access', array(
		'name' => 'release_access_id',
		'value' => $sticky_values['release_access_id'] ? $sticky_values['release_access_id'] : $access_id
	)); ?>
</div>

<div class="elgg-input-wrapper">
	<label><?php echo 'Set as the recommended release'; ?></label>
	<span class="elgg-subtext">Recommend all users of this plugin use this release?</span><br />
	<?php
		echo elgg_view("input/radio",array(
			"name" => "recommended",
			"value" => $sticky_values['recommended'] ? $sticky_values['recommended'] : $recommended,
			'options' => array(
				elgg_echo('plugins:yes') => 'yes',
				elgg_echo('plugins:no') => 'no',
			),
		));
	?>
</div>