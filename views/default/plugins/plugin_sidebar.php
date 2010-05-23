<?php
/**
 * Main plugin view header
 **/

//get the plugin project
$project = $vars['entity'];

if (!$dls = get_annotations_sum($vars['entity']->guid, '', '', 'download')) {
	$dls = 0;
}

//get all users other plugins
$all_user_plugins = get_entities("object", "plugin_project", $project->owner_guid,"", 99, 0);

$user = get_entity($project->owner_guid);
$username = $user->username;

if ($project->canEdit()){
	$ts = time();
	$token = generate_action_token($ts);

	$delete = elgg_view('output/confirmlink',array(
		'href' => $vars['url'] . "action/plugins/delete_project?project_guid={$project->getGUID()}&__elgg_ts=$ts&__elgg_token=$token",
		'text' => 'Delete Project',
		'confirm' => elgg_echo("plugins:delete_project:confirm"),
	));

	?>
<div class="sidebarBox">
	<h3><?php echo elgg_echo('Project Admin'); ?></h3>
	<div class="contentWrapper">
		<ul class="plugins_menu">
			<li><a href="<?php echo $vars['url']; ?>mod/community_plugins/create_release.php?project_guid=<?php echo $project->guid; ?>">Upload New Release</a></li>
			<li><a href="<?php echo $vars['url']; ?>mod/community_plugins/edit_project.php?project_guid=<?php echo $project->guid; ?>">Edit Project Details</a></li>
			<li><?php echo $delete; ?></li>
		</ul>
	</div>
</div>
<?php
}
?>

<div class="sidebarBox pluginsrepo_details">
	<h3><?php echo elgg_echo('Info'); ?></h3>
	<div class="contentWrapper">
	<?php
		if ($project->author_homepage) {
			echo "<a href=\"{$project->homepage}\">" . "Author homepage" . "</a><br />";
		}

		if ($project->homepage) {
			echo "<a href=\"{$project->homepage}\">" . "Plugin homepage" . "</a><br />";
		}

		if ($project->repo) {
			echo "<a href=\"{$project->repo}\">" . "Code repository" . "</a><br />";
		}
		
		if ($project->donate) {
			echo "<a href=\"{$project->donate}\">" . "Donations" . "</a><br />";
		}
	?>
	<b><?php echo elgg_echo('plugins:category'); ?>:</b> <a href="<?php echo $vars['url']; ?>mod/community_plugins/search.php?category=<?php echo $project->plugincat; ?>"><?php echo $project->plugincat; ?></a><br />
	<b><?php echo elgg_echo('license'); ?>:</b> <?php echo elgg_echo('license:' . $project->license); ?><br />
	<b><?php echo elgg_echo('plugins:updated'); ?>:</b> <?php echo friendly_time($project->time_updated); ?><br />
	<b>Downloaded: </b> <?php echo $dls; ?><br /><br />
	</div>
</div>
<div class="sidebarBox">
<?php
	echo "<h3>" . elgg_echo('Releases') . "</h3>";
	echo "<div class=\"contentWrapper\">";
	// show author recommened and latest
	// but only once.
	$ignore_guids = array();

	// check that it's a real entity and we have access to it
	if ($recommended = get_entity($project->recommended_release_guid)) {
		$ignore_guids[] = $project->recommended_release_guid;

		$download_link = "<a href=\"{$recommended->getURL()}\">" . $recommended->version . "</a>";

		if ($recommended->canEdit()) {
			$ts = time();
			$token = generate_action_token($ts);

			$delete = elgg_view('output/confirmlink',array(
				'href' => $vars['url'] . "/action/plugins/delete_release?release_guid={$recommended->getGUID()}&__elgg_ts=$ts&__elgg_token=$token",
				'text' => 'delete',
				'confirm' => elgg_echo("plugins:delete_release:confirm"),
			));
			$delete_link = "[$delete]";
			$edit_link = "[<a href=\"{$vars['url']}mod/community_plugins/edit_release.php?project_guid={$project->getGUID()}&release_guid={$recommended->getGUID()}\">edit</a>]";
		} else {
			$edit_link = $delete_link = '';
		}

		echo "<div class=\"filerepo_download\">Author Recommended: $download_link $delete_link $edit_link</div>";
	}

	//get all plugins associated with the project
	$plugins = elgg_get_entities(array('container_guid' => $project->getGUID()));

	if ($plugins) {
		// display latest
		// @todo should this display in addition to the recommended if they're the same?
		$latest = $plugins[0];
		if ($latest && $latest->getGUID() != $project->recommended_release_guid) {
			unset($plugins[0]);
			$ignore_guids[] = $latest->getGUID();

			$time = friendly_time($latest->time_created);
			$download_link = "<a href=\"{$latest->getURL()}\">"
				. $latest->version . " ($time)</a>";

			if ($latest->canEdit()) {
				$ts = time();
				$token = generate_action_token($ts);

				$delete = elgg_view('output/confirmlink',array(
					'href' => $vars['url'] . "/action/plugins/delete_release?release_guid={$latest->getGUID()}&__elgg_ts=$ts&__elgg_token=$token",
					'text' => 'delete',
					'confirm' => elgg_echo("plugins:delete_release:confirm"),
				));
				$delete_link = "[$delete]";
				$edit_link = "[<a href=\"{$vars['url']}mod/community_plugins/edit_release.php?project_guid={$project->getGUID()}&release_guid={$latest->getGUID()}\">edit</a>]";
			} else {
				$edit_link = $delete_link = '';
			}

			echo "<div class=\"filerepo_download\">Latest: $download_link $delete_link $edit_link</div>";
		}

		echo '<hr style="margin: 0.5em 0;"/>Previous releases:';
		if($plugins){
			foreach ($plugins as $p) {
				if (in_array($p->getGUID(), $ignore_guids)) {
					continue;
				}
				$time = friendly_time($p->time_created);
				$download_link = "<a href=\"{$p->getURL()}\">"
					. $p->version . " ($time)</a>";

				if ($p->canEdit()) {
					$ts = time();
					$token = generate_action_token($ts);

					$delete = elgg_view('output/confirmlink',array(
						'href' => $vars['url'] . "/action/plugins/delete_release?release_guid={$p->getGUID()}&__elgg_ts=$ts&__elgg_token=$token",
						'text' => 'delete',
						'confirm' => elgg_echo("plugins:delete_release:confirm"),
					));
					$delete_link = "[$delete]";

					$edit_link = "[<a href=\"{$vars['url']}mod/community_plugins/edit_release.php?project_guid={$project->getGUID()}&release_guid={$p->getGUID()}\">edit</a>]";
				} else {
					$edit_link = $delete_link = '';
				}

				echo "<div class=\"filerepo_download\">$download_link $delete_link $edit_link</div>";
			}
		} else {
			echo '<div class="filerepo_download">None</div>';
		}
	}
	echo "</div>";
?>
</div>

<script src="<?php echo $vars['url']; ?>mod/community_plugins/vendors/jquery.lightbox.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('a.project_image').lightBox({
		imageLoading: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-ico-loading.gif',
		imageBtnClose: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-btn-close.gif',
		imageBtnPrev: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-btn-prev.gif',
		imageBtnNext: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-btn-next.gif',
		imageBlank: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-blank.gif',
		containerResizeSpeed: 300
	});
});
</script>

<?php

$img_files = elgg_get_entities_from_relationship(array(
	'relationship_guid' => $project->getGUID(),
	'relationship' => 'image',
	'order_by' => 'guid'
));

// we only have 4 and they need to be in a specific order
// so hard-code this for now.
$image_1 = $image_2 = $image_3 = $image_4 = NULL;

if (is_array($img_files) && count($img_files)) {
echo '<div class="sidebarBox">'
. "<h3>" . elgg_echo('Images') . "</h3>";
echo "<div class=\"contentWrapper\">";
	foreach ($img_files as $file) {
		if ($thumb = get_entity($file->thumbnail_guid)) {
			$src = "{$vars['url']}pg/plugins_image/{$thumb->getGUID()}/{$thumb->time_created}.jpg";
			$link = "{$vars['url']}pg/plugins_image/{$file->getGUID()}/{$file->time_created}.jpg";

			if ($project->canEdit()) {
				$ts = time();
				$token = generate_action_token($ts);
				$delete = elgg_view('output/confirmlink',array(
					'href' => $vars['url'] . "/action/plugins/delete_project_image?project_guid={$project->getGUID()}&image_guid={$file->getGUID()}&__elgg_ts=$ts&__elgg_token=$token",
					'text' => '[X]',
					'confirm' => elgg_echo("plugins:delete_project_image:confirm"),
					//'js' => 'style="color: #f00;"'
				));
			} else {
				$delete= '';
			}
			$title = str_replace('"', '\"', $file->title);
			$image_i = "image_{$file->project_image}";
			${$image_i} = "<a class=\"project_image\" title=\"$title\" href=\"$link\"><img src=\"$src\" /></a>$delete\n";
		}
	}
	echo "$image_1 $image_2 $image_3 $image_4";
echo '</div></div>';
}
?>

<div class="sidebarBox">
	More projects by <?php echo get_user($project->owner_guid)->name; ?>: <br />
	<?php
		if($all_user_plugins){
			echo "<select class='choose_plugin' onchange=\"window.open(this.options[this.selectedIndex].value,'_top')\">";
			foreach($all_user_plugins as $up){
				if(get_input('guid') == $up->guid)
					$selected = "SELECTED";
				else
					$selected = '';
				echo "<option value=\"{$up->getURL()}\" $selected>{$up->title}</option>";
			}
			echo "</select>";
		}
	?>
</div>
