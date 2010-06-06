<h3>Plugin download trends</h3>

<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/community_plugins/vendors/flot/jquery.flot.js"></script>

<?php
// this needs to be moved into a function
$start_date = time() - 30 * 3600 * 24;
$downloads = get_annotations(0, 'object', 'plugin_project', 'download', '', 0, 9999999, 0, 'asc', $start_date);
$histogram = array_fill(0, 30, 0);
foreach ($downloads as $download) {
	$day = (int)floor(($download->time_created - $start_date) / (3600 * 24));
	$histogram[$day]++;
}
$plot_string = '';
foreach ($histogram as $k=>$v) {
	$plot_string .= "[$k, $v],";
}
$plot_string = rtrim($plot_string, ',');
?>
<div id="plugins_download_plot"></div>

<script language="javascript" type="text/javascript">
$(function () {
    var downloads = [<?php echo $plot_string; ?>];

    $.plot($("#plugins_download_plot"), [downloads]);
});
</script>

