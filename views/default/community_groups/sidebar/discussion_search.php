<?php

/**
 * Group discussion search
 */

$search_string = elgg_echo('search');

?>
<div class="sidebarBox">
<h3><?php echo elgg_echo('cg:search:discussions'); ?></h3>
<form id="groupsearchform" action="<?php echo $vars['url']; ?>pg/search/" method="get">
	<input type="text" name="q" value="<?php echo $search_string; ?>" onclick="if (this.value=='<?php echo $search_string; ?>') { this.value='' }" class="search_input" />
	<input type="hidden" name="search_type" value="discussion" />
	<input type="submit" value="<?php echo elgg_echo('go'); ?>" />
</form>
</div>