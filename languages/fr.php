<?php
/**
 * Elgg community plugin repository language pack
 */

return array(
	/**
	 * Administration area
	 */

	'admin:community_plugins' => 'Dépot de Plugins',
	'admin:community_plugins:statistics' => 'Statistiques',
	'admin:community_plugins:upgrade' => 'Mise à jour',
	'admin:community_plugins:utilities' => 'Utilitaires',
	'admin:settings:community_plugins' => 'Dépot des Plugins',
	'plugins:admin:trends:title' => 'Tendances des téléchargements des Plugins',
	'plugins:admin:trends:help' => "Affiche les téléchargements des 30 derniers jours. Pour voir les téléchargements pour un plugin particulier, entrez le GUID du projet du plugin ci-dessous.",
	'plugins:admin:trends:single' => "Statistiques de %s",
	'plugins:admin:trends:all' => "Statistiques de tous les plugins",
	'plugins:admin:upgrade:required' => "Une mise à jour est nécessaire pour ce plugin.",
	'plugins:admin:upgrade:ok' => "Aucune mise à jour nécessaire.",
	'plugins:admin:utilities:combine' => 'Combiner des projets de plugin',
	'plugins:admin:combine:old_guid' => 'GUID of plugin project that is be replaced in the combination',
	'plugins:admin:combine:new_guid' => 'GUID of plugin project that remains in the combination',
	'plugins:admin:normalize:help' => 'Remove inflated download counts for the currently graphed plugin',
	'plugins:admin:transfer:title' => "Transférer la propriété du plugin à un autre utilisateur.",
	'plugins:admin:transfer:help' => 'Begin typing the name of the user you wish to tranfer the plugin to and select them from the list.
	  Select only one user, if more than one is selected, only the first user selected will receive ownership.',
	'plugins:admin:contributors:title' => "Lister les utilisateurs en tant que contributeurs à ce plugin",
	'plugins:admin:contributors:help' => "Adding users as contributors <b>does not</b> give them any special privileges with regard to the plugin page, it does however list them as contributing members.
		It is a way of recognizing community members for their collaborative work of reporting bugs, and submitting patches for bugfixes and enhancements.
		Begin typing the name of the user who has contributed to the plugin.  You can select as many users as necessary.",


	/**
	 *	Object views
	 */
	'plugins:uploadtime' => "Envoyé %s (%s)",
	'plugins:updatedtime' => "Updated %s (%s)",
	'plugins:release:version_warning' => 'Attention: L\'auteur recommande d\'utiliser une version différente de ce plugin! Voulez-vous quand même télécharger cette version ?',
	'plugins:download:version' => "Télécharger %s",
	'plugins:project:title:version' => "%s pour Elgg %s",
	'plugins:author:byline' => "de %s",
	'plugins:last:updated' => "Dernière mise à jour %s",

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

	'plugins' => "Administrer les plugins",
	'pluginss' => "Administrer les plugins",

	'plugins:new' => "Nouveau plugin",

	'plugins:types:' => "plugins, thèmes et packs de langues",
	'plugins:types:plugin' => "plugins",
	'plugins:types:theme' => "thèmes",
	'plugins:types:languagepack' => "packs de langues",

	'plugins:yours' => "Vos %s",
	'plugins:user' => "%s's %s",

	'plugins:admin' => "Administration du dépôt de plugins",
	'plugins:admin:menu' => "Admin du dépôt de plugins",

	'plugins:yours:friends' => "Les plugins, thèmes et packs de langue de vos contacts",
	'plugins:friends' => "Les plugins, thèmes et packs de langue des contacts de %s",
	'plugins:all' => "Plugins, thèmes et packs de langue du site",
	'plugins:category:title' => "Plugins de la catégorie: %s",
	'plugins:search:title' => "Plugin search for \"%s\" in category: %s",


	'plugins:cat:all' => 'Tous',

	'plugins:listing:newest' => 'Nouveaux',
	'plugins:listing:popular' => 'Les + téléchargés',
	'plugins:listing:dugg' => 'Les + recommandés',


	'plugins:upload:new' => "Envoyer un nouveau plugin",


	'plugins:search:instruct' => 'rechercher des plugins',
	'plugins:search:choose' => 'choisir une catégorie',


	'plugins:front:welcome' => "Bienvenue dans le répertoire des plugins d'Elgg",
	'plugins:front:intro:title' => "Que sont les plugins ?",
	'plugins:front:intro:text' => "Plugins extend your Elgg site by adding additional functionality, languages and themes. They are contributed by members of the Elgg community.

		To get started you could browse the available plugins, search for a specific one, upload one of your own, or rate & comment on others.",




	'plugins:more' => "plus de plugins, thèmes et packs de langue",
	'plugins:list' => "Vue liste",
	'plugins:group' => "Plugins, thèmes et packs de langue du groupe",
	'plugins:gallery' => "Vue galerie",
	'plugins:gallery_list' => "Vue 'liste' ou 'galerie'",
	'plugins:num_files' => "Nombre de plugins, thèmes et packs de langue à afficher",
	'plugins:yes' => 'Oui',
	'plugins:no' => 'Non',
	'plugins:num_plugins and themes' => "Nombre de plugins, thèmes et packs de langue à afficher",

	'plugins:new:project' => "Envoyer un nouveau plugin",
	'plugins:new:release' => "Envoyer la nouvelle version",

	'plugins:edit' => "Modifier",
	'plugins:edit:project' => "Modifier les détails du projet",
	'plugins:edit:release' => "Modifier la version du plugin",
	'plugins:contributors:add' => "Ajouter des contributeurs",
	'plugins:delete:project' => "Projet supprimé",
	'plugins:requests:ownership' => "Pending ownership requests",
	'plugins:transfer:ownership' => "Transfer Ownership",
	'plugins:author:homepage' => "Author homepage",
	'plugins:author:recommended' => "Recommandé par l'auteur",
	'plugins:project:page:view' => "Project Page",

	'plugins:elggversion' => "Ce plugin a été testé avec la(les) version(s) d'Elgg",
	'plugins:elgg_version' => "Version d'Elgg",
	'plugins:version' => "Version du plugin",
	'plugins:updated' => "Mis à jour",
	'plugins:repo' => "Dépôt de code",
	'plugins:homepage' => "Page d'accueil du plugin/du projet",
	'plugins:category' => "Catégorie",
	'plugins:categories' => "Catégories",
	'plugins:myplugins' => "Vos plugins",
	'plugins:All' => "Tous",
	'plugins:file' => 'Fichier à envoyer',
	'plugins:donate' => 'Donations',
	'plugins:file:uploadagain' => 'Envoyer une nouvelle version',
	'plugins:version' => 'Version du plugin',
	'plugins:downloads' => "Téléchargements",
	'plugins:recommendations' => "Recommandations",
	'plugins:upload' => "Envoyer un nouveau plugin, thème ou pack de langue",
	'plugins:changelog' => "Journal des modifications",
	'plugins:noproject' => "I am afraid the system was not able to find the plugin project you tried to update",
	'plugins:plugin or theme' => "Fichier",
	'plugins:updated' => "Mis à jour",
	'plugins:update' => "Envoyer une nouvelle version de ce plugin",
	'plugins:title' => "Titre",
	'plugins:desc' => "Description",
	'plugins:tags' => "Tags",
	'plugins:notfound' => "The requested plugin cannot be found, please try a search",

	'plugins:plugin_type' => 'Type de plugin ?',
	'plugins:plugin' => 'Plugin',
	'plugins:theme' => 'Thème',
	'plugins:languagepack' => 'Pack de Langue',

	'plugins:user:plugin' => "Voir les plugins de %s",
	'plugins:user:theme' => "Voir les thèmes de %s",
	'plugins:user:languagepack' => "Voir les packs de langue de %s",

	'plugins:types' => "Plugins, thèmes ou types de pack de langue envoyés",

	'plugins:type:all' => "Plugins d'Elgg",
	'plugins:type:plugin' => 'Administrer les plugins',
	'plugins:type:theme' => 'Thèmes',
	'plugins:type:languagepack' => 'Packs de Langue',
	'plugins:user:type:languagepack' => "Packs de Langue de %s",
	'plugins:user:type:general' => "Plugins généraux et thèmes de %s",
	'plugins:widget' => "Plugin widget",
	'plugins:widget:description' => "Showcase your latest plugins, themes and language packs",

	'plugins:download' => "Télécharger le fichier '.txt'",

	'plugins:delete_release:confirm' => "Etes-vous sûr(e) de vouloir supprimer cette version ?",
	'plugins:delete_project:confirm' => 'Ce projet et toutes ses versions vont être supprimés. Etes-vous sûr(e) de vouloir supprimer ce projet ?',
	'plugins:delete_project_image:confirm' => 'Supprimer l\'image ?',
	'plugins:tagcloud' => "Nuage de tags",
	'plugins:diggit' => "Vous avez recommandé ce plugin.",
	'plugins:display:number' => "Nombre de plugins, thèmes et packs de langue à afficher",

	'plugins:files:acceptable' => 'Les paquets de distribution doivent être au format .zip ou .tar.zip seulement.',

	'item:object:plugin_project' => 'Plugin Projects',
	'item:object:plugin_release' => 'Versions du plugin',
	'item:object:file' => 'Captures d\'écran du plugin',

	'plugins:tabs:stats' => 'Statistiques',
	'plugins:tabs:upgrade' => 'Mise à niveau',
	'plugins:tabs:utilities' => 'Utilitaires',
	'plugins:tabs:search' => 'Paramètres de recherche',
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
	'plugins:plugin_project:notify:summary' => 'Nouveau projet de plugin nommé %s',
	'plugins:plugin_release:notify:summary' => 'Nouvelle version du plugin %s',

	'plugins:ownership_request:notify:subject' => 'A new plugin ownership request',
	'plugins:ownership_request:notify:body' => "There's a new plugin ownership request:
%s",

	/**
	 * Licenses
	 */
	'license' => 'Licence',
	'license:none' => 'Pas de licence sélectionnée',
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

	'plugins:project:saved' => "Le plugin a bien été enregistré.",
	'plugins:release:saved' => "The plugin release was successfully saved.",
	'plugins:project:deleted' => "Le plugin a été supprimé.",
	'plugins:release:deleted' => "The plugin release was deleted.",
	'plugins:ownership_request:success' => "Ownership request has been sent",

	/**
	 * Error messages
	 */

	'plugins:none' => "We couldn't find any plugins, themes or language packs at the moment.",
	'plugins:error:deletefailed' => "Votre plugin ou thème n'a pas pu être supprimé.",
	'plugins:error:permissions' => 'There was a permissions error.',
	'plugins:error:downloadfailed' => "Échec du téléchargement.",
	'plugins:error:uploadfailed' => "Sorry; we could not save your plugins, theme or language pack.",
	'plugins:error:badformat' => 'We only support .zip and .tar.gz distribution packages.',
	'plugins:error:badlicense' => 'You must select a GPL-compatible license.',
	'plugins:error:notitle' => 'A title is required.',
	'plugins:error:no_version' => 'A version is required.',
	'plugins:error:no_elgg_version' => 'An Elgg version is required',
	'plugins:error:duplicate_version' => 'Cette version est déjà utilisée pour ce projet',
	'plugins:error:not_found' => 'The plugin project was not found',
	'plugins:error:invalid_ownership_request' => 'The description is a required field',
	'plugins:error:ownership_request_failed' => 'The ownership request failed',
	'plugins:error:ownership_request_exists' => 'You already have a pending ownership request',

	/**
	 * New frontpage
	 **/

	'plugins:search' => "Search plugins",
	'plugins:stats' => "Download stats",
	'plugins:popular' => "Most popular",
	'plugins:popular:more' => "See more popular plugins ...",
	'plugins:counter' => "%s plugins with %s total downloads",


	'replace' => 'Replace',
	"unknown:version" => 'Version inconnue',

	'plugins:prevversions' => "Version précédente",
	'plugins:nextversions' => "Attention! Une nouvelle version est disponible",

	'plugins:browse_more:newest' => "Parcourir les plugins les plus récents",
	'plugins:browse_more:popular' => "Parcourir les plugins les plus téléchargés",
	'plugins:browse_more:dugg' => "Parcourir les plugins les plus recommandés",


	/**
	 * Sort field labels
	 */

	'plugins:sort:info' => 'Trier par:',
	'plugins:sort:title' => 'Titre',
	'plugins:sort:author' => 'Auteur',
	'plugins:sort:downloads' => 'Téléchargements',
	'plugins:sort:recommendations' => 'Recommendations',
	'plugins:sort:created' => 'Créé',
	'plugins:sort:updated' => 'Mis à jour',


	/**
	 * Filters
	 */

	'plugins:filters:title' => 'Search plugins based on...',
	'plugins:filters:category' => 'Catégorie',
	'plugins:filters:version' => 'Version d\'Elgg',
	'plugins:filters:licence' => 'Type de licence',
	'plugins:filters:text' => 'Any text',
	'plugins:filters:screenshot:label' => 'Captures d\'écran',
	'plugins:filters:screenshot' => 'Uniquement avec capture d\'écran',

	/**
	 * Search labels
	 */

	'plugins:search:title' => 'Plugin search for \"%s\" in category: %s',
	'plugins:search:results' => 'Found %d plugins, displaying %d to %d',
	'plugins:search:noresults' => 'Aucun plugin trouvé',
	'plugins:search:noresults:info' => 'Your search did not match any plugins in our repository. Please try again with less specific search terms.',

	/**
	 * What's new
	 */

	'plugins:front:intro:whatsnew' => 'Quoi de neuf?',
	'plugins:front:intro:whatsnew:text' => 'Vous pouvez maintenant rechercher et parcourir les plugins plus efficacement que jamais auparavant. Utilisez le bloc de la colonne de droite pour filtrer les plugins par catégories, la compatibilité avec une d\'version Elgg et plus. Triez les résultats par nombre de téléchargement, recommandations, auteurs et autres propriétés.',

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
	'plugins:action:invalid_user' => "Utilisateur invalide",
	'plugins:action:delete_contributor:success' => 'User has been removed from the contributors list',
	'plugins:action:invalid_access' => 'Unknown or insufficient access to release',
	'plugins:action:transfer:not_moved' => "Release ID: %s - the file could not be moved on the file system",
);
