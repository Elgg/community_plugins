<?php
/**
 * Project details to be used in a form body.
 */

// set defaults for new or editing
if (array_key_exists('project', $vars)
&& $vars['project'] instanceof ElggObject
&& $vars['project']->getSubtype() == 'plugin_project') {
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

	$msg = "You are editing the plugin project information for {$project->title}.  To upload a new release,
	click <a href=\"{$vars['url']}pg/plugins/new/release/{$project->getGUID()}\">here</a>.";
} else {
	$project = NULL;
	$title = $description = $homepage = $plugin_type = '';
	$license = $donate = $tags = '';

	$plugincat = 'uncategorized';
	$access_id = ACCESS_PUBLIC;
	$username = get_loggedin_user()->username;

	$msg = "You are creating a new plugin project. If you want to release a new
	version of an existing plugin, go to the edit section of that plugin's project page.
	You can view all of your plugins
	<a href=\"{$vars['url']}pg/plugins/developer/$username\">here</a>.";
}

?>
<div class="contentWrapper projectDetails">
	<h2>Project Details</h2>

	<p>
	<?php echo $msg; ?>
	</p>

	<p>
		<label>Project Name*<br />
		<?php
			echo elgg_view("input/text",array(
				"internalname" => "title",
				"value" => $title,
			));
		?>
		</label>
	</p>

	<p>
		<label>Project Summary<br />
		<span class="pluginHint">A one- or two-sentence (250 characters) summary of your project's main features.</span>
		<?php
			echo elgg_view("input/text",array(
				"internalname" => "summary",
				"value" => $summary,
				'js' => 'maxlength="250"'
			));
		?>
		</label>
	</p>

	<p>
		<label>Project Description<br />
		<span class="pluginHint">A full description of your project's features. (As per <a href="http://community.elgg.org/pg/expages/read/Terms/#plugins">policy</a>, images and links will be removed.)</span>
		<?php
			echo elgg_view("input/longtext",array(
				"internalname" => "description",
				"value" => $description,
			));
		?>
		</label>
	</p>
	<p>
		<label for="license"><?php echo elgg_echo("license"); ?>*</label><br />
		<em>
			<a href="http://www.gnu.org/philosophy/license-list.html#GPLCompatibleLicenses" target="_blank"><?php echo elgg_echo('license:blurb'); ?></a>
		</em><br />
		<?php
			echo elgg_view("input/pulldown",array(
				"internalname" => "license",
				"value" => $license,
				'options_values' => $vars['config']->gpllicenses,
			));
		?>
	</p>
	<p>
		<label>Type of Project<br />
		<?php
			echo elgg_view("input/pulldown",array(
				"internalname" => "plugin_type",
				"value" => $plugin_type,
				'options_values' => array(
					'plugin' => elgg_echo('plugins:plugin'),
					'theme' => elgg_echo('plugins:theme'),
					'languagepack' => elgg_echo('plugins:languagepack'),
				),
			));
		?>
		</label>
	</p>
	<p>
		<label for="category"><?php echo elgg_echo("plugins:category"); ?></label><br />
		<?php

			echo elgg_view("input/pulldown",array(
				"internalname" => "plugincat",
				"value" => $plugincat,
				'options_values' => $vars['config']->plugincats,
			));
		?>
	</p>
	<p>
		<label>Project Homepage<br />
		<?php
			echo elgg_view("input/text",array(
				"internalname" => "homepage",
				"value" => $homepage,
			));
		?>
		</label>
	</p>
	<p>
		<label><?php echo elgg_echo("plugins:repo"); ?><br />
		<?php echo elgg_view("input/text",array("internalname" => "repo","value" => $repo,)); ?>
		</label>
	</p>

	<p>
		<label>Donations URL (Optional)<br />
		<span class="pluginHint">If you accept donations, enter the URL to the donations section of your website.</span>
		<?php
			echo elgg_view("input/text",array(
				"internalname" => "donate",
				"value" => $donate,
			));
		?>
		</label>
	</p>
	<p>
		<label><?php echo elgg_echo("tags"); ?><br />
		<span class="pluginHint">A comma-separated list of tags relevant to your project.</span>
		<?php
			echo elgg_view("input/tags", array(
				"internalname" => "tags",
				"value" => $tags,
			));
		?>
		</label>
	</p>
	<p>
		<label>
			<?php echo elgg_echo('access'); ?><br />
			<span class="pluginHint">The access level of the project. Note that individual releases can have their own access settings.</span>
			<?php echo elgg_view('input/access', array('internalname' => 'project_access_id','value' => $access_id)); ?>
		</label>
	</p>
	<?php
		if ($project
		&& ($entities = elgg_get_entities(array('container_guid' => $project->getGUID())))
		&& is_array($entities)
		&& (count($entities) > 0)) {

			$releases = array(0 => 'No recommended release');

			$recommended = ($project->recommended_release_guid) ? $project->recommended_release_guid : 0;
			foreach ($entities as $entity) {
				$time = friendly_time($entity->time_created);
				$releases[$entity->guid] = "{$entity->version} ($time)";
			}

		}
	?>
	<p>
	<label>Project Images<br />
		<span class="pluginHint">Show off your project by uploading images!</span><br /><Br />
	</label>
	<?php
		for ($i=1; $i<=4; $i++) {
			// show existing images if any
			if ($project) {
				$options = array(
					'relationship_guid' => $project->getGUID(),
					'relationship' => 'image',
					'metadata_name_value_pair' => array('name' => 'project_image', 'value' => "$i")
				);

				if (($image = elgg_get_entities_from_relationship($options))
				&& ($image[0] instanceof ElggFile)
				&& ($thumb = get_entity($image[0]->thumbnail_guid))
				&& ($thumb instanceof ElggFile)) {
					$title = $image[0]->title;
					$src = "{$vars['url']}pg/plugins_image/{$thumb->getGUID()}/{$thumb->time_created}.jpg";
					$img = "<img style=\"float: left; padding-right: 1em;\" src=\"$src\" />\n";
					echo $img;
				} else {
					$img = $title = '';
				}
			}

			echo "<label>Description $i "
			. elgg_view('input/text', array('internalname' => "image_{$i}_desc", 'value' => $title, 'js' => 'style="width:25em;"'))
			. '</label><br />'
			. "<label>Image $i " . elgg_view('input/file', array('internalname' => "image_$i"))
			. "</label><br /><br /><br />";
		}
	?>
	</p>

</div>
