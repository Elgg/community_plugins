<?php
/**
 * Sidebar box for plugin project information: homepage, repository, donations
 */

$project = $vars['entity'];

?>
<ul class="plugins_menu">
<?php
	if ($project->author_homepage) {
		echo "<li><a href=\"{$project->homepage}\">" . elgg_echo('plugins:author:homepage') . "</a></li>";
	}

	if ($project->homepage) {
		echo "<li><a href=\"{$project->homepage}\">" . elgg_echo('plugins:homepage') . "</a></li>";
	}

	if ($project->repo) {
		echo "<li><a href=\"{$project->repo}\">" . elgg_echo('plugins:repo') . "</a></li>";
	}

	if ($project->donate) {
		echo "<li><a href=\"{$project->donate}\">" . elgg_echo('plugins:donate') . "</a></li>";
	}
?>
</ul>
