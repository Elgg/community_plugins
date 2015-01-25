<?php

$project = elgg_extract('entity', $vars);

$time_created = $project->getLatestRelease()->time_created;

$not_compatible = function() use ($project) {
	// Get the latest Elgg version
	$latest_elgg = array_shift(elgg_get_config('elgg_versions'));

	// Check if there is a release compatible with latest Elgg
	$version_found = $project->getRecentReleaseByElggVersion($latest_elgg);

	return $version_found ? false : true;
};

$year = 60 * 60 * 24 * 365;
$seconds_ago = time() - $time_created;
$years_ago = (int) floor($seconds_ago / $year);

if ($years_ago > 2 && $not_compatible()) {
	$warning = elgg_echo('plugins:project:outdated_warning', array($years_ago));

	$help = elgg_echo('plugins:project:help');

	$messages = array();

	// Link to the code repository
	if ($project->repo) {
		$pr_quide_link = elgg_view('output/url', array(
			'href' => 'https://help.github.com/articles/using-pull-requests/',
			'text' => elgg_echo('plugins:project:pull_request'),
		));

		$repo_link = elgg_view('output/url', array(
			'href' => $project->repo,
			'text' => elgg_echo('plugins:project:repo'),
		));

		$messages[] = elgg_echo('plugins:project:collaborate', array($pr_quide_link, $repo_link));
	}

	// Link to form for requesting project ownership
	$ownership_form_link = elgg_view('output/url', array(
		'href' => "plugins/{$project->guid}/ownership_request",
		'text' => elgg_echo('plugins:project:request'),
	));
	$messages[] = elgg_echo('plugins:project:request_ownership', array($ownership_form_link));

	$suggestions = '';
	foreach ($messages as $message) {
		$suggestions .= "<li>$message</li>";
	}

	echo <<<HTML
<div class="elgg-box-error elgg-plugin-warning elgg-output mbl">
	<p>$warning</p>
	<p>$help</p>
	<ul>$suggestions</ul>
</div>
HTML;
}
