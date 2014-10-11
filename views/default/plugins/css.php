<?php
/**
 * Community plugin CSS
 *
 * @package Elgg Plugin Repository
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */
?>
/* <style> /**/

#plugins_front_welcome {
	line-height: 1.6em;
	padding: 20px;
	margin: 20px 0;
	border: 1px solid silver;
	background: url(<?php echo elgg_get_site_url(); ?>mod/community_plugins/graphics/plugins_back.gif) no-repeat right top;
	
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}

#plugins_welcome_text {
	width: 340px;
	padding: 20px 0;
}

.plugins_download_total {
	color:#666666;
	font-size: 1.2em;
}

.plugins_download_total p span {
	font-weight: bold;
}
.elgg-community-plugins {
	position: relative;
	float: left;
	margin-left: -15px;
	margin-right: -15px;
}
.elgg-community-plugins .elgg-module {
	margin: 0 15px 20px;
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


.elgg-plugin-screenshots > li {
	margin-left: 2px;
}

.plugin_stats {
margin:0;
padding:0;
}

.plugin_stats li {
 margin: 4px 0;
}

/* download number visible to admins only */
span.downloadsnumber {
	font-weight: bold;
	font-size:1.2em;
	float:right;
	color: #999999;
	padding-right:3px;
}

.elgg-sidebar .choose_plugin {
	width: 100%; 
}

/***************** Entity listing ********************/

span.info_item {
	margin-left: 15px;
	float: right;
}

span.info_item img {
	padding-right: 2px;
	vertical-align: middle;
}


/***************** Filters ********************/

div#plugin_filters select.input-select {
    width: 222px;
}

div#plugin_filters input.input-text {
    width: 210px;
}

div#plugin_filters div.filter_fields {
    padding-bottom: 10px;
}

div#plugin_filters div.filter_label {
    color: #555;
    margin-bottom: 5px;
    font-weight: normal;
}

div#plugin_filters div.filter_label.ui-state-active {
    font-weight: bold;
}


div#plugin_filters button.clear_search {
    background: none repeat scroll 0 0 #4690d6;
    border: medium none;
    border-radius: 5px 5px 5px 5px;
    color: white;
    cursor: pointer;
    font: bold 12px/100% Arial,Helvetica,sans-serif;
    height: 25px;
    margin: 10px 0;
    padding: 2px 6px;
    width: auto;
    float: right;
}

div#plugin_filters button.clear_search:hover {
    background: none repeat scroll 0 0 #0054a7;
    color: white;
}


/***************** Admin page ********************/

form#plugins_search_settings p label {
	font-size: 1em;
	font-weight: normal;
	padding-left: 15px;
}

form#plugins_search_settings p.sub-option {
	padding-left: 15px;
	font-style: italic;
}
/* ***************************************
	Responsive
*************************************** */
@media (max-width: 1030px) {
	#plugins_front_welcome {
		background: none;
	}
	#plugins_welcome_text {
		width: 100%;
	}
}
@media (max-width: 820px) {
	.elgg-community-plugins {
		margin: 20px 0 0;		
	}
}
