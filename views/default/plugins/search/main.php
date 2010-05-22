<?php

$category = get_input('category', 'all');

$query = stripslashes(get_input('q', ''));


if ($query != '') {
	$title = sprintf(elgg_echo('plugins:search:title'), $query, $category);
} else {
	$title = sprintf(elgg_echo('plugins:category:title'), $category);
}

?>
<div id="plugins_welcome">
	<h2><?php echo $title; ?></h2>
</div>

<?php
echo elgg_view('plugins/search_box', array('category' => $category));
?>

<div id="search_results">
<?php
if ($vars['area1']) {
	echo $vars['area1'];
}
?>
</div>
