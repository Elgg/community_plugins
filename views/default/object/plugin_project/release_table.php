<?php

$plugin = elgg_extract('entity', $vars);
if (!$plugin instanceof PluginProject) {
	return;
}

// get one release for each version of elgg
$elgg_versions = elgg_get_config('elgg_versions');

$stable = elgg_extract('stable', $vars);

// create an array of releases like array('1.9' => array(PluginRelease), '1.8' => array(PluginRelease))
$releases = [];
if ($stable) {
	// only show the recommended release for each elgg version
	foreach ($elgg_versions as $v) {
		$release = $plugin->getRecommendedRelease($v);
		if ($release) {
			$releases[$v][] = $release;
		}
	}
} else {
	// show *all* versions
	// @TODO - scalability?
	$all_releases = $plugin->getReleases([
		'limit' => false,
	]);
	foreach ($elgg_versions as $v) {
		foreach ($all_releases as $ar) {
			$versions = (array) $ar->elgg_version;
			if (in_array($v, $versions)) {
				$releases[$v][] = $ar;
			}
		}
	}
}

if (empty($releases)) {
	return;
}

if (!elgg_is_xhr()) {
	echo '<div class="plugins-download-table-wrapper" data-guid="' . $plugin->guid . '">';
}

$header = elgg_echo('plugins:releases:all');
if ($stable) {
	$header = elgg_echo('plugins:recommended:releases');
}

?>
<strong><?php echo $header; ?></strong>
<table class="plugin-downloads">
	<thead>
		<tr class="head">
			<td>Elgg</td>
			<td>Release</td>
			<td>Download</td>
			<td>Date</td>
			<td>Links</td>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($releases as $elgg_version => $ra) {
			foreach ($ra as $key => $r) {
				$download = elgg_view('output/url', [
					'text' => elgg_view_icon('download'),
					'href' => 'plugins/download/' . $r->guid,
				]);

				$hr_size = elgg_format_bytes($r->getSize());
				
				$links = elgg_view('output/url', [
					'text' => elgg_view_icon('speech-bubble'),
					'href' => $r->getURL(),
					'is_trusted' => true,
				]);

				if ($r->canEdit()) {
					$links .= ' ';
					$links .= elgg_view('output/url', [
						'text' => elgg_view_icon('settings-alt'),
						'href' => 'plugins/edit/release/' . $r->guid
					]);
				}
				
				if ($r->canDelete()) {
					$links .= ' ';
					$links .= elgg_view('output/url', [
						'text' => elgg_view_icon('delete'),
						'href' => elgg_http_add_url_query_elements('action/plugins/delete_release', [
							'release_guid' => $r->guid,
						]),
						'confirm' => elgg_echo('plugins:delete_release:confirm'),
					]);
				}

				$elgg_v = $key ? '' : $elgg_version;
				
				$class = '';
				if (in_array($elgg_version, (array) $r->recommended) && !$vars['stable']) {
					$class = 'recommended';
				}

				$version = $r->version;
				if (!$version) {
					$version = elgg_echo('plugin:release:version:unknown');
				}
				echo "<tr class=\"{$class}\">";
				echo '<td>' . $elgg_v . '</td>';
				echo '<td>' . $version . '</td>';
				echo '<td>' . $download . ' <span class="elgg-subtext">(' . $hr_size . ')</span>' . '</td>';
				echo '<td>' . date('Y-M-d', $r->time_created) . '</td>';
				echo '<td>' . $links . '</td>';
				echo '</tr>';
			}
		}
		?>
	</tbody>
</table>

<?php

$release_toggle = elgg_echo('plugins:releases:show:recommended');
if ($stable) {
	$release_toggle = elgg_echo('plugins:releases:show:all');
}
echo elgg_view('output/url', [
		'text' => $release_toggle,
		'href' => '#',
		'class' => 'plugins-show-all',
		'data-stable' => $vars['stable'] ? 0 : 1
]);

if (!elgg_is_xhr()) {
	echo '</div>';
}
