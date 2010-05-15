<?php
/**
 * Layout for search and categories
 */

$category = get_input('category', 'all');

$query = stripslashes(get_input('q', ''));


if ($query != '') {
	$title = sprintf(elgg_echo('plugins:search:title'), $query, $category);
} else {
	$title = sprintf(elgg_echo('plugins:category:title'), $category);
}

?>

<script src="<?php echo $vars['url']; ?>mod/community_plugins/vendors/custom-form-elements.js" type="text/javascript"></script>
<div id="plugins_gallery">

	<div id="plugins_welcome">
		<h2><?php echo $title; ?></h2>
	</div>
	<div class="clearfloat"></div>
	<div id="rhs_column">
		<div class="categories_box">
		<b><a href="<?php echo $vars['url']; ?>/pg/plugins/all/">Plugins home</a></b>
		</div>
		<div class="categories_box">
			<h2>Categories</h2>
			<ul>
		<?php
			if(isloggedin()){
				$count_user_plugins = get_entities("object", "plugin_project", $_SESSION['user']->guid, "", 10, 0, true);
		?>
			<li class="my_plugins"><b><a href="<?php echo $vars['url']; ?>pg/plugins/<?php echo $vars['user']->username; ?>">My plugins</a></b> (<?php echo $count_user_plugins; ?>)</li>
		<?php
			}
		?>
		<?php
		$all_plugins = get_entities("object", "plugin_project", FALSE, "", 0, 0, true);
		echo "<li><b><a href=\"{$vars['url']}mod/community_plugins/search.php?category=all\">All</a></b> (".$all_plugins.")</li>";
		?>
			<?php
				$counter = 0; //number of plugins in the category
				foreach($vars['config']->plugincats as $value => $option){
					//count the number of plugins per cat
					$counter = get_entities_from_metadata("plugincat", $value, "object", "plugin_project",0,10,0,"",0,true);
					if(!$counter)
						$counter = 0;
					if($value == $category)
						$selected = "class=selected";
					else
						$selected = '';
					echo "<li {$selected}><a href=\"{$vars['url']}mod/community_plugins/search.php?category={$value}\">".$option."</a> ({$counter})</li>";
					//reset the counter
					$counter = 0;
				}
			?>
			</ul>
		</div>
	</div><!-- /rhs_column -->
	<div id="lhs_column">
		<div class="search_box">
			<?php
				$search_url = "{$vars['url']}pg/search";
			?>
			<form id="searchform" action="<?php echo $search_url; ?>" method="get">
			<input type="hidden" name="entity_subtype" value="plugin_project" />
			<input type="hidden" name="entity_type" value="object" />
			<input type="hidden" name="search_type" value="entities" />
			<input type="text" name="q" value="<?php echo $query; ?>" onclick="if (this.value) { this.value='' }" />
			choose a category
			<select name="category">
			<option value="all">All</option>
			<?php
					foreach($vars['config']->plugincats as $value => $option){
						if($value == $category) {
							$selected = "SELECTED";
						} else {
							$selected = '';
						}

						echo "<option value=\"{$value}\" {$selected}>{$option}</option>";
					}
			?>
			</select>
			<input type="submit" name="submit" value="go" class='search_plugins' />
			</form>
		</div>


		<div id="search_results">
			<?php
				if($vars['area2']) {
					echo $vars['area2'];
				}
			?>
		</div>

	</div>
</div>