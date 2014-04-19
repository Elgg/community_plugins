<?php
elgg_gatekeeper();

$title = elgg_echo('groups:addtopic');

elgg_load_library('elgg:discussion');

$body_vars = discussion_prepare_form_vars();
$body_vars['container_guid'] = '';

$content = elgg_view_form('discussion/save', array(), $body_vars);

$body = elgg_view_layout('one_column', array(
    'title' => $title,
    'content' => $content,
));

echo elgg_view_page($title, $body);
