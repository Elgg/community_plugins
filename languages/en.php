<?php

return array(
	'admin:groups' => "Groups",
	'admin:groups:main' => "Administration",

	'cg:menu:move' => "Move",
	'cg:menu:remove_ad' => "Remove ad",
	'cg:menu:offtopic' => "Off-topic",

	'cg:forum:controls' => "Admin controls",
	'cg:forum:move:instruct' => "Move post to the group",
	'cg:forum:removead' => "Remove ad",
	'cg:form:ad:warning' => "This comment was removed by a moderator because it contained advertising.",

	'cg:forum:offtopic' => "Off-topic",
	'cg:forum:offtopic:title' => "Move off-topic post to its own topic",
	'cg:forum:offtopic:text' => "Post text",
	'cg:forum:offtopic:success' => "Successfully move to new topic",
	'cg:form:offtopic:warning' => "Moderator: this comment was off-topic. It was moved to its own topic.",

	'cg:tabs:categorize' => 'Categorize',
	'cg:tabs:combine' => 'Combine groups',
	'cg:tabs:change_owner' => 'Change owner',
	'cg:tabs:delete' => 'Delete group',
	'cg:tabs:blog' => 'Blog integration',

	'cg:admin:delete:instruct' => 'Delete the group',
	'cg:admin:combine:instruct' => 'Move all content and members from one group
									into another. The first group is also deleted.',
	'cg:admin:combine:from' => 'From this group',
	'cg:admin:combine:to' => 'To this group',
	'cg:admin:blog:instruct' => 'Blog posts from blog.elgg.org can be posted to the group forums',
	'cg:admin:blogurl' => 'URL of the web services end point',
	'cg:admin:bloggroup' => 'Group to post the blog entries',

	'cg:admin:change_owner:instruct' => 'Change the owner of a group.',
	'cg:admin:change_owner:user' => 'New owner',
	'cg:admin:change_owner:nogroup' => 'Unable to load the group.',
	'cg:admin:change_owner:nouser' => 'Unable to load the user.',
	'cg:admin:change_owner:success' => 'User %s is now the owner of group %s.',
	'cg:admin:change_owner:icon_error' => 'User %s is now the owner of group %s but there was a problem transferring the group icons',

	'groups:popular' => 'All groups',
	'groups:support' => 'Support',
	'groups:language' => 'Language',
	'groups:developers' => 'Developers',
	'groups:plugins' => 'Plugins',

	'groups:discussion' => 'Group forum discussion',
	'groups:discussion:latest' => 'Latest discussion',
	'groups:discussion:mygroups' => 'Discussion in my groups',
	'groups:discussion:mine' => 'My discussion',

	'cg:forum:move:success' => "Successfully moved the forum post",
	'cg:forum:move:error' => "Unable to move the forum post",
	'cg:forum:removead:success' => "Issued advertising warning",
	'cg:forum:removead:error' => "Failed to issue an advertising warning",
	'cg:groups:combine:success' => "Successfully combined the groups %s and %s",
	'cg:groups:combine:same' => "The groups are the same",
	'cg:groups:combine:nogroup' => "Unable to load one of the groups",
	'cg:groups:categorize:success' => "Group categories have been added",
	
	'cg:groups:join:success' => "You are now a member of the group: %s",
	'cg:groups:join:failure' => "We couldn't join you to the group: %s. Membership is probably invite-only.",

	'forms:discussion/save:container_guid:label' => 'Pick a group',
	'forms:discussion/save:container_guid:hint' => 'If you are not already a member of the group, we will attempt to add you',
	'forms:discussion/save:title:label' => 'What would you like to discuss?',
	'forms:discussion/save:description:label' => 'Provide as many details as possible',
);
