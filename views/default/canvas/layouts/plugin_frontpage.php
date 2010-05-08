<?php

/**
 * Elgg plugins frontpage layout
 */

?>
<script src="<?php echo $vars['url']; ?>mod/community_plugins/vendors/custom-form-elements.js" type="text/javascript"></script>
<div id="plugins_gallery">

	<div id="rhs_column">
		<div class="categories_box">
			<h2><?php echo elgg_echo('plugins:categories'); ?></h2>
			<ul>
<?php
if (isloggedin()) {
	$count_user_plugins = get_entities("object", "plugin_project", get_loggedin_userid(), "", 10, 0, true);
?>
				<li class="my_plugins"><b><a href="<?php echo $vars['url']; ?>pg/plugins/<?php echo $vars['user']->username; ?>"><?php echo elgg_echo('plugins:myplugins'); ?></a></b> (<?php echo $count_user_plugins; ?>)</li>
<?php
}

$all_plugins_count = get_entities("object", "plugin_project", 0, "", 0, 0, true);
$url = $vars['url'] . "mod/community_plugins/search.php?category=all";
?>
				<li><b><a href="<?php echo $url; ?>"><?php echo elgg_echo('plugins:All'); ?></a></b> (<?php echo $all_plugins_count; ?>)</li>
<?php

//number of plugins in each category
foreach ($vars['config']->plugincats as $value => $option) {
	$counter = (int)get_entities_from_metadata("plugincat", $value, "object", "plugin_project",0,10,0,"",0,true);
	echo "<li><a href=\"{$vars['url']}mod/community_plugins/search.php?category={$value}\">".$option."</a> ({$counter})</li>";
}
?>
			</ul>

		</div>
	</div><!-- /rhs_column -->
	<div id="lhs_column">

		<div id="spotlight_box">

			<div id="user_actions">
<?php
// only show upload button to logged in users
if (isloggedin()) {
?>
				<div class="upload_plugin">
					<a href="<?php echo $vars['url']; ?>pg/plugins/<?php echo $vars['user']->username; ?>/new/">Upload a new plugin</a>
				</div>
<?php
}
?>
			</div>

			<h1><?php echo elgg_echo('plugins:front:welcome'); ?>.</h1>
			<div class="stats">
				<?php//echo $vars['area1']; ?><br />
			</div>

			<h2><?php echo elgg_echo('plugins:front:intro:title'); ?></h2>
			<?php echo autop(elgg_echo('plugins:front:intro:text')); ?>
			<div class="clearfloat"></div>
		</div>

		<div class="search_box">
			<?php $search_url = "{$vars['url']}pg/search"; ?>
			<form id="searchform" action="<?php echo $search_url; ?>" method="get">
				<input type="hidden" name="entity_subtype" value="plugin_project" />
				<input type="hidden" name="entity_type" value="object" />
				<input type="hidden" name="search_type" value="entities" />
				<input type="text" name="q" value="search for plugins" onclick="if (this.value) { this.value='' }" />
		choose a category
				<select name="category">
					<option value="all">All</option>
					<?php
					foreach($vars['config']->plugincats as $value => $option) {
						echo "<option value=\"{$value}\">{$option}</option>";
					}
					?>
				</select>
				<input type="submit" name="submit" value="Search" class="search_plugins" />
			</form>
		</div>
	</div>

	<div class="clearfloat"></div>

	<div id="plugin_three_column">
		<div class="plugin_three_column_actual">
			<h2>Newest</h2>
<?php
if ($vars['area2']) {
	$back_color = 'odd';
	foreach ($vars['area2'] as $plug) {
		$dls = (int)get_annotations_sum($plug->getGUID(),'','','download');
		$icon = elgg_view(	"profile/icon",
							array(	'entity' => get_user($plug->owner_guid),
									'size' => 'tiny',
									'override' => true,
								)
						);
		echo "<div class=\"small_plugin_view {$back_color}\">";
		//if($plug->plugin_type == 'theme')
		//	echo $icon; //"<img src=\"{$vars['url']}mod/community_plugins/graphics/sample.png\">";
		//else
		echo $icon; //"<img src=\"{$vars['url']}mod/community_plugins/graphics/river_icon_plugin.gif\">";
		echo "<p><a href=\"{$vars['url']}mod/community_plugins/read.php?guid={$plug->guid}\">{$plug->title}</a><br />Uploaded " . friendly_time($plug->time_created) . " (" . $dls . ")</p>";
		echo "</div>";
		if ($back_color == 'odd') {
			$back_color = 'even';
		} else {
			$back_color = 'odd';
		}
	}
}
?>
		</div>
		<div class="plugin_three_column_actual">
			<h2>Most downloads</h2>
<?php
if ($vars['area3']) {
	$back_color = 'odd';
	foreach($vars['area3'] as $plug) {
		$dls = (int)get_annotations_sum($plug->getGUID(),'','','download');
		$icon = elgg_view(	"profile/icon",
							array(	'entity' => get_user($plug->owner_guid),
									'size' => 'tiny',
									'override' => true,
								)
						);
		echo "<div class=\"small_plugin_view {$back_color}\">";
		//if($plug->plugin_type == 'theme')
		//	echo $icon; //"<img src=\"{$vars['url']}mod/community_plugins/graphics/sample.png\">";
		//else
		echo $icon; //"<img src=\"{$vars['url']}mod/community_plugins/graphics/river_icon_plugin.gif\">";
		echo "<p><a href=\"{$vars['url']}mod/community_plugins/read.php?guid={$plug->guid}\">{$plug->title}</a><br />Uploaded " . friendly_time($plug->time_created) . " (" . $dls . ")</p>";
		echo "</div>";
		if ($back_color == 'odd') {
			$back_color = 'even';
		} else {
			$back_color = 'odd';
		}
	}
}
?>
		</div>
		<div class="plugin_three_column_actual">
			<h2>Most recommended</h2>
<?php
if ($vars['area4']) {
	$back_color = 'odd';
	foreach ($vars['area4'] as $plug) {
		$dls = (int)get_annotations_sum($plug->getGUID(),'','','download');
		$icon = elgg_view(	"profile/icon",
							array(	'entity' => get_user($plug->owner_guid),
									'size' => 'tiny',
									'override' => true,
								)
						);
		echo "<div class=\"small_plugin_view {$back_color}\">";
		//if($plug->plugin_type == 'theme')
		//	echo $icon; //"<img src=\"{$vars['url']}mod/community_plugins/graphics/sample.png\">";
		//else
		echo $icon; //"<img src=\"{$vars['url']}mod/community_plugins/graphics/river_icon_plugin.gif\">";
		echo "<p><a href=\"{$vars['url']}mod/community_plugins/read.php?guid={$plug->guid}\">{$plug->title}</a><br />Uploaded " . friendly_time($plug->time_created) . " (" . $dls . ")</p>";
		echo "</div>";
		if ($back_color == 'odd') {
			$back_color = 'even';
		} else {
			$back_color = 'odd';
		}
	}
}
?>

			<!-- <h2>Recently updated</h2>
<?php
if ($vars['area5']) {
	$back_color = 'odd';
	foreach($vars['area5'] as $plug) {
		$dls = (int)get_annotations_sum($plug->getGUID(),'','','download');
		$icon = elgg_view(	"profile/icon",
							array(	'entity' => get_user($plug->owner_guid),
									'size' => 'tiny',
									'override' => true,
								)
						);
		echo "<div class=\"small_plugin_view {$back_color}\">";
		//if($plug->plugin_type == 'theme')
		//	echo $icon; //"<img src=\"{$vars['url']}mod/community_plugins/graphics/sample.png\">";
		//else
		echo $icon; //"<img src=\"{$vars['url']}mod/community_plugins/graphics/river_icon_plugin.gif\">";
		echo "<p><a href=\"{$vars['url']}mod/community_plugins/read.php?guid={$plug->guid}\">{$plug->title}</a><br />Uploaded " . friendly_time($plug->time_created) . " (" . $dls . ")</p>";
		echo "</div>";
		if ($back_color == 'odd') {
			$back_color = 'even';
		} else {
			$back_color = 'odd';
		}
	}
}
?> -->
		</div>
		<div class="clearfloat"></div>
	</div>
</div>