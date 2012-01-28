<?php
/**
 * Elgg plugin project object view.
 *
 * Four views:
 * full
 * search listing
 * front page listing (plugin_project context)
 * widget listing
 */

$project = $vars['entity'];
if (!$project) {
	return ' ';
}

// get latest release (for displaying "last updated" value)
$latest_releases = elgg_get_entities(array('container_guid' => $project->guid, 'limit' => 1));
if ($latest_releases) {
	$latest_release = $latest_releases[0];
}

// get the recommend release (or use latest, if not available)
$release = get_entity(get_input('release', $project->recommended_release_guid));
if (!$release || !($release instanceof PluginRelease)) {
	$release = $latest_release;
}

// get required variables
$project_guid = $project->getGUID();
$project_owner = get_entity($project->owner_guid);
$tags = $project->tags;
$title = $project->title;
$desc = $project->description;
$summary = $project->summary;
$license = $project->license;
$friendlytime = friendly_time($project->time_created);
$created = date('d M, Y', $project->time_created);
$updated = friendly_time($latest_release->time_created);
$downloads = $project->getDownloadCount();
$recommends = $project->countAnnotations('plugin_digg');
$usericon = elgg_view("profile/icon", array(
	'entity' => $project_owner,
	'size' => 'small',
));
$iconpath = elgg_get_site_url() . 'mod/community_plugins/graphics/icons';


switch (elgg_get_context()) {
	case 'search':
		$info = "<div class='pluginName'> <a href=\"{$project->getURL()}\">{$title} </a>";
		$info .= "<span class=\"info_item\"><img src=\"$iconpath/updated.png\" alt=\"Updated\" title=\"Updated\">$updated</span>";
		$info .= "<span class=\"info_item\"><img src=\"$iconpath/recommended.png\" alt=\"Recommendations\" title=\"Recommendations\">$recommends</span>";
		$info .= "<span class=\"info_item\"><img src=\"$iconpath/downloaded.png\" alt=\"Downloads\" title=\"Downloads\">$downloads</span>";
		$info .= '</div>';
		if ($summary) {
			$info .= "<p class='description'>" . $summary . "</p>";
		}
		$user_url = elgg_get_site_url() . "plugins/developer/{$project_owner->username}";
		$info .= "<p class=\"owner_timestamp\"><a href=\"$user_url\">{$project_owner->name}</a> {$created} ({$friendlytime})</p>";
		echo elgg_view_listing($usericon, $info);
		break;

	case 'plugin_project':
		echo elgg_view("profile/icon", array(
			'entity' => $project_owner,
			'size' => 'tiny',
			'override' => true,
		));
		echo "<p><a href=\"{$project->getURL()}\">{$title}</a><br />";
		echo "Uploaded $friendlytime ($downloads)</p>";
		break;

	case 'widget':
?>
		<div class="pluginsrepo_widget_singleitem">
			<div class="pluginsrepo_listview_icon">
				<a href="<?php echo $project->getURL(); ?>">
					<img src="<?php echo elgg_get_site_url(); ?>mod/community_plugins/graphics/icons/archive.gif" />
				</a>
			</div>
			<div class="pluginsrepo_widget_content">
				<div class="pluginsrepo_listview_title">
					<p class="filerepo_title"><?php echo $title; ?></p>
				</div>
				<div class="pluginsrepo_listview_date">
					<p class="filerepo_timestamp">
						<small><?php echo $friendlytime; ?></small>
					</p>
				</div>
			</div>
			<div class="clearfloat"></div>
		</div>
<?php
		break;
		
	case 'plugins':
?>
<div class="plugins_wrapper">
	<div class="plugins_owner_wrapper">
		<a href="<?php echo elgg_get_site_url(); ?>plugins/all" class="plugins_back_link">back to plugins</a>
		<h2><a href="<?php echo $project->getURL(); ?>"><?php echo $title; ?></a></h2>
		<div class="pluginsrepo_owner">
			<?php echo elgg_view("profile/icon", array('entity' => $project_owner, 'size' => 'tiny')); ?>
			<p class="pluginsrepo_owner_details">
				<b>by <a href="<?php echo elgg_get_site_url(); ?>plugins/developer/<?php echo $project_owner->username; ?>"><?php echo $project_owner->name; ?></a></b><br />
				<small><b>First uploaded</b> <?php echo $friendlytime; ?></small>
			</p>
			<div class="pluginsrepo_tags">
				<div class="object_tag_string">
					<?php echo elgg_view('output/tags', array('value' => $tags)); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="plugins_maincontent">
		<?php echo elgg_view('plugins/recommend', array('project' => $project)); ?>
		<h4>Summary:</h4>
		<?php echo autop($summary); ?>
		<h4>Full description:</h4>
		<?php echo autop($desc); ?>
	</div>
</div>
<?php

		if ($release) {
			echo elgg_view_entity($release);
		}

		break;
}
