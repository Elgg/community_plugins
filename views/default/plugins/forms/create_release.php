<?php
/**
 * Upload new release view
 */

if (array_key_exists('project', $vars) && $vars['project'] instanceof ElggObject) {
	$project_guid = $vars['project']->getGUID();
}

?>
<form action="<?php echo elgg_get_site_url(); ?>action/plugins/create_release" enctype="multipart/form-data" method="post">
<?php
echo elgg_view('plugins/forms/release_details_segment', $vars);
echo elgg_view("input/hidden", array("internalname" => "guid", "value" => $project_guid,));
echo elgg_view('input/securitytoken');
echo '<div class="plugins_save_wrapper">';
echo elgg_view('input/submit', array('value' => elgg_echo('save')));
echo '</div>';
?>
</form>
