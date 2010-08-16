<?php

	/**
	 * A simple view to provide the user with group filters and the number of group on the site
	 **/

	 $num_groups = $vars['count'];
	 if(!$num_groups)
	 	$num_groups = 0;

	 $filter = $vars['filter'];

	 //url
	 $url = $vars['url'] . "pg/groups/world/";

?>
<div id="elgg_horizontal_tabbed_nav">
<ul>
	<li <?php if($filter == "featured") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=featured"><?php echo elgg_echo('groups:featured'); ?></a></li>
	<li <?php if($filter == "pop") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=pop"><?php echo elgg_echo('groups:all'); ?></a></li>
	<li <?php if($filter == "support") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=support"><?php echo elgg_echo('groups:support'); ?></a></li>
	<li <?php if($filter == "language") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=language"><?php echo elgg_echo('groups:language'); ?></a></li>
	<li <?php if($filter == "developers") echo "class='selected'"; ?>><a href="<?php echo $url; ?>?filter=developers"><?php echo elgg_echo('groups:developers'); ?></a></li>
</ul>
</div>
<div class="group_count">
	<?php
		echo $num_groups . " " . elgg_echo("groups:count");
	?>
</div>