<?php
/**
 * Sidebar for search
 */

$url = $vars['url'] . 'pg/plugins/all';
?>
<div class="plugins_sidebar_box">
	<a class="plugins_highlight" href="<?php echo $url; ?>">Plugins home</a>
</div>
<?php

echo elgg_view('plugins/categories');