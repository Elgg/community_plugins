<?php
$type = $vars['type'];
if (!isloggedin()) {
	$subtype = 'loggedout';
	$id = '';
} else {
	$subtype = 'loggedin';
	$id = rand(1, 4);
}
?>
<div class="sidebarBox">
	<h3><?php echo elgg_echo("cg:$type:howto"); ?></h3>
	<div class="contentWrapper">
	<?php echo autop(elgg_echo("cg:howto:$type:$subtype:$id")); ?>
	</div>
</div>