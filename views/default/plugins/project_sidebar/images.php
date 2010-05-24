<?php

$project = $vars['entity'];
?>

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

<?php

$img_files = elgg_get_entities_from_relationship(array(
	'relationship_guid' => $project->getGUID(),
	'relationship' => 'image',
	'order_by' => 'guid'
));

// we only have 4 and they need to be in a specific order
// so hard-code this for now.
$image_1 = $image_2 = $image_3 = $image_4 = NULL;

if (is_array($img_files) && count($img_files)) {
echo '<div class="sidebarBox">'
. "<h3>" . elgg_echo('Images') . "</h3>";
echo "<div class=\"contentWrapper\">";
	foreach ($img_files as $file) {
		if ($thumb = get_entity($file->thumbnail_guid)) {
			$src = "{$vars['url']}pg/plugins_image/{$thumb->getGUID()}/{$thumb->time_created}.jpg";
			$link = "{$vars['url']}pg/plugins_image/{$file->getGUID()}/{$file->time_created}.jpg";

			if ($project->canEdit()) {
				$ts = time();
				$token = generate_action_token($ts);
				$delete = elgg_view('output/confirmlink',array(
					'href' => $vars['url'] . "/action/plugins/delete_project_image?project_guid={$project->getGUID()}&image_guid={$file->getGUID()}&__elgg_ts=$ts&__elgg_token=$token",
					'text' => '[X]',
					'confirm' => elgg_echo("plugins:delete_project_image:confirm"),
					//'js' => 'style="color: #f00;"'
				));
			} else {
				$delete= '';
			}
			$title = str_replace('"', '\"', $file->title);
			$image_i = "image_{$file->project_image}";
			${$image_i} = "<a class=\"project_image\" title=\"$title\" href=\"$link\"><img src=\"$src\" /></a>$delete\n";
		}
	}
	echo "$image_1 $image_2 $image_3 $image_4";
echo '</div></div>';
}
?>

