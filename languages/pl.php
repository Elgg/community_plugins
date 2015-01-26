<?php
/**
 * Elgg community plugin repository language pack
 */

return array(
	/**
	 * Administration area
	 */

	'admin:community_plugins' => 'Repozytorium wtyczek',
	'admin:community_plugins:statistics' => 'Statystyki',
	'admin:community_plugins:upgrade' => 'Aktualizuj',
	'admin:community_plugins:utilities' => 'Narzędzia',
	'admin:settings:community_plugins' => 'Repozytorium wtyczek',
	'plugins:admin:trends:title' => 'Plugin download trends',
	'plugins:admin:trends:help' => "This displays the downloads for the past 30 days. To see the downloads for a particular plugin, enter the GUID of the plugin project below.",
	'plugins:admin:trends:single' => "Statystyki dla %s",
	'plugins:admin:trends:all' => "Statystyki dla wszystkich pluginów",
	'plugins:admin:upgrade:required' => "Aktualizacja jest wymagana dla tego pluginu.",
	'plugins:admin:upgrade:ok' => "Brak wymaganych aktualizacji.",
	'plugins:admin:utilities:combine' => 'Combine plugin projects',
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
	'plugins:uploadtime' => "Przesłano %s (%s)",
	'plugins:updatedtime' => "Zaktualizowano %s (%s)",
	'plugins:release:version_warning' => 'Warning: The author recommends using a different release of this plugin! Do you still want to download this release?',
	'plugins:download:version' => "Pobierz %s",
	'plugins:project:title:version' => "%s dla Elgg %s",
	'plugins:author:byline' => "przez %s",
	'plugins:last:updated' => "Ostatnia aktualizacja %s",

	'plugins:project:outdated_warning' => "<strong>Warning:</strong> This plugin has't been updated in over %s years. It may no longer be maintained.",
	'plugins:project:help' => "What <i>you</i> can do to help:",

	'plugins:project:pull_request' => 'żądanie pull',
	'plugins:project:repo' => 'kod pluginu',
	'plugins:project:collaborate' => "Wyślij %s aby uaktualnić %s", // Submit a <pull request> to update the <plugin code>

	'plugins:project:request' => 'become the new maintainer',
	'plugins:project:request_ownership' => "Request to %s of the plugin",
	'plugins:latest:releases' => "Ostatnie wydania",
	'plugins:releases:all' => "Wszystkie wydania",
	'plugins:recommended:releases' => "Rekomendowane wydania",
	'plugins:releases:show:recent' => 'Show recent releases',
	'plugins:releases:show:all' => "Pokaż wszystkie wydania",
	'plugins:releases:show:recommended' => "Pokaż rekomendowane wydania",
	'plugin:release:version:unknown' => "?",

	/**
	 * Menu items and titles
	 */

	'plugins' => "Wtyczki",
	'pluginss' => "Wtyczki",

	'plugins:new' => "Nowa wtyczka",

	'plugins:types:' => "wtyczki, motywy i paczki językowe",
	'plugins:types:plugin' => "wtyczki",
	'plugins:types:theme' => "motywy",
	'plugins:types:languagepack' => "paczki językowe",

	'plugins:yours' => "Twoje %s",
	'plugins:user' => "%s %s",

	'plugins:admin' => "Administracja repozytorium wtyczek",
	'plugins:admin:menu' => "Administracja repozytorium wtyczek",

	'plugins:yours:friends' => "Wtyczki, motywy i pakiety językowe Twoich znajomych",
	'plugins:friends' => "Wtyczki, motywy i pakiety językowe znajomych %s",
	'plugins:all' => "Wszystkie wtyczki, motywy i pakiety językowe ze strony",
	'plugins:category:title' => "Wtyczki kategorii: %s",
	'plugins:search:title' => "Szukanie wtyczki \"%s\" w kategorii: %s",


	'plugins:cat:all' => 'Wszystkie',

	'plugins:listing:newest' => 'Najnowsze',
	'plugins:listing:popular' => 'Najczęściej pobierane',
	'plugins:listing:dugg' => 'Najbardziej polecane',


	'plugins:upload:new' => "Prześlij nową wtyczkę",


	'plugins:search:instruct' => 'szukaj wtyczek',
	'plugins:search:choose' => 'wybierz kategorię',


	'plugins:front:welcome' => "Witamy w katalogu wtyczek Elgg",
	'plugins:front:intro:title' => "Czym są wtyczki?",
	'plugins:front:intro:text' => "Plugins extend your Elgg site by adding additional functionality, languages and themes. They are contributed by members of the Elgg community.

		To get started you could browse the available plugins, search for a specific one, upload one of your own, or rate & comment on others.",




	'plugins:more' => "więcej wtyczek, motywów i paczek językowych",
	'plugins:list' => "widok listy",
	'plugins:group' => "Wtyczki, motywy i paczki językowe grupy",
	'plugins:gallery' => "widok galerii",
	'plugins:gallery_list' => "Widok galerii lub listy",
	'plugins:num_files' => "Liczba wtyczek, motywów i paczek językowych do wyświetlenia",
	'plugins:yes' => 'Tak',
	'plugins:no' => 'Nie',
	'plugins:num_plugins and themes' => "Liczba wtyczek, motywów i paczek językowych do wyświetlenia",

	'plugins:new:project' => "Prześlij nową wtyczkę",
	'plugins:new:release' => "Prześlij nowe wydanie",

	'plugins:edit' => "Edycja",
	'plugins:edit:project' => "Edycja szczegółów projektu",
	'plugins:edit:release' => "Edycja wydania wtyczki",
	'plugins:contributors:add' => "Dodaj współpracowników",
	'plugins:delete:project' => "Usuń projekt",
	'plugins:requests:ownership' => "Pending ownership requests",
	'plugins:transfer:ownership' => "Transfer Ownership",
	'plugins:author:homepage' => "Strona domowa autora",
	'plugins:author:recommended' => "Autor rekomenduje",
	'plugins:project:page:view' => "Strona projektu",

	'plugins:elggversion' => "Version(s) of Elgg this plugin has been tested on",
	'plugins:elgg_version' => "Wersja Elgg",
	'plugins:version' => "Wersja wtyczki",
	'plugins:updated' => "Zaktualizowane",
	'plugins:repo' => "Repozytorium kodu",
	'plugins:homepage' => "Strona domowa wtyczki/projektu",
	'plugins:category' => "Kategoria",
	'plugins:categories' => "Kategorie",
	'plugins:myplugins' => "Twoje wtyczki",
	'plugins:All' => "Wszystkie",
	'plugins:file' => 'Plik do przesłania',
	'plugins:donate' => 'Dotacje',
	'plugins:file:uploadagain' => 'Prześlij nową wersję',
	'plugins:version' => 'Wersja wtyczki',
	'plugins:downloads' => "Pobrania",
	'plugins:recommendations' => "Polecenia",
	'plugins:upload' => "Prześlij nową wtyczkę, motyw lub paczkę językową",
	'plugins:changelog' => "Historia zmian",
	'plugins:noproject' => "I am afraid the system was not able to find the plugin project you tried to update",
	'plugins:plugin or theme' => "Plik",
	'plugins:updated' => "Zaktualizowane",
	'plugins:update' => "Prześlij nową wersję tej wtyczki",
	'plugins:title' => "Tytuł",
	'plugins:desc' => "Opis",
	'plugins:tags' => "Tagi",
	'plugins:notfound' => "The requested plugin cannot be found, please try a search",

	'plugins:plugin_type' => 'Rodzaj wtyczki?',
	'plugins:plugin' => 'Wtyczka',
	'plugins:theme' => 'Motyw',
	'plugins:languagepack' => 'Paczka językowa',

	'plugins:user:plugin' => "Zobacz wtyczki użytkownika %s",
	'plugins:user:theme' => "Zobacz motywy użytkownika %s",
	'plugins:user:languagepack' => "Zobacz paczki językowe użytkownika %s",

	'plugins:types' => "Przesłane typy wtyczek, motywów i pakietów językowych",

	'plugins:type:all' => "Wtyczki do Elgg",
	'plugins:type:plugin' => 'Wtyczki',
	'plugins:type:theme' => 'Motywy',
	'plugins:type:languagepack' => 'Paczki językowe',
	'plugins:user:type:languagepack' => "Paczki językowe użytkownika %s",
	'plugins:user:type:general' => "Ogólne wtyczki i motywy użytkownika %s",
	'plugins:widget' => "Widżet wtyczek",
	'plugins:widget:description' => "Showcase your latest plugins, themes and language packs",

	'plugins:download' => "Pobierz",

	'plugins:delete_release:confirm' => "Czy na pewno chcesz usunąć to wydanie?",
	'plugins:delete_project:confirm' => 'This project and all releases will be deleted.  Are you sure you want to delete this project?',
	'plugins:delete_project_image:confirm' => 'Usunąć obraz?',
	'plugins:tagcloud' => "Chmura znaczników",
	'plugins:diggit' => "Poleciłeś już tę wtyczkę.",
	'plugins:display:number' => "Liczba wtyczek, motywów i paczek językowych do wyświetlenia",

	'plugins:files:acceptable' => 'Pakiety dystrybucyjne muszą być w rozszerzeniach .zip lub .tar.zip.',

	'item:object:plugin_project' => 'Projekty wtyczek',
	'item:object:plugin_release' => 'Wydania wtyczek',
	'item:object:file' => 'Zrzuty ekranu wtyczki',

	'plugins:tabs:stats' => 'Statystyki',
	'plugins:tabs:upgrade' => 'Aktualizacje',
	'plugins:tabs:utilities' => 'Narzędzia',
	'plugins:tabs:search' => 'Ustawienia wyszukiwania',
	'plugins:matching' => 'Plugins matching',
	'plugins:add:contributor' => "Dodaj współpracowników: %s",
	'plugins:title:transfer_plugin' => "Transferuj plugin: %s",
	'plugins:title:request_ownership' => "Żądaj prawa własności do pluginu: %s",
	'plugins:project:request_ownership:desc' => "<p>This form allows you to request ownership of the plugin project.</p>
<p>Please tell us a bit about yourself so we'll know that the plugin will be in good hands. You can tell for example:</p>
<ul>
	<li>Why do you want to become the author?</li>
	<li>What kind of experience do you have in plugin development?</li>
	<li>What would make you a good author or the plugin?</li>
	<li>What kind of changes would you do to the plugin?</li>
</ul>",
	
	'projects:new:release' => "Nowe wydanie",
	'plugins:new:plugin' => "Nowy plugin",

	/**
	 * Notifications
	 */
	'plugins:plugin_project:notify:subject' => '%s przesłał nową wtyczkę o nazwie %s',
	'plugins:plugin_release:notify:subject' => '%s wydał nową wersję wtyczki %s',
	'plugins:plugin_project:notify:body' => "%s przesłał nową wtyczkę o nazwie %s \n\n %s \n\n %s",
	'plugins:plugin_release:notify:body' => "%s wydał nową wersję wtyczki %s \n\n %s \n\n %s",
	'plugins:plugin_project:notify:summary' => 'New plugin project called %s',
	'plugins:plugin_release:notify:summary' => 'New release of the plugin %s',

	'plugins:ownership_request:notify:subject' => 'A new plugin ownership request',
	'plugins:ownership_request:notify:body' => "There's a new plugin ownership request:
%s",

	/**
	 * Licenses
	 */
	'license' => 'Licencja',
	'license:none' => 'Nie wybrano licencji',
	'license:blurb' => 'Twoja wtyczka lub motyw muszą być wydane na licencji GPL w wersji 2 lub kompatybilnej. Proszę wybrać z listy poniżej lub kliknąć tutaj po szczegóły.',
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
	'license:public' => 'Domena Publiczna',
	'license:sgi' => 'SGI Free Software License B, version 2.0',
	'license:w3c' => 'W3C Software Notice and License',
	'license:x11' => 'X11 License',
	'license:zope' => 'Zope Public License, versions 2.0 and 2.1',

	/**
	 * Status messages
	 */

	'plugins:project:saved' => "Pomyślnie zapisano wtyczkę.",
	'plugins:release:saved' => "Pomyślnie zapisano wydanie wtyczki.",
	'plugins:project:deleted' => "Skasowano wtyczkę.",
	'plugins:release:deleted' => "Skasowano wydanie wtyczki.",
	'plugins:ownership_request:success' => "Ownership request has been sent",

	/**
	 * Error messages
	 */

	'plugins:none' => "We couldn't find any plugins, themes or language packs at the moment.",
	'plugins:error:deletefailed' => "Twoja wtyczka lub motyw nie mogą być usunięte.",
	'plugins:error:permissions' => 'Wystąpił błąd uprawnień.',
	'plugins:error:downloadfailed' => "Pobieranie nie powiodło się.",
	'plugins:error:uploadfailed' => "Przykro nam, nie można było zapisać Twoich wtyczek lub paczek językowych.",
	'plugins:error:badformat' => 'Wspieramy tylko formaty .zip oraz .tar.gz jako pakiety dystrybucyjne.',
	'plugins:error:badlicense' => 'Musisz wybrać licencję zgodną z GPL.',
	'plugins:error:notitle' => 'Tytuł jest wymagany.',
	'plugins:error:no_version' => 'Wersja jest wymagana.',
	'plugins:error:no_elgg_version' => 'Wersja Elgg jest wymagana',
	'plugins:error:duplicate_version' => 'This version is already in use for this project',
	'plugins:error:not_found' => 'The plugin project was not found',
	'plugins:error:invalid_ownership_request' => 'Pole opisu jest wymagane',
	'plugins:error:ownership_request_failed' => 'Żądanie prawa własności nie powiodło się',
	'plugins:error:ownership_request_exists' => 'You already have a pending ownership request',

	/**
	 * New frontpage
	 **/

	'plugins:search' => "Szukaj wtyczek",
	'plugins:stats' => "Statystyki pobrań",
	'plugins:popular' => "Najpopularniejsze",
	'plugins:popular:more' => "Zobacz więcej popularnych wtyczek...",
	'plugins:counter' => "%s wtyczek, pobranych w sumie %s razy",


	'replace' => 'Zastąp',
	"unknown:version" => 'Nieznana wersja',

	'plugins:prevversions' => "Poprzednia wersja",
	'plugins:nextversions' => "Uwaga! Jest dostępna nowsza wersja",

	'plugins:browse_more:newest' => "Przeglądaj ostatnie wtyczki",
	'plugins:browse_more:popular' => "Przeglądaj najczęściej pobierane wtyczki",
	'plugins:browse_more:dugg' => "Przeglądaj najbardziej polecane wtyczki",


	/**
	 * Sort field labels
	 */

	'plugins:sort:info' => 'Sortuj według:',
	'plugins:sort:title' => 'Tytuł',
	'plugins:sort:author' => 'Autor',
	'plugins:sort:downloads' => 'Pobrania',
	'plugins:sort:recommendations' => 'Polecenia',
	'plugins:sort:created' => 'Utworzono',
	'plugins:sort:updated' => 'Zaktualizowano',


	/**
	 * Filters
	 */

	'plugins:filters:title' => 'Szukaj wtyczek w oparciu o...',
	'plugins:filters:category' => 'Kategoria',
	'plugins:filters:version' => 'Wersja Elgg',
	'plugins:filters:licence' => 'Rodzaj licencji',
	'plugins:filters:text' => 'Dowolny tekst',
	'plugins:filters:screenshot:label' => 'Zrzut ekranu',
	'plugins:filters:screenshot' => 'Tylko ze zrzutem ekranu',

	/**
	 * Search labels
	 */

	'plugins:search:title' => 'Szukanie wtyczki \"%s\" w kategorii: %s',
	'plugins:search:results' => 'Znaleziono %d wtyczek, wyświetlanie %d do %d',
	'plugins:search:noresults' => 'Nie odnaleziono wtyczek',
	'plugins:search:noresults:info' => 'Your search did not match any plugins in our repository. Please try again with less specific search terms.',

	/**
	 * What's new
	 */

	'plugins:front:intro:whatsnew' => 'Co nowego?',
	'plugins:front:intro:whatsnew:text' => 'You can now search and browse plugins more effectively than ever before. Use the right column block to filter plugins based on categories, Elgg version compatibility and more. Sort results by download counts, recommendations, authors and other properties.',

	/**
	 * Search settings
	 */

	'plugins:settings:sort:label'	=> "Włącz sortowanie listy wtyczek",
	'plugins:settings:filter:multiple:label'	=> "Allow using multiple filters in a single search",
	'plugins:settings:filter:category:label'	=> "Włącz filtrowanie oparte o kategorie wtyczek",
	'plugins:settings:filter:category:multiple'	=> "Allow multiple category selection",
	'plugins:settings:filter:version:label'	=> "Włącz filtrowanie oparte o zgodność z wersją Elgg",
	'plugins:settings:filter:version:multiple'	=> "Allow multiple version selection",
	'plugins:settings:filter:licence:label'	=> "Włącz filtrowanie oparte o rodzaj licencji",
	'plugins:settings:filter:licence:multiple'	=> "Allow multiple licence type selection",
	'plugins:settings:filter:text:label'	=> "Włącz filtrowanie oparte o dowolny tekst (domyślnie uwzględnia tytuł i opis)",
	'plugins:settings:filter:text:author:name'	=> "Uwzględniaj także wyświetlaną nazwę autora",
	'plugins:settings:filter:text:author:username'	=> "Uwzględniaj także nazwę użytkownika autora",
	'plugins:settings:filter:text:summary'	=> "Uwzględniaj także podsumowanie wtyczek",
	'plugins:settings:filter:text:tags'	=> "Uwzględniaj także znaczniki wtyczek",
	'plugins:settings:filter:screenshot:label'	=> "Włącz filtrowanie oparte o dostępność zrzutu ekranu",


	'plugins:settings:save:success'	=> "Plugin search settings were successfully updated",
	'plugins:settings:save:failure'	=> "Could not save plugin search settings: unrecognized parameters received.",

	'plugins:filters:or' => '... lub',
	
	'plugins:placeholder:categories' => "Wybierz kategorie",
	'plugins:placeholder:versions' => "Wybierz wersje Elgg",
	'plugins:placeholder:licences' => "Wybierz licencje",
	'plugins:placeholder:keyword' => "Filter by keyword",


	'river:comment:object:plugin_release' => '%s skomentował wtyczkę %s',
	'river:comment:object:plugin_project' => '%s skomentował wtyczkę %s',
	'river:create:object:plugin_project' => "%s przesłał nową wtyczkę: %s",
	'river:create:object:plugin_release' => "%s wydał nową wersję wtyczki %s",

	/* Edit Form */
	'plugins:edit:helptext' => "You are editing the plugin project information for %s.  To upload a new release click %s.",
	'plugins:add:helptext' => "You are creating a new plugin project. If you want to release a new
	version of an existing plugin, go to the edit section of that plugin's project page. You can view all of your plugins %s",
	'plugins:edit:label:name' => "Nazwa projektu",
	'plugins:edit:label:project_summary' => 'Streszczenie projektu',
	'plugins:edit:help:project_summary' => "A one- or two-sentence (250 characters) summary of your project's main features.",
	'plugins:edit:label:description' => "Opis projektu",
	'plugins:edit:help:description' => "A full description of your project's features. (As per %s, images and links will be removed.)",
	'plugins:edit:label:plugin_type' => "Typ projektu",
	'plugins:edit:label:project_homepage' => "Strona domowa projektu",
	'plugins:edit:label:donate' => "URL dotacji",
	'plugins:edit:help:donate' => "If you accept donations, enter the URL to the donations section of your website.",
	'plugins:edit:help:tags' => "A comma-separated list of tags relevant to your project.",
	'plugins:edit:help:access' => "The access level of the project. Note that individual releases can have their own access settings.",
	'plugins:edit:recommended:none' => 'Brak rekomendowanych wydań',
	'plugins:edit:label:project_images' => "Obrazy projektu",
	'plugins:edit:help:project_images' => "Pokaż swój projekt poprzez wysłanie obrazów!",
	'plugins:edit:image' => "Obraz",
	'plugins:edit:help:release' => "This information is specific to the release you are uploading right now.  To edit the
general project details, visit the edit section of the project page.",
	'plugins:edit:help:file' => 'This information is specific to the release you are uploading right now.  To edit the
general project details, visit the edit section of the project page.',
	'plugins:edit:label:release_version' => "Wersja wydania",
	'plugins:edit:label:release_notes' => "Notki wydania",
	'plugins:edit:help:release_notes' => "A list of changes, bugfixes, bugs, todos, and general release notes for this release. (As per %s, images and links will be removed.)",
	'plugins:edit:label:elgg_version' => "Kompatybilność Elgg",
	'plugins:edit:help:elgg_version' => "The version of Elgg this plugin was developed and tested on",
	'plugins:edit:label:comments' => "Pozwól komentować",
	'plugins:edit:help:access' => "The access level of the project. Note that individual releases can have their own access settings.",
	'plugins:edit:label:recommended' => "Ustaw jako rekomendowane wydanie",
	'plugins:edit:help:recommended' => "Recommend all users of this plugin use this release?",
	'plugins:link:here' => 'tutaj',

	/**
	 * Misc
	 */
	 'plugins:warning:page:all:bookmark' => 'Please update your bookmark or report this link to the site owner as this page has moved.',
	 'plugins:error:invalid_release' => "We could not find the release you specified.",
	 'plugins:forward:recommended_release' => "Forwarded to recommended release.",
	 'plugins:error:unrecognized_plugin' => "Nie rozpoznajemy tego pluginu",

	/**
	 *	Actions
	 */
	'plugins:action:combine:invalid_guids' => 'The GUIDs must be for 2 plugin projects',
	'plugins:action:combine:success' => "%s has been combined into the project %s",
	'plugins:action:normalize:invalid_guid' => "Nie określono GUID",
	'plugins:action:normalize:notpreview' => "Normalized downloads removing %s annotations",
	'plugins:action:normalize:preview' => "Would have removed %s annotations using a max of %s",
	'plugins:action:invalid_project' => 'Niepoprawny projekt',
	'plugins:action:transfer:invalid_recipient' => 'Invalid Recipient',
	'plugins:action:transfer:success' => 'Plugin ownership has been transferred.',
	'plugins:action:upgrade:not_required' => 'Brak wymaganej aktualizacji.',
	'plugins:action:upgrade:success' => "The community plugin repository has been upgraded",
	'plugins:action:invalid_contributors' => 'Nieprawidłowi współpracownicy',
	'plugins:action:add_contributors:success' => 'Współpracownicy zostali dodani.',
	'plugins:action:invalid_user' => "Niepoprawny użytkownik",
	'plugins:action:delete_contributor:success' => 'User has been removed from the contributors list',
	'plugins:action:invalid_access' => 'Unknown or insufficient access to release',
	'plugins:action:transfer:not_moved' => "Release ID: %s - the file could not be moved on the file system",
);
