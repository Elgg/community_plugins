<?php
$type = $vars['type'];
if (!elgg_is_logged_in()) {
	$subtype = 'loggedout';
	$id = '';
} else {
	$subtype = 'loggedin';
	$id = rand(1, 4);
}
?>
<div class="sidebarBox">
	<h3><?php echo elgg_echo("cg:$type:howto"); ?></h3>
	<div class="sidebarWrapper">
	<?php echo autop(elgg_echo("cg:howto:$type:$subtype:$id")); ?>
	</div>
</div>