<?php

$project = $vars['entity'];

if ($project->author_homepage || $project->homepage || $project->repo || $project->donate) {
?>
<div class="sidebarBox">
	<h3><?php echo elgg_echo('Project Info'); ?></h3>
	<div class="contentWrapper">
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
	</div>
</div>
<?php
}
