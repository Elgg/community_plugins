<?php
 
    // Latest forum discussion for the group home page

    //check to make sure this group forum has been activated
    if($vars['entity']->files_enable == 'yes'){

?>

<script type="text/javascript">
$(document).ready(function () {

$('a.show_file_desc').click(function () {
	$(this.parentNode).children("[class=filerepo_listview_desc]").slideToggle("fast");
	return false;
});

}); /* end document ready function */
</script>

<?php

	//get the user's files
	$files = get_user_objects($vars['entity']->guid, "plugins", 6, 0);

	if($files){

?>



<div id="pluginsrepo_widget_layout"> 
<h2><?php echo elgg_echo("plugins:group"); ?></h2>

<?php

	//the number of files to display
	$number = (int) $vars['entity']->num_display;
	if (!$number)
		$number = 6;
	
	//if there are some files, go get them
	if ($files) {
    	       	    
            //display in list mode
            foreach($files as $f){
            	
                $mime = $f->mimetype;
                echo "<div class=\"pluginsrepo_widget_singleitem\">";
            	echo "<div class=\"pluginsrepo_listview_icon\"><a href=\"{$f->getURL()}\">" . elgg_view("plugins/icon", array("mimetype" => $mime, 'thumbnail' => $f->thumbnail, 'plugins_guid' => $f->guid)) . "</a></div>";
            	echo "<div class=\"pluginsrepo_widget_content\">";
            	echo "<div class=\"pluginsrepo_listview_title\"><p class=\"pluginsrepo_title\">" . $f->title . "</p></div>";
            	echo "<div class=\"pluginsrepo_listview_date\"><p class=\"pluginsrepo_timestamp\"><small>" . friendly_time($f->time_created) . "</small></p></div>";
		        $description = $f->description;
		        if (!empty($description)) echo "<a href=\"javascript:void(0);\" class=\"show_file_desc\">". elgg_echo('more') ."</a><br /><div class=\"pluginsrepo_listview_desc\">" . $description . "</div>";
		        echo "</div><div class=\"clearfloat\"></div></div>";
            				
        	}
        	
        	
        //get a link to the users files
        $users_file_url = $vars['url'] . "pg/plugins/" . page_owner_entity()->username;
        	
        echo "<div class='pluginsrepo_widget_singleitem_more'><a href=\"{$users_file_url}\">" . elgg_echo('plugins:more') . "</a></div>";
       
	} else {
		
		echo "<div class='pluginsrepo_widget_singleitem_more'>" . elgg_echo("plugins:none") . "</div>";
		
	}

?>

</div>

<?php
	}
	}//end of enable check statement
?>