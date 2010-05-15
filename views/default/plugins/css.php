<?php
/**
 * Community plugin CSS
 *
 * @package Elgg Plugin Repository
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */
?>

#plugins_front_sidebar {
	float: right;
	width: 250px;
	padding: 10px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background: #eaf4fe;
}

#plugins_front_main {
	float: left;
	width: 670px;
}

#plugins_front_bottom {
	float: left;
	width: 100%;
	margin-top: 20px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background: #dedede;
}



#plugins_front_welcome {
	padding: 10px;
	margin: 0 0 15px 0;
	border: 1px solid silver;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background: url(<?php echo $vars['url']; ?>mod/community_plugins/graphics/plugins_back.gif) no-repeat right top;
}

#plugins_welcome_text {
	width: 340px;
	line-height: 1.6em;
}

#plugins_front_main h2 {
	color: #666666;
	font-size: 1.8em;
	margin-bottom: 20px;
}

#plugins_front_main h3 {
	color: #666666;
	font-size: 1.6em;
}

.upload_plugin {
	font-weight: bold;
	color: #ffffff;
	background:#4690D6;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	padding: 3px 7px 3px 7px;
	cursor: pointer;
}
.upload_plugin:hover {
	text-decoration: none;
	color: #ffffff;
	background: #0054A7;
}


#plugins_front_sidebar h2 {
	color: #0054a7;
}

#plugins_front_sidebar ul {
	margin: 0;
	padding: 0;
}

#plugins_front_sidebar ul li {
	padding: 1px 0;
}

.plugins_highlight {
	font-weight: bold;
}

#plugin_three_column {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	padding:0;
	background:#dedede;
}

.plugins_front_listing {
	float: left;
	width: 283px;
	padding: 8px;
	margin: 8px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	background: white;
}

.plugins_front_listing h2 {
	color: #0054A7;
}

.small_plugin_view {
	margin-top:5px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
}
.small_plugin_view p {
	margin:0;
}
.small_plugin_view img {
	float:left;
	margin:4px;
}
.odd{
	background:#efefef;
}
.even{
	background:white;
}

.small_plugin_view:hover {
	/* border:1px solid #ddd; */
	background: #cccccc;
}
#two_column_left_sidebar_maincontent .small_plugin_view {
	margin:5px 10px 5px 10px;
	background: white;
}

.plugins_search_box {
	padding: 10px;
	margin: 0 0 15px 0;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background: #4690D6;
	color: white;
}

#plugins_search_form .plugins_search_submit {
	margin: 0 0 0 15px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-color: #0054A7;
	background-color: #0054A7;
	font-size: 1.2em;
}

#plugins_search_form .plugins_search_submit:hover {
	border-color: white;
	background-color: white;
	color: #4690D6;
}

#plugins_search_form label {
	color: white;
	font-weight: normal;
	font-size: 100%;
	margin-left: 10px;
}

/*
.search_box input {
	margin:0 15px 0 0;
}
.search_box input.search_plugins {
	margin-left:15px;
	background-color:#0054A7;
	border-color:#0054A7;
	color:white;
	font-size: 1.2em;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
.search_box input.search_plugins:hover {
	background-color: white;
	border-color: white;
	color:#4690D6;
}
*/















#two_column_left_sidebar_boxes .sidebarBox .contentWrapper {
	margin:0 0 0 0;
}

.pluginHint {
	font-size: 85%;
	font-weight: normal;
	font-style: italic;
}

p.pluginsrepo_owner {
	margin:0;
	padding:0;
}
.pluginsrepo_owner_details {
	/* font-size: 90%; */
	margin:0;
	padding:0;
	line-height: 1.2em;
}
.pluginsrepo_owner_details small {
	color:#666666;
}
.pluginsrepo_owner .usericon {
	margin: 3px 5px 5px 0;
	float: left;
}

.pluginsrepo_download a {
	font: 18px/140% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#4690d6;
	border: 1px solid #4690d6;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	width: auto;
	height: 25px;
	padding: 2px 6px 2px 6px;
	margin:10px 0 10px 0;
	cursor: pointer;
}

.pluginsrepo_download a:hover {
	background: #0054a7;
	border: 1px solid #0054a7;
	text-decoration: none;
}

/* FILE REPRO WIDGET VIEW */
.pluginsrepo_widget_singleitem {
	margin:0 0 5px 0;
	padding:5px;
	min-height:60px;
	display:block;
	background:white;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
.pluginsrepo_widget_singleitem_more {
	margin:0;
	padding:5px;
	display:block;
	background:white;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
.pluginsrepo_listview_icon {
	float: left;
	margin-right: 10px;
}
.pluginsrepo_timestamp {
	color:#666666;
	margin:0;
}
.pluginsrepo_listview_desc {
	display:none;
	padding:0 10px 10px 0;
	line-height: 1.2em;
}
.pluginsrepo_listview_desc p {
	color:#333333;
}
.pluginsrepo_widget_content {
	margin-left: 70px;
}
.pluginsrepo_title {
	margin:0;
	padding:6px 5px 0 0;
	line-height: 1.2em;
	color:#666666;
	font-weight: bold;
}

.collapsable_box #pluginsrepo_widget_layout {
	margin:0 10px 0 10px;
	background: none;
}
#left_column #pluginsrepo_widget_layout {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background:white;
	margin:0 0 20px;
	padding:0 0 5px;
}
#left_column #pluginsrepo_widget_layout .pluginsrepo_widget_singleitem {
	border:2px solid #CCCCCC;
	background: white;
	padding:5px 0 5px 0;
	margin:0 10px 5px 10px;
}
/* widget gallery view */
.pluginsrepo_widget_galleryview {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background: white;
	margin:0 0 5px 0;
}
.pluginsrepo_widget_galleryview img {
	padding:0;
	border:1px solid white;
	margin:4px;
}
#pluginsrepo_widget_layout .filerepo_title {
	margin:0;
	padding:6px 5px 0 0;
	line-height: 1.2em;
	color:#666666;
	font-weight: bold;
}
#pluginsrepo_widget_layout .filerepo_timestamp {
	color:#666666;
	margin:0;
}

/* SINGLE ITEM VIEW */
.pluginsrepo_file {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background:white;
	margin:10px 10px 10px 10px;
}
.pluginsrepo_file .pluginsrepo_maincontent {
	padding:0 0 0 0;
}
#pluginsrepo_details {
	clear:both;
	padding:10px;
/*
	padding:10px;
	border:1px solid #ddd;
	margin:10px;
*/
}
#previous_versions p.warning {
	padding:4px;
	background:#efefef;
}
#recommend {
	float:right;
	width:auto;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	padding:3px 10px 3px 10px;
	text-align: right;
}

#recommend #num_recommend {
	background: url(<?php echo $vars['url']; ?>mod/community_plugins/graphics/recommend.png) no-repeat;
	width:50px;
	height:50px;
	margin:0 0 5px 0;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
}

#recommend #num_recommend p {
	font-size:1.4em;
	padding:2px;
}

#recommend #recommend_action {
	border:1px solid #efefef;
	padding:2px;
	font-size:80%;
}

#recommend #recommend_action p {
	padding:0;
	margin:0;
}

#download_action {
	border-bottom:1px solid #efefef;
	border-top:1px solid #efefef;
	padding:10px;
	clear:both;
}

#warning {
	background:url(<?php echo $vars['url']; ?>mod/community_plugins/graphics/warning.png)no-repeat;
	height:40px;
	width:40px;
	float:left;
	margin:0 4px 50px 0;
}

.pluginsrepo_file .pluginsrepo_icon {
	margin:10px 0 10px 0;
	position:absolute;
	width:70px;
}
.pluginsrepo_file .pluginsrepo_title {
	margin:0;
	padding:4px 4px 5px 10px;
	line-height: 1.2em;
}
.pluginsrepo_file .pluginsrepo_owner {
	padding:0 0 0 10px;
}
.pluginsrepo_file .pluginsrepo_description {
	margin:10px 0 0;
	padding:0 0 0 10px;
}
.pluginsrepo_download,
.pluginsrepo_controls {
	padding:0 0 1px 10px;
	margin:0;
}

.pluginsrepo_file p {
	padding:0 0 5px 0;
	margin:0;
}

.pluginsrepo_file .pluginsrepo_specialcontent img {
	padding:5px;
	margin:0 0 0 10px;
}

.pluginsrepo_tags {
	padding:0;/*  0 10px 10px; */
	margin:0;
}

/* file repro gallery items */
.search_gallery .pluginsrepo_controls {
	padding:0;
}
.search_gallery .pluginsrepo_title {
	font-weight: bold;
	line-height: 1.1em;
	margin:0 0 10px 0;
}

.pluginsrepo_gallery_item {
	margin:0;
	padding:0;
}
.pluginsrepo_gallery_item p {
	margin:0;
	padding:0;
}
.search_gallery .pluginsrepo_comments {
	font-size:90%;
}

.pluginsrepo_user_gallery_link {
	float:right;
	margin:5px 5px 5px 50px;
}
.pluginsrepo_user_gallery_link a {
	padding:2px 25px 5px 0;
	background: transparent url(<?php echo $vars['url']; ?>_graphics/icon_gallery.gif) no-repeat right top;
	display:block;
}
.pluginsrepo_user_gallery_link a:hover {
	background-position: right -40px;
}

.pluginsrepo_warning {
	margin:10px 0 20px 10px;
	border:1px solid #D3322A;
	background:#F7DAD8;
	color:#000000;
	padding:9px 10px 3px 10px;
	margin:5px 0 5px 0;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
}

.pluginsrepo_warning h3 {
	font-size:1.2em;
}

.pluginsrepo_warning p {
	font-size:12px / 100%;
}

.pluginsrepo_prev {
	margin:10px 0 20px 10px;
	color:#000000;
	background:#efefef;
	padding:3px 10px 3px 10px;
	margin:5px 0 5px 0;
	border:1px solid #ccc;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
}
.pluginsrepo_next p,
.pluginsrepo_prev p {
	margin:0;padding:0;
}
.pluginsrepo_versions h2 {
font-size:12px;
margin:0;
padding:0;
}


/* Custom plugin gallery page on community */

#plugins_gallery {
	margin:0 0 20px 0;
	padding:0;
}
#plugins_column {
	margin:0 20px 0 0;
	padding:0 10px 10px 10px;
	border:2px solid #ccc;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
#plugins_column #content_area_user_title h2 {
	display:none;
}
#plugins_gallery .pagination {
	margin:5px 0 5px 0;
	padding-left:0;
	display:table;
}
#plugins_gallery .search_listing .pluginName a {
	font-weight: bold;
}
#rhs_column {
	width:250px;
	float:right;
}

#lhs_column {
	width:680px;
}


#plugins_column .plugin_list_filtermenu {
	margin:10px 0 10px 0;
}
#plugins_column .plugin_list_filtermenu span.select {
	position: absolute;
	width: 158px;
	height: 21px;
	padding: 0 24px 0 8px;
	color: #fff;
	font: 12px/21px arial,sans-serif;
	font-weight: bold;
	background: url(<?php echo $vars['url']; ?>mod/community_plugins/graphics/select.gif) no-repeat;
	overflow: hidden;
	text-align: left;
}
.categories_box {
	background:#EAF4FE;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	padding:10px;
	margin:0 0 20px 0;
}
.search_box {
	background:#4690D6;/* #FDFFC3; */
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	padding:10px;
	margin:0 0 15px 0;
}
.search_box input {
	margin:0 15px 0 0;
}
.search_box input.search_plugins {
	margin-left:15px;
	background-color:#0054A7;
	border-color:#0054A7;
	color:white;
	font-size: 1.2em;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
}
.search_box input.search_plugins:hover {
	background-color: white;
	border-color: white;
	color:#4690D6;
}
.search_box #searchform {
	color:white;
}
.categories_box h2,
.featured_plugins h3 {
	color:#0054A7;
}
.categories_box ul {
	margin:0;
	padding:0;
}
.categories_box ul li {
	list-style: none;
	padding:1px 0 1px 0;
}
.featured_plugins {
	background:#efefef;
	border:2px solid #efefef;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	padding:5px;
	margin:10px 0 20px 0;
}
.featured_plugins a.feature_name {
	font-size: 1.2em;
	font-weight: bold;
}
.featured_plugins .featured_thumbnail {
	float:right;
	margin:0 0 10px 10px;
}

/* ***************************************
	SEARCH LISTINGS
*************************************** */
#plugins_column .search_listing {
	margin:0 0 5px 0;
	/* background: #eeeeee; */
	border:2px solid #CCCCCC;
}
#custom_index .search_listing {
	background: white;
}
#group_pages_widget .search_listing {
	background: white;
}
.groups .search_listing {
	background: white;
}
.search_listing {
	margin-bottom: 5px;
}

.search_listing_icon {
	float:left;
}
.search_listing_icon img {
	width: 40px;
}
.search_listing_icon .avatar_menu_button img {
	width: 15px;
}

.search_listing_info {
	margin-left: 50px;
	min-height: 40px;
}
/* IE 6 fix */
* html .search_listing_info {
	height:40px !important;
}
.search_listing_info p {
	margin:0 0 3px 0;
	line-height:1.2em;
}
.search_listing_info p.owner_timestamp {
	margin:0;
	padding:0;
	color:#666666;
	font-size: 90%;
}
#community_dash .search_listing_info p.description,
.search_listing_info p.description {
	line-height:1.2em;
	color:#666666;
	font-size: 90%;
	padding:0;
	padding-right:70px;
}
table.search_gallery {
	border-spacing: 5px;
	margin:0 0 20px 0;
	background: #f5f5f5;
}
.search_gallery td {
	padding: 5px;
}

.search_gallery_item {
	border:1px dotted silver;
	background-color: white;
}
.search_gallery_item:hover {
	border:1px dotted black;
}

.search_gallery_item .search_listing {
	background: none;
	text-align: center;
}

.search_gallery_item .search_listing_header {
	text-align: center;
}

.search_gallery_item .search_listing_icon {
	position: relative;
	text-align: center;
}

.search_gallery_item .search_listing_info {
	margin: 5px;
}

.search_gallery_item .search_listing_info p {
	margin: 5px;
	margin-bottom: 10px;
}

.search_gallery_item .search_listing {
	background: none;
	text-align: center;
}

.search_gallery_item .search_listing_icon {
	position: absolute;
	margin-bottom: 20px;
}

.search_gallery_item .search_listing_info {
	margin: 5px;
}

.search_gallery_item .search_listing_info p {
	margin: 5px;
	margin-bottom: 10px;
}




/* download number visible to admins only */
span.downloadsnumber {
	font-weight: bold;
	font-size:1.2em;
	float:right;
	color: #999999;
	padding-right:3px;
}

.pluginsrepo_title_owner_wrapper span.downloadsnumber {
	font-weight: bold;
	margin-left:30px;
	color:#999999;
	float:none;
}



.groups .pagination {
	margin:5px 0 5px 0;
	padding-left:0;
}

.river_object_plugins_create {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_plugin.gif) no-repeat left -1px;
}
.river_object_plugins_update {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_plugin.gif) no-repeat left -1px;
}
.river_object_plugins_comment {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}
.river_object_plugin_project_create {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_plugin.gif) no-repeat left -1px;
}
.river_object_plugin_project_update {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_plugin.gif) no-repeat left -1px;
}
.river_object_plugin_project_comment {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}
.river_object_plugin_file_create {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_plugin.gif) no-repeat left -1px;
}
.river_object_plugin_file_update {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_plugin.gif) no-repeat left -1px;
}
.river_object_plugin_file_comment {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}

.river_object_poll_create {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_plugin.gif) no-repeat left -1px;
}
.river_object_poll_comment {
	background: url(<?php echo $vars['url']; ?>_graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}

.welcomemessage .sitemessage {
	padding:3px 5px 3px 5px;
	background:#EBF5FF;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
}


.index_box .index_members {
	margin:2pt 4px 2px 0 !important;
}


#index_welcome h2 {
	color:#4690D6;
}

#dash_welcome h1,
#dash_groups h1 {
	color:#666666;
	font-family: Arial, sans-serif;
	font-weight: normal;
	font-size: 2.2em;
}
#dash_welcome h1 span,
#dash_groups h1 span {
	font-weight: bold;
}
#dash_groups p,
#dash_groups li {
	font-size: 1.2em;
	line-height: 1.3em;
	color:#4690D6;
}
#dash_welcome p.strapline,
#dash_groups p.strapline {
	font-size: 1.2em;
	line-height: 1.3em;
	color:#666666;
}

#plugins_gallery #elgg_horizontal_tabbed_nav {
	border-bottom: none;
	margin:0;
}

#right_column #group_pages_widget .pagination,
#left_column #pluginsrepo_widget_singleitem .pagination {
	border:2px solid #CCCCCC;
}

#left_column #pluginsrepo_widget_layout .pluginsrepo_widget_singleitem_more {
	border:2px solid #CCCCCC;
	margin: 0 10px 0 10px;
}


/*****************
New edits
*****************/

#plugin_stats {
/*
	float:right;
	width:250px;
	margin:0;
*/
}

#plugins_welcome {
/*
	padding-left:50px;
	background:url(<?php echo $vars['url']; ?>mod/community_plugins/graphics/plugins.gif) left no-repeat;
*/
}

#spotlight_box {
	border:1px solid silver;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	padding:10px;
	margin:0 0 15px 0;
	height:240px;
	background:url(<?php echo $vars['url']; ?>mod/community_plugins/graphics/plugins_back.gif) no-repeat right top;
	position:relative;
}

#spotlight_advert_box {
	margin:0;
	padding:0;
	text-align:left;
	/* background:#555; */
	/* border:1px solid #555; */
/*
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
*/
}
#user_actions {
	/* float:right; */
	text-align: right;
	position: absolute;
	bottom:20px;
	right:20px;
}
#user_actions .upload_plugin a {
	margin:0 0 0 0;
	font-weight: bold;
	color: #ffffff;
	background:#4690D6;
	border: 1px solid #4690D6;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	width: auto;
	height: auto;
	padding: 2px 6px 2px 6px;
	cursor: pointer;
}
#user_actions .upload_plugin a:hover {
	text-decoration: none;
	background: #0054A7;
	border: 1px solid #0054A7;
}

#spotlight_box h1,
#spotlight_box h2 {
	color:#666666;
}
#spotlight_box p {

	width:355px;
	line-height:1.6em;
	/* padding:4px; */

}
#spotlight_box .stats p {
	color:#666666;
	font-size: 1.2em;
}
#spotlight_box .stats p span {
	font-weight: bold;
}


.plugin_three_column_actual {
	width:283px;
	/* border:2px solid #EAF4FE; */
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	padding:8px;
	float:left;
	margin:8px;
	background:white;
}


.plugin_three_column_actual h2 {
	color:#0054A7;
}


#search_results {
	margin:0 0 30px 0;
}
#search_results .small_plugin_view {
	background: #dedede;
	padding:5px;
}


/* individual plugin page */
select.choose_plugin {
	width:172px;
}
#two_column_left_sidebar_boxes .sidebarBox a.submit_button {
	margin:6px 0 0 0;
	display:table;
	height:auto;
	line-height: inherit;
}
#two_column_left_sidebar_boxes .sidebarBox a.submit_button:hover {
	color:white;
}
.pluginsrepo_changelog {
	padding:10px;
	margin:10px;
	background-color: #efefef;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
}



/**
 * jQuery lightBox plugin
 * This jQuery plugin was inspired and based on Lightbox 2 by Lokesh Dhakar (http://www.huddletogether.com/projects/lightbox2/)
 * and adapted to me for use like a plugin from jQuery.
 * @name jquery-lightbox-0.5.css
 * @author Leandro Vieira Pinho - http://leandrovieira.com
 * @version 0.5
 * @date April 11, 2008
 * @category jQuery plugin
 * @copyright (c) 2008 Leandro Vieira Pinho (leandrovieira.com)
 * @license CC Attribution-No Derivative Works 2.5 Brazil - http://creativecommons.org/licenses/by-nd/2.5/br/deed.en_US
 * @example Visit http://leandrovieira.com/projects/jquery/lightbox/ for more informations about this jQuery plugin
 */
#jquery-overlay {
	position: absolute;
	top: 0;
	left: 0;
	z-index: 90;
	width: 100%;
	height: 500px;
}
#jquery-lightbox {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	z-index: 100;
	text-align: center;
	line-height: 0;
}
#jquery-lightbox a img { border: none; }
#lightbox-container-image-box {
	position: relative;
	background-color: #fff;
	width: 250px;
	height: 250px;
	margin: 0 auto;
}
#lightbox-container-image { padding: 10px; }
#lightbox-loading {
	position: absolute;
	top: 40%;
	left: 0%;
	height: 25%;
	width: 100%;
	text-align: center;
	line-height: 0;
}
#lightbox-nav {
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	width: 100%;
	z-index: 10;
}
#lightbox-container-image-box > #lightbox-nav { left: 0; }
#lightbox-nav a { outline: none;}
#lightbox-nav-btnPrev, #lightbox-nav-btnNext {
	width: 49%;
	height: 100%;
	zoom: 1;
	display: block;
}
#lightbox-nav-btnPrev {
	left: 0;
	float: left;
}
#lightbox-nav-btnNext {
	right: 0;
	float: right;
}
#lightbox-container-image-data-box {
	font: 10px Verdana, Helvetica, sans-serif;
	background-color: #fff;
	margin: 0 auto;
	line-height: 1.4em;
	overflow: auto;
	width: 100%;
	padding: 0 10px 0;
}
#lightbox-container-image-data {
	padding: 0 10px;
	color: #666;
}
#lightbox-container-image-data #lightbox-image-details {
	width: 70%;
	float: left;
	text-align: left;
}
#lightbox-image-details-caption { font-weight: bold; }
#lightbox-image-details-currentNumber {
	display: block;
	clear: left;
	padding-bottom: 1.0em;
}
#lightbox-secNav-btnClose {
	width: 66px;
	float: right;
	padding-bottom: 0.7em;
}

.sidebarBox h3 {
	margin:0;
	padding:0;
}