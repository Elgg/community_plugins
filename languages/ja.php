<?php
/**
 * Elgg community plugin repository language pack
 */

return array(
	/**
	 * Administration area
	 */

	'admin:community_plugins' => 'プラグイン・リポジトリ',
	'admin:community_plugins:statistics' => '統計情報',
	'admin:community_plugins:upgrade' => 'アップグレード',
	'admin:community_plugins:utilities' => 'ユーティリティ',
	'admin:settings:community_plugins' => 'プラグイン・リポジトリ',
	'plugins:admin:trends:title' => 'ダウンロードされたプラグインの傾向',
	'plugins:admin:trends:help' => "過去30日のダウンロードを表示しています。ある特定のプラグインのダウンロードについてご覧になりたければ、プラグイン・プロジェクトのGUIDを入力してください。",
	'plugins:admin:trends:single' => "%s の統計",
	'plugins:admin:trends:all' => "全てのプラグインの統計",
	'plugins:admin:upgrade:required' => "このプラグインはアップグレードが必要です",
	'plugins:admin:upgrade:ok' => "アップグレードは必要ありません",
	'plugins:admin:utilities:combine' => 'プラグイン・プロジェクトを統合する',
	'plugins:admin:combine:old_guid' => 'GUID of plugin project that is be replaced in the combination',
	'plugins:admin:combine:new_guid' => 'GUID of plugin project that remains in the combination',
	'plugins:admin:normalize:help' => 'Remove inflated download counts for the currently graphed plugin',
	'plugins:admin:transfer:title' => "Transfer ownership of the plugin to another user.",
	'plugins:admin:transfer:help' => 'Begin typing the name of the user you wish to tranfer the plugin to and select them from the list.
	  Select only one user, if more than one is selected, only the first user selected will receive ownership.',
	'plugins:admin:contributors:title' => "List users as contributors to this plugin",
	'plugins:admin:contributors:help' => "Adding users as contributors <b>does not</b> give them any special privileges with regard to the plugin page, it does however list them as contributing members.
		It is a way of recognizing community members for their collaborative work of reporting bugs, and submitting patches for bugfixes and enhancements.
		Begin typing the name of the user who has contributed to the plugin.  You can select as many users as necessary.",


	/**
	 *	Object views
	 */
	'plugins:uploadtime' => "Uploaded %s (%s)",
	'plugins:updatedtime' => "Updated %s (%s)",
	'plugins:release:version_warning' => 'Warning: The author recommends using a different release of this plugin! Do you still want to download this release?',
	'plugins:download:version' => "Download %s",
	'plugins:project:title:version' => "%s for Elgg %s",
	'plugins:author:byline' => "by %s",
	'plugins:last:updated' => "Last updated %s",

	'plugins:project:outdated_warning' => "<strong>Warning:</strong> This plugin has't been updated in over %s years. It may no longer be maintained.",
	'plugins:project:help' => "What <i>you</i> can do to help:",

	'plugins:project:pull_request' => 'pull request',
	'plugins:project:repo' => 'plugin code',
	'plugins:project:collaborate' => "Submit a %s to update the %s", // Submit a <pull request> to update the <plugin code>

	'plugins:project:request' => 'become the new maintainer',
	'plugins:project:request_ownership' => "Request to %s of the plugin",
	'plugins:latest:releases' => "Latest Releases",
	'plugins:releases:all' => "All releases",
	'plugins:recommended:releases' => "Recommended Releases",
	'plugins:releases:show:recent' => 'Show recent releases',
	'plugins:releases:show:all' => "Show all releases",
	'plugins:releases:show:recommended' => "Show recommended releases",
	'plugin:release:version:unknown' => "?",

	/**
	 * Menu items and titles
	 */

	'plugins' => "プラグイン管理",
	'pluginss' => "プラグイン管理",

	'plugins:new' => "New plugin",

	'plugins:types:' => "plugins, themes and language packs",
	'plugins:types:plugin' => "plugins",
	'plugins:types:theme' => "themes",
	'plugins:types:languagepack' => "language packs",

	'plugins:yours' => "Your %s",
	'plugins:user' => "%s's %s",

	'plugins:admin' => "Plugin repository administration",
	'plugins:admin:menu' => "Plugin Repo Admin",

	'plugins:yours:friends' => "Your friends' plugins, themes and language packs",
	'plugins:friends' => "%s's friends' plugins, themes and language packs",
	'plugins:all' => "All site plugins, themes and language packs",
	'plugins:category:title' => "Plugins for category: %s",
	'plugins:search:title' => "Plugin search for \"%s\" in category: %s",


	'plugins:cat:all' => '全部',

	'plugins:listing:newest' => '最新',
	'plugins:listing:popular' => 'Most downloads',
	'plugins:listing:dugg' => 'Most recommended',


	'plugins:upload:new' => "Upload a new plugin",


	'plugins:search:instruct' => 'search for plugins',
	'plugins:search:choose' => 'choose a category',


	'plugins:front:welcome' => "Welcome to Elgg's plugin directory",
	'plugins:front:intro:title' => "What are plugins?",
	'plugins:front:intro:text' => "Plugins extend your Elgg site by adding additional functionality, languages and themes. They are contributed by members of the Elgg community.

		To get started you could browse the available plugins, search for a specific one, upload one of your own, or rate & comment on others.",




	'plugins:more' => "more plugins, themes and language packs",
	'plugins:list' => "リスト表示",
	'plugins:group' => "Group plugins, themes and language packs",
	'plugins:gallery' => "ギャラリー表示",
	'plugins:gallery_list' => "ギャラリー表示 or リスト表示",
	'plugins:num_files' => "Number of plugins, themes and language packs to display",
	'plugins:yes' => 'はい',
	'plugins:no' => 'いいえ',
	'plugins:num_plugins and themes' => "Number of plugins, themes and language packs to display",

	'plugins:new:project' => "Upload a new plugin",
	'plugins:new:release' => "Upload new release",

	'plugins:edit' => "編集",
	'plugins:edit:project' => "Edit project details",
	'plugins:edit:release' => "Edit plugin release",
	'plugins:contributors:add' => "Add contributors",
	'plugins:delete:project' => "Delete Project",
	'plugins:requests:ownership' => "Pending ownership requests",
	'plugins:transfer:ownership' => "Transfer Ownership",
	'plugins:author:homepage' => "Author homepage",
	'plugins:author:recommended' => "Author Recommended",
	'plugins:project:page:view' => "Project Page",

	'plugins:elggversion' => "Version(s) of Elgg this plugin has been tested on",
	'plugins:elgg_version' => "Elgg version",
	'plugins:version' => "Plugin version",
	'plugins:updated' => "更新",
	'plugins:repo' => "Code repository",
	'plugins:homepage' => "Plugin/project homepage",
	'plugins:category' => "カテゴリ",
	'plugins:categories' => "カテゴリ",
	'plugins:myplugins' => "Your plugins",
	'plugins:All' => "全部",
	'plugins:file' => 'File to upload',
	'plugins:donate' => 'Donations',
	'plugins:file:uploadagain' => 'Upload a new version',
	'plugins:version' => 'Plugin version',
	'plugins:downloads' => "ダウンロード数",
	'plugins:recommendations' => "お薦め数",
	'plugins:upload' => "Upload a new plugin, theme or language pack",
	'plugins:changelog' => "Changelog",
	'plugins:noproject' => "I am afraid the system was not able to find the plugin project you tried to update",
	'plugins:plugin or theme' => "ファイル",
	'plugins:updated' => "更新",
	'plugins:update' => "Upload a new version of this plugin",
	'plugins:title' => "タイトル",
	'plugins:desc' => "説明",
	'plugins:tags' => "タグ",
	'plugins:notfound' => "The requested plugin cannot be found, please try a search",

	'plugins:plugin_type' => 'Type of plugin?',
	'plugins:plugin' => 'Plugin',
	'plugins:theme' => 'Theme',
	'plugins:languagepack' => 'Language pack',

	'plugins:user:plugin' => "View %s's plugins",
	'plugins:user:theme' => "View %s's themes",
	'plugins:user:languagepack' => "View %s's language packs",

	'plugins:types' => "Uploaded plugins, themes or language pack types",

	'plugins:type:all' => "Elgg plugins",
	'plugins:type:plugin' => 'プラグイン管理',
	'plugins:type:theme' => 'テーマ',
	'plugins:type:languagepack' => 'Language packs',
	'plugins:user:type:languagepack' => "%s's language packs",
	'plugins:user:type:general' => "%s's general plugins and themes",
	'plugins:widget' => "Plugin widget",
	'plugins:widget:description' => "Showcase your latest plugins, themes and language packs",

	'plugins:download' => "ダウンロード",

	'plugins:delete_release:confirm' => "Are you sure you want to delete this release?",
	'plugins:delete_project:confirm' => 'This project and all releases will be deleted.  Are you sure you want to delete this project?',
	'plugins:delete_project_image:confirm' => 'Delete image?',
	'plugins:tagcloud' => "タグクラウド",
	'plugins:diggit' => "You have recommended this plugin.",
	'plugins:display:number' => "Number of plugins, themes and language packs to display",

	'plugins:files:acceptable' => 'Distribution packages must be .zip or .tar.zip only.',

	'item:object:plugin_project' => 'Plugin Projects',
	'item:object:plugin_release' => 'Plugin Releases',
	'item:object:file' => 'Plugin Screenshots',

	'plugins:tabs:stats' => '統計情報',
	'plugins:tabs:upgrade' => 'アップグレード',
	'plugins:tabs:utilities' => 'ユーティリティ',
	'plugins:tabs:search' => 'Search settings',
	'plugins:matching' => 'Plugins matching',
	'plugins:add:contributor' => "Add Contributors: %s",
	'plugins:title:transfer_plugin' => "Transfer Plugin: %s",
	'plugins:title:request_ownership' => "Request ownership of the plugin: %s",
	'plugins:project:request_ownership:desc' => "<p>This form allows you to request ownership of the plugin project.</p>
<p>Please tell us a bit about yourself so we'll know that the plugin will be in good hands. You can tell for example:</p>
<ul>
	<li>Why do you want to become the author?</li>
	<li>What kind of experience do you have in plugin development?</li>
	<li>What would make you a good author or the plugin?</li>
	<li>What kind of changes would you do to the plugin?</li>
</ul>",
	
	'projects:new:release' => "New Release",
	'plugins:new:plugin' => "New Plugin",

	/**
	 * Notifications
	 */
	'plugins:plugin_project:notify:subject' => '%s has uploaded a new plugin called %s',
	'plugins:plugin_release:notify:subject' => '%s has released a new version of the plugin %s',
	'plugins:plugin_project:notify:body' => "%s has uploaded a new plugin called %s \n\n %s \n\n %s",
	'plugins:plugin_release:notify:body' => "%s has released a new version of the plugin %s \n\n %s \n\n %s",
	'plugins:plugin_project:notify:summary' => 'New plugin project called %s',
	'plugins:plugin_release:notify:summary' => 'New release of the plugin %s',

	'plugins:ownership_request:notify:subject' => 'A new plugin ownership request',
	'plugins:ownership_request:notify:body' => "There's a new plugin ownership request:
%s",

	/**
	 * Licenses
	 */
	'license' => 'ライセンス',
	'license:none' => 'No license selected',
	'license:blurb' => 'Your plugin or theme must be released under a GPL version 2 compatible license. Please select from the list below, or click here for more details.',
	'license:gpl2' => 'GNU General Public License (GPL) version 2',
	'license:gpl3' => 'GNU General Public License (GPL) version 3',
	'license:lgpl3' => 'GNU Lesser General Public License (LGPL) version 3',
	'license:lgpl2.1' => 'GNU Lesser General Public License (LGPL) version 2.1',
	'license:agpl3' => 'GNU Affero General Public License (AGPL) version 3',
	'license:apache' => 'Apache License, Version 2.0',
	'license:artistic' => 'Artistic License 2.0',
	'license:artistic' => 'Artistic License 2.0',
	'license:berkeleydb' => 'Berkeley Database License (aka the Sleepycat Software Product License)',
	'license:boost' => 'Boost Software License',
	'license:mbsd' => 'Modified BSD license',
	'license:cbsd' => 'The Clear BSD License',
	'license:cecill' => 'CeCILL version 2',
	'license:cryptix' => 'Cryptix General License',
	'license:ecos' => 'eCos license version 2.0',
	'license:edu' => 'Educational Community License 2.0',
	'license:eiffel' => 'Eiffel Forum License, version 2',
	'license:eudatagrid' => 'EU DataGrid Software License',
	'license:expat' => 'Expat (MIT) License',
	'license:freebsd' => 'FreeBSD license',
	'license:freetype' => 'Freetype Project License',
	'license:jpeg' => 'Independent JPEG Group License',
	'license:intel' => 'Intel Open Source License',
	'license:openbsd' => 'ISC (OpenBSD) License',
	'license:ncsa' => 'NCSA/University of Illinois Open Source License',
	'license:public' => 'Public Domain',
	'license:sgi' => 'SGI Free Software License B, version 2.0',
	'license:w3c' => 'W3C Software Notice and License',
	'license:x11' => 'X11 License',
	'license:zope' => 'Zope Public License, versions 2.0 and 2.1',

	/**
	 * Status messages
	 */

	'plugins:project:saved' => "The plugin was successfully saved.",
	'plugins:release:saved' => "The plugin release was successfully saved.",
	'plugins:project:deleted' => "The plugin was deleted.",
	'plugins:release:deleted' => "The plugin release was deleted.",
	'plugins:ownership_request:success' => "Ownership request has been sent",

	/**
	 * Error messages
	 */

	'plugins:none' => "We couldn't find any plugins, themes or language packs at the moment.",
	'plugins:error:deletefailed' => "Your plugin or theme could not be deleted.",
	'plugins:error:permissions' => 'There was a permissions error.',
	'plugins:error:downloadfailed' => "Download failed.",
	'plugins:error:uploadfailed' => "Sorry; we could not save your plugins, theme or language pack.",
	'plugins:error:badformat' => 'We only support .zip and .tar.gz distribution packages.',
	'plugins:error:badlicense' => 'You must select a GPL-compatible license.',
	'plugins:error:notitle' => 'A title is required.',
	'plugins:error:no_version' => 'A version is required.',
	'plugins:error:no_elgg_version' => 'An Elgg version is required',
	'plugins:error:duplicate_version' => 'This version is already in use for this project',
	'plugins:error:not_found' => 'The plugin project was not found',
	'plugins:error:invalid_ownership_request' => 'The description is a required field',
	'plugins:error:ownership_request_failed' => 'The ownership request failed',
	'plugins:error:ownership_request_exists' => 'You already have a pending ownership request',

	/**
	 * New frontpage
	 **/

	'plugins:search' => "プラグインを検索",
	'plugins:stats' => "ダウンロードの統計情報",
	'plugins:popular' => "Most popular",
	'plugins:popular:more' => "人気のあるプラグインをもっと見る...",
	'plugins:counter' => "%s plugins with %s total downloads",


	'replace' => '置換',
	"unknown:version" => '不明なバージョン',

	'plugins:prevversions' => "Previous version",
	'plugins:nextversions' => "警告！新しいバージョンがご利用できます。",

	'plugins:browse_more:newest' => "プラグイン一覧を最近発表された順で見る",
	'plugins:browse_more:popular' => "プラグイン一覧をダウンロードされた順で見る",
	'plugins:browse_more:dugg' => "プラグイン一覧をお薦め順で見る",


	/**
	 * Sort field labels
	 */

	'plugins:sort:info' => '並べ方:',
	'plugins:sort:title' => 'タイトル',
	'plugins:sort:author' => '開発者',
	'plugins:sort:downloads' => 'ダウンロード数',
	'plugins:sort:recommendations' => 'お薦め数',
	'plugins:sort:created' => '作成',
	'plugins:sort:updated' => '更新',


	/**
	 * Filters
	 */

	'plugins:filters:title' => 'プラグイン検索の条件...',
	'plugins:filters:category' => 'カテゴリ',
	'plugins:filters:version' => 'Elgg version',
	'plugins:filters:licence' => 'ライセンスの形式',
	'plugins:filters:text' => '任意のテキスト',
	'plugins:filters:screenshot:label' => 'スクリーンショット',
	'plugins:filters:screenshot' => 'スクリーンショットのみ',

	/**
	 * Search labels
	 */

	'plugins:search:title' => 'Plugin search for \"%s\" in category: %s',
	'plugins:search:results' => '%d 個のプラグインを見つけました。%d から %d を表示しています。',
	'plugins:search:noresults' => 'お探しのプラグインは、見つかりませんでした。',
	'plugins:search:noresults:info' => '私たちのリポジトリには、お探しのプラグインは見つかりませんでした。検索キーワードの枠を広げてもう一度試してみてください。',

	/**
	 * What's new
	 */

	'plugins:front:intro:whatsnew' => '最新情報',
	'plugins:front:intro:whatsnew:text' => 'You can now search and browse plugins more effectively than ever before. Use the right column block to filter plugins based on categories, Elgg version compatibility and more. Sort results by download counts, recommendations, authors and other properties.',

	/**
	 * Search settings
	 */

	'plugins:settings:sort:label'	=> "Enable plugin list sorting",
	'plugins:settings:filter:multiple:label'	=> "Allow using multiple filters in a single search",
	'plugins:settings:filter:category:label'	=> "Enable filtering based on plugin category",
	'plugins:settings:filter:category:multiple'	=> "Allow multiple category selection",
	'plugins:settings:filter:version:label'	=> "Enable filtering based on Elgg version compatibility",
	'plugins:settings:filter:version:multiple'	=> "Allow multiple version selection",
	'plugins:settings:filter:licence:label'	=> "Enable filtering based on licence type",
	'plugins:settings:filter:licence:multiple'	=> "Allow multiple licence type selection",
	'plugins:settings:filter:text:label'	=> "Enable filtering based on any text (match title and description by default)",
	'plugins:settings:filter:text:author:name'	=> "Also match author's display name",
	'plugins:settings:filter:text:author:username'	=> "Also match author's username",
	'plugins:settings:filter:text:summary'	=> "Also match plugin's summary",
	'plugins:settings:filter:text:tags'	=> "Also match plugin's tags",
	'plugins:settings:filter:screenshot:label'	=> "Enable filtering based on screenshot availability",


	'plugins:settings:save:success'	=> "Plugin search settings were successfully updated",
	'plugins:settings:save:failure'	=> "Could not save plugin search settings: unrecognized parameters received.",

	'plugins:filters:or' => '...or ',
	
	'plugins:placeholder:categories' => "Choose categories",
	'plugins:placeholder:versions' => "Choose Elgg versions",
	'plugins:placeholder:licences' => "Choose licenses",
	'plugins:placeholder:keyword' => "Filter by keyword",


	'river:comment:object:plugin_release' => '%s commented on the plugin %s',
	'river:comment:object:plugin_project' => '%s commented on the plugin %s',
	'river:create:object:plugin_project' => "%s uploaded a new plugin: %s",
	'river:create:object:plugin_release' => "%s released a new version of the plugin %s",

	/* Edit Form */
	'plugins:edit:helptext' => "You are editing the plugin project information for %s.  To upload a new release click %s.",
	'plugins:add:helptext' => "You are creating a new plugin project. If you want to release a new
	version of an existing plugin, go to the edit section of that plugin's project page. You can view all of your plugins %s",
	'plugins:edit:label:name' => "Project Name",
	'plugins:edit:label:project_summary' => 'Project Summary',
	'plugins:edit:help:project_summary' => "A one- or two-sentence (250 characters) summary of your project's main features.",
	'plugins:edit:label:description' => "Project Description",
	'plugins:edit:help:description' => "A full description of your project's features. (As per %s, images and links will be removed.)",
	'plugins:edit:label:plugin_type' => "Type of Project",
	'plugins:edit:label:project_homepage' => "Project Homepage",
	'plugins:edit:label:donate' => "Donations URL",
	'plugins:edit:help:donate' => "If you accept donations, enter the URL to the donations section of your website.",
	'plugins:edit:help:tags' => "A comma-separated list of tags relevant to your project.",
	'plugins:edit:help:access' => "The access level of the project. Note that individual releases can have their own access settings.",
	'plugins:edit:recommended:none' => 'No recommended release',
	'plugins:edit:label:project_images' => "Project Images",
	'plugins:edit:help:project_images' => "Show off your project by uploading images!",
	'plugins:edit:image' => "Image",
	'plugins:edit:help:release' => "This information is specific to the release you are uploading right now.  To edit the
general project details, visit the edit section of the project page.",
	'plugins:edit:help:file' => 'This information is specific to the release you are uploading right now.  To edit the
general project details, visit the edit section of the project page.',
	'plugins:edit:label:release_version' => "Release version",
	'plugins:edit:label:release_notes' => "Release Notes",
	'plugins:edit:help:release_notes' => "A list of changes, bugfixes, bugs, todos, and general release notes for this release. (As per %s, images and links will be removed.)",
	'plugins:edit:label:elgg_version' => "Elgg compatibility",
	'plugins:edit:help:elgg_version' => "The version of Elgg this plugin was developed and tested on",
	'plugins:edit:label:comments' => "Allow comments",
	'plugins:edit:help:access' => "The access level of the project. Note that individual releases can have their own access settings.",
	'plugins:edit:label:recommended' => "Set as the recommended release",
	'plugins:edit:help:recommended' => "Recommend all users of this plugin use this release?",
	'plugins:link:here' => 'here',

	/**
	 * Misc
	 */
	 'plugins:warning:page:all:bookmark' => 'Please update your bookmark or report this link to the site owner as this page has moved.',
	 'plugins:error:invalid_release' => "We could not find the release you specified.",
	 'plugins:forward:recommended_release' => "Forwarded to recommended release.",
	 'plugins:error:unrecognized_plugin' => "We did not recognize that plugin",

	/**
	 *	Actions
	 */
	'plugins:action:combine:invalid_guids' => 'The GUIDs must be for 2 plugin projects',
	'plugins:action:combine:success' => "%s has been combined into the project %s",
	'plugins:action:normalize:invalid_guid' => "No GUID specified",
	'plugins:action:normalize:notpreview' => "Normalized downloads removing %s annotations",
	'plugins:action:normalize:preview' => "Would have removed %s annotations using a max of %s",
	'plugins:action:invalid_project' => 'Invalid Project',
	'plugins:action:transfer:invalid_recipient' => 'Invalid Recipient',
	'plugins:action:transfer:success' => 'Plugin ownership has been transferred.',
	'plugins:action:upgrade:not_required' => 'No upgrade required',
	'plugins:action:upgrade:success' => "The community plugin repository has been upgraded",
	'plugins:action:invalid_contributors' => 'Invalid Contributors',
	'plugins:action:add_contributors:success' => 'Contributors have been added.',
	'plugins:action:invalid_user' => "正しいユーザではありません",
	'plugins:action:delete_contributor:success' => 'User has been removed from the contributors list',
	'plugins:action:invalid_access' => 'Unknown or insufficient access to release',
	'plugins:action:transfer:not_moved' => "Release ID: %s - the file could not be moved on the file system",
);
