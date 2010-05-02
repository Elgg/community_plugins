<?php
/**
 * Elgg plugin browser.
 * Plugin renderer.
 */

global $CONFIG;

$project = $vars['entity'];

// check if we're looking at a specific version
// get the recommend if not sent
// if no recommended version, get the latest
$release = get_entity(get_input('release', $project->recommended_release_guid));

if (!$release || !($release instanceof FilePluginFile) || $release->container_guid != $project->getGUID()) {
	if ($releases = elgg_get_entities(array('container_guid' => $project->getGUID()))) {
		$release = $releases[0];
	} else {
		$release = NULL;
	}
}

if ($project){
	//set required variables
	$project_guid = $project->getGUID();
	$project_owner = get_entity($project->owner_guid);
	$project_owner_username = $project_owner->username;
	$tags = $project->tags;
	$title = $project->title;
	$desc = $project->description;
	$summary = $project->summary;
	$owner = $vars['entity']->getOwnerEntity();
	$license = $vars['entity']->license;
	$friendlytime = friendly_time($vars['entity']->time_created);
	$dls = get_annotations_sum($vars['entity']->guid,'','','download');
	$diggs = count_annotations($vars['entity']->guid, "object", "plugin_project", "plugin_digg");
	$usericon = elgg_view(
				"profile/icon", array(
										'entity' => $owner,
										'size' => 'small',
									)
			);
	if(!$dls) {
		$dls = 0;
	}

	// Start search listing version
	if (get_context() == "search") {
		echo "<div style=\"border:2px solid #efefef;margin-top:4px;\">";
		$info = "<span class='downloadsnumber'>{$dls}</span><p class='pluginName'> <a href=\"{$project->getURL()}\">{$title} </a></p>";
		if($summary)
			$info .= "<p class='description'>" . $summary . "</p>";
		$info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/plugins/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
		$info .= "</p>";
		$icon = $usericon; //"<a href=\"{$file->getURL()}\">" . elgg_view("plugins/icon", array("mimetype" => $mime, 'thumbnail' => $file->thumbnail, 'plugins_guid' => $file_guid, 'size' => 'small')) . "</a>";
		echo elgg_view_listing($icon, $info);

		//echo "<div class=\"small_plugin_view {$back_color}\">";
		//if($project->plugin_type == 'theme') {
		//	echo "<img src=\"{$vars['url']}mod/plugins/graphics/sample.png\">";
		//} else {
		//	echo "<img src=\"{$vars['url']}mod/plugins/graphics/river_icon_plugin.gif\">";
		//}
		//if ($release) {
		//	echo "<p><a href=\"{$vars['url']}pg/plugins/$project_owner_username/read/$project_guid?release={$release->getGUID()}\">{$title}</a><br />Uploaded " . $friendlytime . " - downloads (" . $dls . ")</p>";
		//} else {
		//	echo "<p><a href=\"{$vars['url']}pg/plugins/$project_owner_username/read/$project_guid\">{$title}</a><br />Uploaded " . $friendlytime . " - downloads (" . $dls . ")</p>";
		//}
		echo "</div>";

	// Start main version
	} else {
		?>
		<script type="text/javascript">
		$(document).ready(function() {
			$('#show_details').click(function() {
				$(this).next('div').next('div').slideToggle();
			});
		});
		</script>

		<div class="pluginsrepo_file">
			<div class="pluginsrepo_icon">
				<a href="<?php echo $vars['url']; ?>mod/community_plugins/download.php?plugins_guid=<?php echo $project_guid; ?>"><?php
					echo elgg_view("plugins/icon", array("mimetype" => $mime, 'thumbnail' => $project->thumbnail, 'plugins_guid' => $project_guid));
				?></a>
			</div>
			<div class="pluginsrepo_title_owner_wrapper">
			<div class="pluginsrepo_user_gallery_link"><a href="<?php echo $vars['url']; ?>mod/community_plugins/all.php">back to plugins</a></div>
			<div class="pluginsrepo_title"><h2><a href="<?php echo $project->getURL(); ?>"><?php echo $title; ?></a></h2></div>
			<div class="pluginsrepo_owner">
				<?php
					echo elgg_view("profile/icon",array('entity' => $owner, 'size' => 'tiny'));
				?>
				<p class="pluginsrepo_owner_details"><b>by <a href="<?php echo $vars['url']; ?>pg/plugins/<?php echo $owner->username; ?>"><?php echo $owner->name; ?></a></b><br />
				<small><b>First uploaded</b> <?php echo $friendlytime; ?></small></p>
				<div class="pluginsrepo_tags">
					<div class="object_tag_string">
						<?php echo elgg_view('output/tags',array('value' => $project->tags)); ?>
					</div>
				</div>
			</div>
			</div>
			<div class="pluginsrepo_maincontent pluginsrepo_description">
				<div id="recommend">
					<?php
						echo "<div id=\"num_recommend\">";
						echo "<p>" . elgg_echo($diggs) . "</p>";
						echo "</div>";
						if(!already_dugg($project) && isloggedin()) {
							$url = "{$vars['url']}action/plugins/digg?guid={$project_guid}";
							$url = elgg_add_action_tokens_to_url($url);
							echo "<div id=\"recommend_action\">";
							echo "<a href=\"{$url}\">Recommend</a>";
							echo "</div>";
						}else{
							echo "<div id=\"recommend_action\">";
							echo "<p>Recommendations</p>";
							echo "</div>";
						}
					?>
				</div>
				<div class="pluginsrepo_summary">
					<p><b>Summary:</b> <?php echo autop($summary); ?>
				</div>
				<p><b>Full description:</b><?php echo autop($desc); ?></p>
			</div>
		<?php

		if ($release) {
			echo elgg_view_entity($release);
		}

		?>
	</div>
	<?php

	if ($release && $release->comments == 'yes') {
		echo elgg_view_comments($release);
	}

	} // close if for full view
}//close first if statement which checks there is a plugin
