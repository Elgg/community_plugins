<?php
/**
 * Stats tab
 * 
 */

?>
<h3>Plugin download trends</h3>
<p>
	This displays the downloads for the past 30 days. To see the downloads
	for a particular plugin, enter the GUID of the plugin project below.
</p>
<?php
echo elgg_view('plugins/admin/stats/plugin_select');

// default parameters for downloads plot
$num_days = 30;
$guid = (int)get_input('guid', 0);
if ($guid != 0) {
	$num_days = 0;
}

if ($guid) {
	$project = get_entity($guid);
	echo "<h4>Stats for $project->title</h4>";
} else {
	echo "<h4>Stats for all plugins</h4>";
}

$histogram = plugins_get_downloads_histogram($guid, $num_days);

// create string for flot
$plot_string = '';
foreach ($histogram as $k=>$v) {
	$plot_string .= "[$k, $v],";
}
$plot_string = rtrim($plot_string, ',');

?>
<div id="plugins_download_plot"></div>

<script type="text/javascript" src="<?php echo elgg_get_site_url(); ?>mod/community_plugins/vendors/flot/jquery.flot.js"></script>
<script language="javascript" type="text/javascript">
$(function () {
    var downloads = [<?php echo $plot_string; ?>];

    $.plot($("#plugins_download_plot"), [downloads]);
});
</script>

<?php

if ($guid) {
	echo elgg_view('plugins/admin/stats/normalize', array('guid' => $guid));
}
