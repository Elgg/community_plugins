<?php

elgg_ajax_gatekeeper();

$owner = get_input('github_owner');
$repo = get_input('github_repo');

if (!$owner || !$repo) {
	register_error(elgg_echo('plugins:fetch_github_relases:missed_info'));
	forward(REFERRER);
}

$api = new \Elgg\CommunityPlugins\GithubService();
$releases = $api->getReleases($owner, $repo);

$form = elgg_view('plugins/forms/project_github_releases_segment', [
	'releases' => $releases,
]);

if (empty($form)) {
	register_error(elgg_echo('plugins:fetch_github_relases:no_releases'));
	forward(REFERRER);
}

echo $form;

