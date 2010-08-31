<?php

$project = $vars['entity'];

// ordering by guid does not guarantee the correct order
$img_files = elgg_get_entities_from_relationship(array(
	'relationship_guid' => $project->getGUID(),
	'relationship' => 'image',
	'order_by' => 'guid'
));

if ($img_files === FALSE || count($img_files) == 0) {
	return TRUE;
}
?>
<div class="sidebarBox">
	<h3>Images</h3>
	<div class="contentWrapper">
<?php
foreach ($img_files as $file) {
	$thumb = get_entity($file->thumbnail_guid);
	if (!$thumb) {
		continue;
	}

	$src = "{$vars['url']}mod/community_plugins/image.php?guid={$thumb->getGUID()}";
	$link = "{$vars['url']}mod/community_plugins/image.php?guid={$file->getGUID()}";

	echo "<div class=\"project_image_wrapper\">";
	echo "<a class=\"project_image\" title=\"$file->title\" href=\"$link\"><img src=\"$src\" /></a>";

	if ($project->canEdit()) {
		$url = "{$vars['url']}action/plugins/delete_project_image?project_guid={$project->getGUID()}&image_guid={$file->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		echo elgg_view('output/confirmlink',array(
				'href' => $url,
				'text' => 'delete',
				'confirm' => elgg_echo("plugins:delete_project_image:confirm"),
		));
	}
	echo "</div>";
}
?>
		<div class="clearfloat"></div>
	</div>
</div>

<script src="<?php echo $vars['url']; ?>mod/community_plugins/vendors/jquery.lightbox.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('a.project_image').lightBox({
		imageLoading: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-ico-loading.gif',
		imageBtnClose: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-btn-close.gif',
		imageBtnPrev: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-btn-prev.gif',
		imageBtnNext: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-btn-next.gif',
		imageBlank: '<?php echo $vars['url']; ?>mod/community_plugins/vendors/images/lightbox-blank.gif',
		containerResizeSpeed: 300
	});
});
</script>
