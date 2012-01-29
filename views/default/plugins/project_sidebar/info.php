<?php
/**
 * Sidebar box for plugin project information: homepage, repository, donations
 */

$project = $vars['entity'];

?>
<ul class="plugins_menu">
<?php
	if ($project->author_homepage) {
		echo "<li><a href=\"{$project->homepage}\">" . "Author homepage" . "</a></li>";
	}

	if ($project->homepage) {
		echo "<li><a href=\"{$project->homepage}\">" . "Plugin homepage" . "</a></li>";
	}

	if ($project->repo) {
		echo "<li><a href=\"{$project->repo}\">" . "Code repository" . "</a></li>";
	}

	if ($project->donate) {
		echo "<li><a href=\"{$project->donate}\">" . "Donations" . "</a></li>";
	}
?>
</ul>
