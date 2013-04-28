<?php 
/**
 * View providing a sort toolbar for sorting a list of entities
 * 
 * @uses $vars['sort_fields'] Current sort property
 * @uses $vars['sort'] Current sort property
 * @uses $vars['direction'] Current sort direction
 */
?>
<div class="sort-block">
<span class="sort-info">
    <?php echo elgg_echo('plugins:sort:info') ?>
</span>
<?php

    global $CONFIG;

    $sort_fields = $vars['sort_fields'];
    $sort = $vars['sort'];
    $direction = $vars['direction'];

    foreach ($sort_fields as $sort_field) {
        $sort_link_head = '';
        $sort_link_tail = '';
        $sort_arrow = '';

        if (($sort_field == $sort) && ($direction == 'desc')) {
            $sort_dir = 'asc';
        } else {
            $sort_dir = 'desc';
        }
        $sort_link_URL = elgg_http_add_url_query_elements($vars['baseurl'], array('sort' => $sort_field, 'direction' => $sort_dir));
        if ($sort_field == $sort) {
            $class = "sort sort-active";
        } else {
            $class = 'sort';
        }
        $sort_link_head = '<a href="' . $sort_link_URL . '" class="'. $class .'">';
        $sort_link_tail = '</a>';

        if ($sort_field == $sort) {
            if ($direction == 'asc') {
                $sort_arrow = elgg_view('output/img', array(
					'src' => elgg_get_site_url() . 'mod/community_plugins/graphics/icons/up_arrow.png',
					'alt' => elgg_echo('Ascending'),
					'title' => elgg_echo('Ascending')
				));
            } else {
                $sort_arrow = elgg_view('output/img', array(
					'src' => elgg_get_site_url() . 'mod/community_plugins/graphics/icons/down_arrow.png',
					'alt' => elgg_echo('Descending'),
					'title' => elgg_echo('Descending')
				));
            }
        }
?>
    <span class="sort-item">
        <?php echo $sort_arrow ?>
        <?php echo $sort_link_head; ?>
        <?php echo elgg_echo("plugins:sort:{$sort_field}") ?>
        <?php echo $sort_link_tail; ?>
    </span>

<?php
    }
?>
</div>
<div class="clearfloat"></div>
