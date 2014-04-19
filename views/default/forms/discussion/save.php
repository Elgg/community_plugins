<?php
/**
 * Discussion topic add/edit form body
 *
 */

$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$status = elgg_extract('status', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);

?>
<div>
    <label><?php echo elgg_echo('forms:discussion/save:container_guid:label'); ?><br />
    <span class="elgg-subtext">
        <?php echo elgg_echo('forms:discussion/save:container_guid:hint'); ?>
    </span><br />
    <?php 
        echo elgg_view('input/autocomplete', array(
            'name' => 'container_guid',
            'value' => $container_guid,
            'required' => true,
            'pattern' => '[0-9]+',
            'autofocus' => true,
            'match_on' => 'groups',
        ));
    ?>
    </label>
</div>
<div>
	<label><?php echo elgg_echo('forms:discussion/save:title:label'); ?><br />
	<?php
	    echo elgg_view('input/text', array(
    	    'name' => 'title',
    	    'value' => $title,
    	    'required' => true,
	    )); 
	?>
	</label>
</div>
<div>
	<label><?php echo elgg_echo('forms:discussion/save:description:label'); ?>
	<?php 
	    echo elgg_view('input/longtext', array(
	        'name' => 'description',
	        'value' => $desc,
	    ));
	?>
    </label>
</div>
<div>
    <label><?php echo elgg_echo("groups:topicstatus"); ?><br />
	<?php
		echo elgg_view('input/select', array(
			'name' => 'status',
			'value' => $status,
			'options_values' => array(
				'open' => elgg_echo('status:open'),
				'closed' => elgg_echo('status:closed'),
			),
		));
	?></label>
</div>
<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => ACCESS_PUBLIC));
echo elgg_view('input/hidden', array('name' => 'topic_guid', 'value' => $guid));

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

?>
</div>
