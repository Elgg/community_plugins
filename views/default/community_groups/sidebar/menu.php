<div class="sidebarBox">
	<div id="owner_block_submenu">
		<ul>
<?php
if (isloggedin()) {
	$username = get_loggedin_user()->username;
	echo "<li><a href=\"{$vars['url']}pg/groups/member/$username/\">". elgg_echo('groups:yours') ."</a></li>";
	echo "<li><a href=\"{$vars['url']}pg/groups/invitations/$username/\">". elgg_echo('groups:invitations') ."</a></li>";
	if (isadminloggedin()) {
		echo "<li><a href=\"{$vars['url']}pg/groups/new/\">". elgg_echo('groups:new') ."</a></li>";
	}
}
?>
		</ul>
	</div>
</div>