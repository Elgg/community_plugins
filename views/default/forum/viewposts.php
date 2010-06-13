<div id="topic_posts"><!-- open the topic_posts div -->
	<div id="pages_breadcrumbs">
		<b><a href="<?php echo $vars['url']; ?>pg/groups/forum/<?php echo $vars['entity']->container_guid; ?>/"><?php echo elgg_echo("groups:forum"); ?></a></b> >
		<?php echo $vars['entity']->title; ?>
	</div>

<?php
$comment_limit = 50;

//display follow up comments
$count = $vars['entity']->countAnnotations('group_topic_post');
$offset = (int) get_input('offset', 0);

$baseurl = $vars['url'] . "mod/groups/topicposts.php?topic={$vars['entity']->guid}&group_guid={$vars['entity']->container_guid}";
$pagination = elgg_view('navigation/pagination', array(
				'limit' => $comment_limit,
				'offset' => $offset,
				'baseurl' => $baseurl,
				'count' => $count,
				));

echo $pagination;

?>
    <!-- grab the topic title -->
	<div id="content_area_group_title"><h2><?php echo $vars['entity']->title; ?></h2></div>
<?php

foreach ($vars['entity']->getAnnotations('group_topic_post', $comment_limit, $offset, "asc") as $post) {
	echo elgg_view("forum/topicposts", array('entity' => $post));
}

echo $pagination;

// check to find out the status of the topic and act
if ($vars['entity']->status != "closed" && page_owner_entity()->isMember($vars['user'])) {

	//display the add comment form, this will appear after all the existing comments
	echo elgg_view("forms/forums/addpost", array('entity' => $vars['entity']));

} elseif ($vars['entity']->status == "closed") {

	//this topic has been closed by the owner
	echo "<h2>" . elgg_echo("groups:topicisclosed") . "</h2>";
	echo "<p>" . elgg_echo("groups:topiccloseddesc") . "</p>";

} else {

}

?>
</div>