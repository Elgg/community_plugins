<?php
/**
 * Release details for use inside a form body.
 */

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
	// encourage authors to have recommended versions if they don't
	$recommended = (!$project || ($project && $project->recommended_release_guid > 0)) ? 'no' : 'yes';
	$access_id = ($project) ? $project->access_id : ACCESS_PUBLIC;
}

?>

<div class="contentWrapper releaseDetails">
	<h2>Plugin Details</h2>
	<p>This information is specific to the release you are uploading right now.  To edit the
	general project details, visit the edit section of the project page.</p>

<?php if (!$release) { ?>
	<p>
		<label><?php echo elgg_echo("plugins:file"); ?><br />
		<span class="pluginHint">Uploaded files must contain a working plugin or theme.  Any plugin containing ads will be deleted and the user banned.  Distribution packages must be .zip, .tar.gz, or .tgz files.</span><br />
		<?php
			echo elgg_view("input/file",array('internalname' => 'upload'));
		?>
		</label>
	</p>
<?php } ?>

	<p>
		<label>Release version<br />

		<?php
			echo elgg_view("input/text",array(
				"internalname" => "version",
				"value" => $version,
				'js' => 'style="width: 3em;"',
			));
		?>
		</label>
	</p>

	<p>
		<label>Release Notes:<br />
		<span class="pluginHint">A list of changes, bugfixes, bugs, todos, and general release notes for this release. (As per <a href="http://community.elgg.org/pg/expages/read/Terms/#plugins">policy</a>, images and links will be removed.)</span><br />

		<?php
			echo elgg_view("input/longtext",array(
				"internalname" => "release_notes",
				"value" => $release_notes,
			));
		?>
		</label>
	</p>

	<p>
	<label>Elgg compatibility<br />
	<span class="pluginHint">The version of Elgg this plugin was developed and tested on</span><br />
	<?php
		echo elgg_view("input/pulldown",array(
			"internalname" => "elgg_version",
			"value" => $elgg_version,
			'options' => $vars['config']->elgg_versions
		));
	?>
	</label>
	</p>

	<p>
		<label>
			<?php echo 'Allow comments'; ?><br />
			<?php

				echo elgg_view("input/radio",array(
					"internalname" => "comments",
					"value" => $comments,
					'options' => array(
						elgg_echo('plugins:yes') => 'yes',
						elgg_echo('plugins:no') => 'no',
					),
				));
			?>
		</label>
	</p>

	<p>
		<label>
			<?php echo elgg_echo('access'); ?><br />
			<span class="pluginHint">The access level of this release. Useful if you want to release only to a certain group or collection.</span>
			<?php echo elgg_view('input/access', array(
				'internalname' => 'release_access_id',
				'value' => $access_id
			)); ?>
		</label>
	</p>

	<p>
		<label>
			<?php echo 'Set as the recommended release'; ?><br />
			<span class="pluginHint">Recommend all users of this plugin use this release?</span><br />

			<?php
				echo elgg_view("input/radio",array(
					"internalname" => "recommended",
					"value" => $recommended,
					'options' => array(
						elgg_echo('plugins:yes') => 'yes',
						elgg_echo('plugins:no') => 'no',
					),
				));
			?>
		</label>
	</p>

</div>
