<?php
/**
 * Category list header
 */

$category = get_input('category', 'all');
$categories = elgg_get_config('plugincats');
$category_label = $categories[$category];

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

<div id="search_results">
<?php
if ($vars['area1']) {
	echo $vars['area1'];
}
?>
</div>
