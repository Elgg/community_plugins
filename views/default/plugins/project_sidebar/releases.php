<?php
/**
 * Sidebar box for list of releases
 */

$project = $vars['entity'];
?>
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

		$time = friendly_time($recommended->time_created);
		$download_link = "<a href=\"{$recommended->getURL()}\">" . 
			$recommended->version . " ($time)</a>";

		if ($recommended->canEdit()) {

			$delete = elgg_view('output/confirmlink', array(
				'href' => "/action/plugins/delete_release?release_guid={$recommended->getGUID()}",
				'text' => 'delete',
				'confirm' => elgg_echo("plugins:delete_release:confirm"),
			));
			$delete_link = "[$delete]";
			$edit_link = "[<a href=\"" . elgg_get_site_url() . "plugins/edit/release/{$recommended->getGUID()}\">edit</a>]";
		} else {
			$edit_link = $delete_link = '';
		}

		echo "<div class=\"plugins_release_links\">Author Recommended: $download_link $delete_link $edit_link</div>";
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

				$delete = elgg_view('output/confirmlink',array(
					'href' => "/action/plugins/delete_release?release_guid={$latest->getGUID()}",
					'text' => 'delete',
					'confirm' => elgg_echo("plugins:delete_release:confirm"),
				));
				$delete_link = "[$delete]";
				$edit_link = "[<a href=\"" . elgg_get_site_url() . "plugins/edit/release/{$latest->getGUID()}\">edit</a>]";
			} else {
				$edit_link = $delete_link = '';
			}

			echo "<div class=\"plugins_release_links\">Latest: $download_link $delete_link $edit_link</div>";
		}

		echo '<hr style="margin: 0.5em 0;"/>Previous releases:';
		if ($plugins) {
			foreach ($plugins as $p) {
				if (in_array($p->getGUID(), $ignore_guids)) {
					continue;
				}
				$time = friendly_time($p->time_created);
				$download_link = "<a href=\"{$p->getURL()}\">"
					. $p->version . " ($time)</a>";

				if ($p->canEdit()) {

					$delete = elgg_view('output/confirmlink',array(
						'href' => "/action/plugins/delete_release?release_guid={$p->getGUID()}",
						'text' => 'delete',
						'confirm' => elgg_echo("plugins:delete_release:confirm"),
					));
					$delete_link = "[$delete]";

					$edit_link = "[<a href=\"" . elgg_get_site_url() . "plugins/edit/release/{$p->getGUID()}\">edit</a>]";
				} else {
					$edit_link = $delete_link = '';
				}

				echo "<div class=\"plugins_release_links\">$download_link $delete_link $edit_link</div>";
			}
		} else {
			echo '<div class="plugins_release_links">None</div>';
		}
	}
	echo "</div>";
?>
</div>
