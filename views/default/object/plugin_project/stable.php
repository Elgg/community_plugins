<?php
$plugin = $vars['entity'];

// get one release for each version of elgg
$elgg_versions = elgg_get_config('elgg_versions');

// create an array of releases like array('1.9' => PluginRelease, '1.8' => PluginRelease)
$releases = array();
foreach ($elgg_versions as $v) {
	$release = $plugin->getRecentReleaseByElggVersion($v);
	if ($release) {
		$releases[$v] = $release;
	}
}

if (!$releases) {
	return;
}
?>
<strong><?php echo elgg_echo('plugins:latest:releases'); ?></strong>
<table class="plugin-downloads">
	<thead>
		<tr class="head">
			<td>Elgg Version</td>
			<td>Release</td>
			<td>Download</td>
			<td>Date</td>
			<td>Links</td>
		</tr>
	</thead>
	<?php
	foreach ($releases as $elgg_version => $r) {
		$download = elgg_view('output/url', array(
			'text' => $r->originalfilename,
			'href' => 'plugins/download/' . $r->guid,
		));

		$base = log($r->getSize()) / log(1024);
		$suffixes = array('', 'KB', 'MB', 'GB', 'TB');
		$hr_size = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];

		$links = elgg_view('output/url', array(
			'text' => elgg_echo('discussion'),
			'href' => $r->getURL(),
			'is_trusted' => true
		));

		echo '<tr>';
		echo '<td>' . $elgg_version . '</td>';
		echo '<td>' . $r->version . '</td>';
		echo '<td>' . $download . ' (' . $hr_size . ')' . '</td>';
		echo '<td>' . date('Y-M-d', $r->time_created) . '</td>';
		echo '<td>' . $links . '</td>';
		echo '</tr>';
	}
	?>
</table>