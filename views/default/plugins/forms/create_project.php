<?php
/**
 * Create new plugin project view
 */
?>
<form action="<?php echo $vars['url']; ?>action/plugins/create_project" enctype="multipart/form-data" method="post">

<?php
echo elgg_view('plugins/forms/project_details_segment');
echo elgg_view('plugins/forms/release_details_segment');

if (isset($vars['container_guid'])) {
	echo "<input type=\"hidden\" name=\"container_guid\" value=\"{$vars['container_guid']}\" />";
}

if (isset($vars['entity'])) {
	echo "<input type=\"hidden\" name=\"plugins_guid\" value=\"{$vars['entity']->getGUID()}\" />";
}

echo elgg_view('input/securitytoken');
echo '<div class="plugins_save_wrapper">';
echo elgg_view('input/submit', array('value' => elgg_echo("save")));
echo '</div>';
?>

</form>
