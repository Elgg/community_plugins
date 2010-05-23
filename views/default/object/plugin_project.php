<?php
/**
 * Elgg plugin project object view.
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

// get the recommend release or latest
$release = get_entity(get_input('release', $project->recommended_release_guid));
if (!$release || !($release instanceof FilePluginFile)) {
	$releases = elgg_get_entities(array('container_guid' => $project->getGUID()));
	if ($releases) {
		$release = $releases[0];
	}
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
$downloads = (int)get_annotations_sum($project_guid, '', '', 'download');
$usericon = elgg_view("profile/icon", array('entity' => $project_owner,
											'size' => 'small',
											)
						);


switch(get_context()) {
	case 'search':
		$info = "<span class='downloadsnumber'>{$downloads}</span>";
		$info .= "<p class='pluginName'> <a href=\"{$project->getURL()}\">{$title} </a></p>";
		if ($summary) {
			$info .= "<p class='description'>" . $summary . "</p>";
		}
		$user_url = "{$vars['url']}pg/plugins/developer/{$project_owner->username}";
		$info .= "<p class=\"owner_timestamp\"><a href=\"$user_url\">{$project_owner->name}</a> {$friendlytime}</p>";
		echo elgg_view_listing($usericon, $info);
		break;

	case 'plugin_project':
		echo elgg_view(	"profile/icon",
						array(	'entity' => $project_owner,
								'size' => 'tiny',
								'override' => true,
							)
						);
		echo "<p><a href=\"{$project->getURL()}\">{$title}</a><br />";
		echo "Uploaded $friendlytime ($downloads)</p>";
		break;

	case 'widget':
?>
		<div class="pluginsrepo_widget_singleitem">
			<div class="pluginsrepo_listview_icon">
				<a href="<?php echo $project->getURL(); ?>">
					<img src="<?php echo $vars['url']; ?>mod/community_plugins/graphics/icons/archive.gif" />
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
		<a href="<?php echo $vars['url']; ?>pg/plugins/all" class="plugins_back_link">back to plugins</a>
		<h2><a href="<?php echo $project->getURL(); ?>"><?php echo $title; ?></a></h2>
		<div class="pluginsrepo_owner">
			<?php echo elgg_view("profile/icon", array('entity' => $project_owner, 'size' => 'tiny')); ?>
			<p class="pluginsrepo_owner_details">
				<b>by <a href="<?php echo $vars['url']; ?>pg/plugins/developer/<?php echo $project_owner->username; ?>"><?php echo $project_owner->name; ?></a></b><br />
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
		<?php echo elgg_view('plugins/digg', array('project' => $project)); ?>
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
