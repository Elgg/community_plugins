<?php
/**
 * Community plugin CSS
 *
 * @package Elgg Plugin Repository
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */
?>

#plugins_front_welcome {
	padding: 10px;
	margin: 0 0 15px 0;
	min-height: 250px;
	border: 1px solid silver;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	background: url(<?php echo elgg_get_site_url(); ?>mod/community_plugins/graphics/plugins_back.gif) no-repeat right top;
}

#plugins_welcome_text {
	width: 340px;
	line-height: 1.6em;
}

.plugins_download_total {
	color:#666666;
	font-size: 1.2em;
}

.plugins_download_total p span {
	font-weight: bold;
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
