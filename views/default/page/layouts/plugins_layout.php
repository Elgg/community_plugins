<?php
/**
 * Elgg plugins layout used on repository home page
 *
 * @uses $vars Passed to the 'one_sidebar' layout.
 * @uses $vars['bottom'] Optional footer
 */

echo elgg_view_layout('one_sidebar', $vars);

if (isset($vars['bottom'])) {
	echo $vars['bottom'];
}
