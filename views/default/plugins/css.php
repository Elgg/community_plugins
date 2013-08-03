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


.plugin-screenshots > li {
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


/***************** Entity listing ********************/

span.info_item {
	margin-left: 15px;
	float: right;
}

span.info_item img {
	padding-right: 2px;
	vertical-align: middle;
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
