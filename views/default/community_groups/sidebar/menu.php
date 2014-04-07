<div class="sidebarBox">
	<div id="owner_block_submenu">
		<ul>
<?php
if (elgg_is_logged_in()) {
	$username = elgg_get_logged_in_user_entity()->username;
	echo "<li><a href=\"" . elgg_get_site_url() . "groups/member/$username/\">". elgg_echo('groups:yours') ."</a></li>";
	echo "<li><a href=\"" . elgg_get_site_url() . "groups/invitations/$username/\">". elgg_echo('groups:invitations') ."</a></li>";
	if (elgg_is_admin_logged_in()) {
		echo "<li><a href=\"" . elgg_get_site_url() . "groups/new/\">". elgg_echo('groups:new') ."</a></li>";
	}
}
?>
		</ul>
	</div>
</div>