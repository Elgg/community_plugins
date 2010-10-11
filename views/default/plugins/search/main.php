<?php

$category = get_input('category', 'all');
$category_label = $CONFIG->plugincats[$category];

$query = stripslashes(get_input('q', ''));


if ($query != '') {
	$title = sprintf(elgg_echo('plugins:search:title'), $query, $category_label);
} else {
	$title = sprintf(elgg_echo('plugins:category:title'), $category_label);
	if ($category == 'all') {
		$title = sprintf(elgg_echo('plugins:category:title'), elgg_echo('plugins:cat:all'));
	}
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
