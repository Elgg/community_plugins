<?php
/**
 * Project admin - edit, new release, delete
 */

$project = elgg_extract('entity', $vars);
if (!$project instanceof PluginProject) {
	return;
}

$lis = [];

if ($project->canWriteToContainer(0, 'object', PluginRelease::SUBTYPE)) {
	$lis[] = elgg_format_element('li', [], elgg_view('output/url', [
		'text' => elgg_echo('plugins:new:release'),
		'href' => "plugins/new/release/{$project->guid}",
		'is_trusted' => true,
	]));
}

if ($project->canEdit()) {
	$lis[] = elgg_format_element('li', [], elgg_view('output/url', [
		'text' => elgg_echo('plugins:edit:project'),
		'href' => "plugins/edit/project/{$project->guid}",
		'is_trusted' => true,
	]));
	$lis[] = elgg_format_element('li', [], elgg_view('output/url', [
		'text' => elgg_echo('plugins:contributors:add'),
		'href' => "plugins/contributors/{$project->guid}",
		'is_trusted' => true,
	]));
}

if ($project->canDelete()) {
	$lis[] = elgg_format_element('li', [], elgg_view('output/url', [
		'text' => elgg_echo('plugins:delete:project'),
		'href' => elgg_http_add_url_query_elements('action/plugins/delete_project', [
			'project_guid' => $project->guid,
		]),
		'is_trusted' => true,
		'confirm' => elgg_echo("plugins:delete_project:confirm"),
	]));
}

if (elgg_is_admin_logged_in()) {
	$lis[] = elgg_format_element('li', [], elgg_view('output/url', [
		'text' => elgg_echo('plugins:requests:ownership'),
		'href' => "/plugins/{$project->guid}/ownership_requests",
		'is_trusted' => true,
	]));
	
	$lis[] = elgg_format_element('li', [], elgg_view('output/url', [
		'text' => elgg_echo('plugins:transfer:ownership'),
		'href' => "/plugins/transfer/{$project->guid}",
		'is_trusted' => true,
	]));
}

echo elgg_format_element('ul', ['class' => 'plugins_menu'], implode(PHP_EOL, $lis));
