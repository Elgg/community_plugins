<?php
	/**
	 * Sort out plugin search
	 **/
	 
	$results = $vars['entities'];
	if($results){
		foreach($results as $result){
			//get the entity
			$plugin = get_entity($result->guid);
			echo elgg_view_entity($plugin);
		}
	}else{
		echo "<p style=\"margin:20px;\">No plugins matched your search.</p>";
	}
?>