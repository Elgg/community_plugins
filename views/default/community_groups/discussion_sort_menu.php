<?php
$filter = $vars['filter'];
$url = elgg_get_site_url() . "groups/discussion/";
?>
<div id="elgg_horizontal_tabbed_nav">
<ul>
	<li <?php if($filter == "latest") echo "class='selected'"; ?>><a href="<?php echo $url; ?>latest/"><?php echo elgg_echo('groups:discussion:latest'); ?></a></li>
<?php
if (elgg_is_logged_in()) {
?>
	<li <?php if($filter == "mygroups") echo "class='selected'"; ?>><a href="<?php echo $url; ?>mygroups/"><?php echo elgg_echo('groups:discussion:mygroups'); ?></a></li>
<?php
/*
<li <?php if($filter == "mine") echo "class='selected'"; ?>><a href="<?php echo $url; ?>mine/"><?php echo elgg_echo('groups:discussion:mine'); ?></a></li>
*/
?>
<?php
}
?>
</ul>
</div>
