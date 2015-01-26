<?php
/**
 * Elgg community plugin repository language pack
 */

return array(
	/**
	 * Administration area
	 */

	'admin:community_plugins' => 'Plugin-Sammlung',
	'admin:community_plugins:statistics' => 'Statistiken',
	'admin:community_plugins:upgrade' => 'Aktualisieren',
	'admin:community_plugins:utilities' => 'Werkzeuge',
	'admin:settings:community_plugins' => 'Plugin-Sammlung',
	'plugins:admin:trends:title' => 'Plugin-Downloadtrends',
	'plugins:admin:trends:help' => "Anzeige der Downloads der letzten 30 Tage. Um die Downloads eines bestimmten Plugins zu sehen, gebe die GUID dieses Plugin-Projektes ein:",
	'plugins:admin:trends:single' => "Statistiken für %s",
	'plugins:admin:trends:all' => "Statistiken für alle Plugins",
	'plugins:admin:upgrade:required' => "Für dieses Plugin ist eine Aktualisierung erforderlich.",
	'plugins:admin:upgrade:ok' => "Keine Aktualisierung erforderlich.",
	'plugins:admin:utilities:combine' => 'Plugin-Projekte zusammenführen',
	'plugins:admin:combine:old_guid' => 'GUID des Plugin-Projektes, das bei der Zusammenführung entfernt werden soll:',
	'plugins:admin:combine:new_guid' => 'GUID des Plugin-Projektes, das bei der Zusammenführung bestehen bleiben soll:',
	'plugins:admin:normalize:help' => 'Überhöhten Download-Zähler für das momentan angezeigte Plugin korrigieren',
	'plugins:admin:transfer:title' => "Eigentümerschaft des Plugins auf einen anderen Benutzer übertragen",
	'plugins:admin:transfer:help' => 'Gebe den Anfang des Namens des Benutzers ein, auf den die Eigentümerschaft des Plugins übertragen werden soll, und wähle ihn dann aus der Liste aus. Wähle nur einen Benutzer aus. Wenn mehr als ein Benutzer ausgewählt wird, wird die Eigentümerschaft auf den ersten in der Liste ausgewählten Benutzer übertragen.',
	'plugins:admin:contributors:title' => "Benutzer als Mitwirkende bei diesem Plugin anzeigen",
	'plugins:admin:contributors:help' => "Das Hinzufügen von Benutzern als Mitwirkende gibt diesen <b>keine</b> speziellen Bearbeitungsrechte für die jeweilige Plugin-Seite, sondern zeigt sie nur als Mitwirkende bei diesem Plugin an. Dies ist eine Möglichkeit, Community-Mitglieder für ihre Mithilfe bei der Entwicklung eines Plugins (z.B. Melden von Bugs, Einreichung von Fehlerkorrekturen oder Verbesserung des Funktionsumfangs) zu würdigen. Gebe den Anfang des Namens eines Mitwirkenden ein und wähle den Benutzer dann aus der Liste aus. Du kannst so viele Benutzer auswählen, wie Du willst.",


	/**
	 *	Object views
	 */
	'plugins:uploadtime' => "Hochgeladen %s (%s)",
	'plugins:updatedtime' => "Updated %s (%s)",
	'plugins:release:version_warning' => 'Warnung: Der Plugin-Entwickler empfiehlt eine andere Version dieses Plugins! Möchtest Du trotzdem diese Version herunterladen?',
	'plugins:download:version' => "Herunterladen %s",
	'plugins:project:title:version' => "%s für Elgg %s",
	'plugins:author:byline' => "von %s",
	'plugins:last:updated' => "Zuletzt aktualisiert: %s",

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

	'plugins' => "Plugins",
	'pluginss' => "Plugins",

	'plugins:new' => "Neues Plugin",

	'plugins:types:' => "Plugins, Themes und Sprachpakete",
	'plugins:types:plugin' => "Plugins",
	'plugins:types:theme' => "Themes",
	'plugins:types:languagepack' => "Sprachpakete",

	'plugins:yours' => "Deine %s",
	'plugins:user' => "%ss %s",

	'plugins:admin' => "Verwaltung der Plugin-Sammlung",
	'plugins:admin:menu' => "Verwalten der Plugin-Sammlung",

	'plugins:yours:friends' => "Plugins, Themes und Sprachpakete Deiner Freunde",
	'plugins:friends' => "Plugins, Themes und Sprachpakete der Freunde von %s",
	'plugins:all' => "Alle Plugins, Themes und Sprachpakete",
	'plugins:category:title' => "Plugins in Kategorie: %s",
	'plugins:search:title' => "Plugin-Suche nach \"%s\" in der Kategorie: %s",


	'plugins:cat:all' => 'Alle',

	'plugins:listing:newest' => 'Neueste',
	'plugins:listing:popular' => 'Meiste Downloads',
	'plugins:listing:dugg' => 'Meiste Empfehlungen',


	'plugins:upload:new' => "Ein neues Plugin hochladen",


	'plugins:search:instruct' => 'Suche nach Plugins',
	'plugins:search:choose' => 'Wähle eine Kategorie',


	'plugins:front:welcome' => "Willkommen in der Plugin-Sammlung von Elgg",
	'plugins:front:intro:title' => "Was sind Plugins?",
	'plugins:front:intro:text' => "Plugins verbessern den Funktionsumfang Deiner Elgg-Seite, bieten Übersetzungen oder ein Seiten-Theme. Die Plugins werden von Mitgliedern der Elgg-Community entwickelt und zur Verfügung gestellt. <br><br> Du kannst die Plugin-Sammlung frei durchstöbern oder auch gezielt nach einem bestimmten Plugin suchen. Du kannst ein neues, eigenes Plugin hochladen oder bei Plugins Kommentare hinterlassen und sie empfehlen.",




	'plugins:more' => "weitere Plugins, Themes und Sprachpakete",
	'plugins:list' => "Listen-Ansicht",
	'plugins:group' => "Gruppiere Plugins, Themes und Sprachpakete",
	'plugins:gallery' => "Gallerie-Ansicht",
	'plugins:gallery_list' => "Gallerie- oder Listen-Ansicht",
	'plugins:num_files' => "Anzahl der anzuzeigenden Plugins, Themes und Sprachpakete",
	'plugins:yes' => 'Ja',
	'plugins:no' => 'Nein',
	'plugins:num_plugins and themes' => "Anzahl der anzuzeigenden Plugins, Themes und Sprachpakete",

	'plugins:new:project' => "Neues Plugin hochladen",
	'plugins:new:release' => "Neue Version hochladen",

	'plugins:edit' => "Bearbeiten",
	'plugins:edit:project' => "Projekt-Beschreibung bearbeiten",
	'plugins:edit:release' => "Plugin-Version bearbeiten",
	'plugins:contributors:add' => "Mitwirkende hinzufügen",
	'plugins:delete:project' => "Projekt löschen",
	'plugins:requests:ownership' => "Pending ownership requests",
	'plugins:transfer:ownership' => "Eigentümerschaft übertragen",
	'plugins:author:homepage' => "Homepage des Entwicklers",
	'plugins:author:recommended' => "Empfehlungen des Entwicklers",
	'plugins:project:page:view' => "Project Page",

	'plugins:elggversion' => "Elgg-Version(en), für die dieses Plugin geeignet ist",
	'plugins:elgg_version' => "Elgg-Version",
	'plugins:version' => "Plugin-Version",
	'plugins:updated' => "Aktualisiert",
	'plugins:repo' => "Code-Repository",
	'plugins:homepage' => "Plugin-/Projekt-Homepage",
	'plugins:category' => "Kategorie",
	'plugins:categories' => "Kategorien",
	'plugins:myplugins' => "Deine Plugins",
	'plugins:All' => "Alle",
	'plugins:file' => 'Datei zum Hochladen',
	'plugins:donate' => 'Spenden',
	'plugins:file:uploadagain' => 'Neue Version hochladen',
	'plugins:version' => 'Plugin-Version',
	'plugins:downloads' => "Downloads",
	'plugins:recommendations' => "Empfehlungen",
	'plugins:upload' => "Neues Plugin, Theme oder Sprachpaket hochladen",
	'plugins:changelog' => "Änderungshistorie",
	'plugins:noproject' => "Entschuldigung, das Plugin-Projekt, das Du aktualisieren möchtest, konnte nicht gefunden werden.",
	'plugins:plugin or theme' => "Datei",
	'plugins:updated' => "Aktualisiert",
	'plugins:update' => "Neue Version dieses Plugins hochladen",
	'plugins:title' => "Titel",
	'plugins:desc' => "Beschreibung",
	'plugins:tags' => "Tags",
	'plugins:notfound' => "The requested plugin cannot be found, please try a search",

	'plugins:plugin_type' => 'Art des Plugins?',
	'plugins:plugin' => 'Plugin',
	'plugins:theme' => 'Theme',
	'plugins:languagepack' => 'Sprachpaket',

	'plugins:user:plugin' => "Plugins von %s anzeigen",
	'plugins:user:theme' => "Themes von %s anzeigen",
	'plugins:user:languagepack' => "Sprachpakete von %s anzeigen",

	'plugins:types' => "Hochgeladene Plugins, Themes und Sprachpakete",

	'plugins:type:all' => "Elgg-Plugins",
	'plugins:type:plugin' => 'Plugins',
	'plugins:type:theme' => 'Themes',
	'plugins:type:languagepack' => 'Sprachpakete',
	'plugins:user:type:languagepack' => "Sprachpakete von %s",
	'plugins:user:type:general' => "Gewöhnliche Plugins und Themes von %s",
	'plugins:widget' => "Plugin-Widget",
	'plugins:widget:description' => "Stelle Deine neuesten Plugins, Themes und Sprachpakete vor.",

	'plugins:download' => "Herunterladen",

	'plugins:delete_release:confirm' => "Bist Du sicher, dass Du diese Version löschen willst?",
	'plugins:delete_project:confirm' => 'Dieses Projekt mit all seinen Versionen wird gelöscht. Bist Du sicher, dass Du dieses Projekt löschen willst?',
	'plugins:delete_project_image:confirm' => 'Bild löschen?',
	'plugins:tagcloud' => "Tagcloud",
	'plugins:diggit' => "Du hast dieses Plugin empfohlen.",
	'plugins:display:number' => "Anzahl der anzuzeigenden Plugins, Themes und Sprachpakete",

	'plugins:files:acceptable' => 'Das Plugin kann nur als komprimierte zip- oder tar.zip-Datei hochgeladen werden.',

	'item:object:plugin_project' => 'Plugin-Projekte',
	'item:object:plugin_release' => 'Plugin-Versionen',
	'item:object:file' => 'Plugin-Bildschirmphotos',

	'plugins:tabs:stats' => 'Statistiken',
	'plugins:tabs:upgrade' => 'Aktualisierungen',
	'plugins:tabs:utilities' => 'Werkzeuge',
	'plugins:tabs:search' => 'Such-Einstellungen',
	'plugins:matching' => 'Gefundene Plugins',
	'plugins:add:contributor' => "Mitwirkende hinzufügen: %s",
	'plugins:title:transfer_plugin' => "Eigentümerschaft des Plugins übertragen: %s",
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
	'plugins:plugin_project:notify:subject' => '%s hat ein neues Plugin namens %s veröffentlicht',
	'plugins:plugin_release:notify:subject' => '%s hat eine neue Version des Plugins %s veröffentlicht',
	'plugins:plugin_project:notify:body' => "%s hat ein neues Plugin namens %s veröffentlicht \n\n %s \n\n %s",
	'plugins:plugin_release:notify:body' => "%s hat eine neue Version des Plugins %s veröffentlicht \n\n %s \n\n %s",
	'plugins:plugin_project:notify:summary' => 'Neues Plugin-Projekt namens %s',
	'plugins:plugin_release:notify:summary' => 'New release of the plugin %s',

	'plugins:ownership_request:notify:subject' => 'A new plugin ownership request',
	'plugins:ownership_request:notify:body' => "There's a new plugin ownership request:
%s",

	/**
	 * Licenses
	 */
	'license' => 'Lizenz',
	'license:none' => 'Keine Lizenz ausgewählt',
	'license:blurb' => 'Dein Plugin oder Theme muss unter einer zur GPL Version 2 kompatiblen Lizenz veröffentlicht werden. Bitte wähle die passende Lizenz aus der Liste aus oder klicke hier für weitere Informationen.',
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

	'plugins:project:saved' => "Das Plugin-Projekt wurde gespeichert.",
	'plugins:release:saved' => "Die Plugin-Version wurde gespeichert.",
	'plugins:project:deleted' => "Das Plugin-Projekt wurde gelöscht.",
	'plugins:release:deleted' => "Die Plugin-Version wurde gelöscht.",
	'plugins:ownership_request:success' => "Ownership request has been sent",

	/**
	 * Error messages
	 */

	'plugins:none' => "Es konnten keine Plugins, Themes oder Sprachpakete gefunden werden.",
	'plugins:error:deletefailed' => "Dein Plugin oder Theme konnte nicht gelöscht werden.",
	'plugins:error:permissions' => 'Es ist ein Problem aufgrund nicht ausreichender Berechtigungen aufgetreten.',
	'plugins:error:downloadfailed' => "Das Herunterladen ist fehlgeschlagen.",
	'plugins:error:uploadfailed' => "Entschuldigung; das Speichern Deines Plugins, Themes oder Sprachpakets ist fehlgeschlagen.",
	'plugins:error:badformat' => 'Das Plugin kann nur als komprimierte zip- oder tar.zip-Datei hochgeladen werden.',
	'plugins:error:badlicense' => 'Du mußt eine GPL-kompatible Lizenz auswählen.',
	'plugins:error:notitle' => 'Die Eingabe eines Titels ist erforderlich.',
	'plugins:error:no_version' => 'Die Eingabe einer Versionsangabe ist erforderlich.',
	'plugins:error:no_elgg_version' => 'Die Angabe der Elgg-Version, für die dieses Plugin gedacht ist, ist erforderlich',
	'plugins:error:duplicate_version' => 'Diese Versionsbezeichnung wird für dieses Plugin-Projekt schon verwendet.',
	'plugins:error:not_found' => 'The plugin project was not found',
	'plugins:error:invalid_ownership_request' => 'The description is a required field',
	'plugins:error:ownership_request_failed' => 'The ownership request failed',
	'plugins:error:ownership_request_exists' => 'You already have a pending ownership request',

	/**
	 * New frontpage
	 **/

	'plugins:search' => "Plugins suchen",
	'plugins:stats' => "Download-Statistiken",
	'plugins:popular' => "Beliebteste",
	'plugins:popular:more' => "Zeige weitere beliebte Plugins...",
	'plugins:counter' => "%s Plugins mit einer Gesamtzahl von %s Downloads",


	'replace' => 'Ersetzen',
	"unknown:version" => 'Unbekannte Version',

	'plugins:prevversions' => "Vorherige Version",
	'plugins:nextversions' => "Warnung! Es ist eine neuere Version verfügbar.",

	'plugins:browse_more:newest' => "Neueste Plugins durchstöbern",
	'plugins:browse_more:popular' => "Plugins mit den meisten Downloads durchstöbern",
	'plugins:browse_more:dugg' => "Plugins mit den meisten Empfehlungen durchstöbern",


	/**
	 * Sort field labels
	 */

	'plugins:sort:info' => 'Sortieren nach:',
	'plugins:sort:title' => 'Titel',
	'plugins:sort:author' => 'Entwickler',
	'plugins:sort:downloads' => 'Downloads',
	'plugins:sort:recommendations' => 'Empfehlungen',
	'plugins:sort:created' => 'Erstveröffentlichungsdatum',
	'plugins:sort:updated' => 'Zuletzt aktualisiert',


	/**
	 * Filters
	 */

	'plugins:filters:title' => 'Pluginsuche basierend auf...',
	'plugins:filters:category' => 'Kategorie',
	'plugins:filters:version' => 'Elgg-Version',
	'plugins:filters:licence' => 'Lizenz',
	'plugins:filters:text' => 'Beliebiger Suchbegriff',
	'plugins:filters:screenshot:label' => 'Bildschirmphotos',
	'plugins:filters:screenshot' => 'Nur mit Bildschirmphotos',

	/**
	 * Search labels
	 */

	'plugins:search:title' => 'Plugin-Suche nach \"%s\" in der Kategorie: %s',
	'plugins:search:results' => '%d Plugins gefunden. Anzeige der Treffer %d bis %d',
	'plugins:search:noresults' => 'Es wurden keine passenden Plugins gefunden.',
	'plugins:search:noresults:info' => 'In der Plugin-Sammlung wurden keine Plugins gefunden, die Deinen Suchkriterien entsprechen. Bitte versuche es noch einmal mit einer weniger spezifischen Suche.',

	/**
	 * What's new
	 */

	'plugins:front:intro:whatsnew' => 'Was gibt\'s neues?',
	'plugins:front:intro:whatsnew:text' => 'Du kannst die Plugin-Sammlung nun einfacher durchstöbern und effektiver durchsuchen als jemals zuvor. Verwende die Filter in der rechten Spalte, um Dir nur Plugins einer bestimmten Kategorie, für eine bestimmte Elgg-Version oder passend zu anderen Kriterien anzeigen zu lassen. Die Plugins kannst Du sortiert nach Anzahl der Downloads, Anzahl der Empfehlungen, Entwickler des Plugins und weiteren Kriterien anzeigen lassen.',

	/**
	 * Search settings
	 */

	'plugins:settings:sort:label'	=> "Sortieren der Pluginliste erlauben",
	'plugins:settings:filter:multiple:label'	=> "Mehrere Filterkriterien bei einer Pluginsuche erlauben",
	'plugins:settings:filter:category:label'	=> "Filtern nach Kategorie erlauben",
	'plugins:settings:filter:category:multiple'	=> "Auwahl mehrerer Kategorien bei einer Pluginsuche erlauben",
	'plugins:settings:filter:version:label'	=> "Filtern nach Elgg-Version erlauben",
	'plugins:settings:filter:version:multiple'	=> "Auswahl mehrerer Elgg-Version bei einer Pluginsuche erlauben",
	'plugins:settings:filter:licence:label'	=> "Filtern nach Lizenz der Plugins erlauben",
	'plugins:settings:filter:licence:multiple'	=> "Auswahl mehrerer Lizenzen bei einer Pluginsuche erlauben",
	'plugins:settings:filter:text:label'	=> "Filtern nach beliebigen Suchbegriffen erlauben (standardmäßig wird nach Übereinstimmung mit Plugin-Titel und -Entwickler gesucht)",
	'plugins:settings:filter:text:author:name'	=> "Zusätzlich auch nach Übereinstimmung mit dem Displaynamen des Entwicklers suchen",
	'plugins:settings:filter:text:author:username'	=> "Zusätzlich auch nach Übereinstimmung mit dem Benutzernamen des Entwicklers suchen",
	'plugins:settings:filter:text:summary'	=> "Zusätzlich auch nach Übereinstimmungen in den Zusammenfassungen der Plugins suchen",
	'plugins:settings:filter:text:tags'	=> "Zusätzlich auch nach Übereinstimmungen in den Tags der Plugins suchen",
	'plugins:settings:filter:screenshot:label'	=> "Filtern nach Verfügbarkeit von Bildschirmphotos erlauben",


	'plugins:settings:save:success'	=> "Die Konfiguration der bei der Suche nach Plugins verfügbaren Kriterien wurde gespeichert.",
	'plugins:settings:save:failure'	=> "Die Konfiguration der Pluginsuche konnte nicht gespeichert werden: es wurde ein unbekannter Parameter übergeben.",

	'plugins:filters:or' => '...oder ',
	
	'plugins:placeholder:categories' => "Choose categories",
	'plugins:placeholder:versions' => "Choose Elgg versions",
	'plugins:placeholder:licences' => "Choose licenses",
	'plugins:placeholder:keyword' => "Filter by keyword",


	'river:comment:object:plugin_release' => '%s schrieb einen Kommentar zum Plugin %s',
	'river:comment:object:plugin_project' => '%s schrieb einen Kommentar zum Plugin %s',
	'river:create:object:plugin_project' => "%s hat ein neues Plugin veröffentlicht: %s",
	'river:create:object:plugin_release' => "%s hat eine neue Version des Plugins %s veröffentlicht",

	/* Edit Form */
	'plugins:edit:helptext' => "Du bearbeitest momentan die Pluginbeschreibung des Plugin-Projektes %s. Um eine neue Version hochzuladen klicke %s.",
	'plugins:add:helptext' => "Du bist im Begriff, ein neues Plugin-Projekt hinzuzufügen. Wenn Du eigentlich eine neue Version für eines Deiner schon existierenden Plugin-Projekte hochladen willst, rufe die Bearbeitungsseite dieses Plugin-Projektes auf. Du findest all Deine Plugin-Projekte %s.",
	'plugins:edit:label:name' => "Name des Projekts",
	'plugins:edit:label:project_summary' => 'Zusammenfassung',
	'plugins:edit:help:project_summary' => "Fasse in ein oder zwei Sätzen (250 Zeichen) kurz die Hauptmerkmale Deines Plugin-Projektes zusammen.",
	'plugins:edit:label:description' => "Beschreibung",
	'plugins:edit:help:description' => "Eine ausführliche Beschreibung Deines Plugin-Projektes. (Gemäß %s werden Bilder und Links aus der Beschreibung entfernt.)",
	'plugins:edit:label:plugin_type' => "Art des Plugin-Projektes",
	'plugins:edit:label:project_homepage' => "Projekt-Homepage",
	'plugins:edit:label:donate' => "URL für Spenden",
	'plugins:edit:help:donate' => "Wenn Du Spenden akzeptierst, gebe die URL der Spenden-Seite auf Deiner Webseite an.",
	'plugins:edit:help:tags' => "Eine Liste relevanter (durch Kommas getrennter) Tags für Dein Plugin-Projekt.",
	'plugins:edit:help:access' => "Der Zugangslevel für das Plugin-Projekt (für jede Version, die Du hochlädst, kannst Du einen individuellen Zugangslevel festlegen).",
	'plugins:edit:recommended:none' => 'Der Entwickler hat keine Versions des Plugins besonders empfohlen.',
	'plugins:edit:label:project_images' => "Bildschirmphotos",
	'plugins:edit:help:project_images' => "Stelle Dein Plugin-Projekt mit Hilfe von Bildschirmphotos noch besser vor!",
	'plugins:edit:image' => "Bildschirmphotos",
	'plugins:edit:help:release' => "Diese Informationen sind spezifisch für die Plugin-Version, die Du gerade im Begriff bist hochzuladen. Um die allgemeinen Informationen dieses Plugin-Projektes zu bearbeiten, gehe zur Bearbeitungsseite dieses Plugin-Projektes.",
	'plugins:edit:help:file' => 'Diese Informationen sind spezifisch für die Plugin-Version, die Du gerade im Begriff bist hochzuladen. Um die allgemeinen Informationen dieses Plugin-Projektes zu bearbeiten, gehe zur Bearbeitungsseite dieses Plugin-Projektes.',
	'plugins:edit:label:release_version' => "Versionsnummer",
	'plugins:edit:label:release_notes' => "Versionshinweise",
	'plugins:edit:help:release_notes' => "Eine Liste von Änderungen, Fehlerkorrekturen, bekannten Problemen, eventuell geplanter zukünftiger Änderungen und allgemeiner Versionshinweise spezifisch für diese Version. (Gemäß %s werden Bilder und Links aus der Beschreibung entfernt.)",
	'plugins:edit:label:elgg_version' => "Kompatibilität zu Elgg",
	'plugins:edit:help:elgg_version' => "Die Version(en) von Elgg für die diese Plugin-Version entwickelt wurde und auf der sie getestet wurde.",
	'plugins:edit:label:comments' => "Kommentare erlauben",
	'plugins:edit:help:access' => "Der Zugangslevel für das Plugin-Projekt (für jede Version, die Du hochlädst, kannst Du einen individuellen Zugangslevel festlegen).",
	'plugins:edit:label:recommended' => "Als empfohlene Version kennzeichnen",
	'plugins:edit:help:recommended' => "Allen Anwendern dieses Plugins die Verwendung dieser Version empfehlen?",
	'plugins:link:here' => 'hier',

	/**
	 * Misc
	 */
	 'plugins:warning:page:all:bookmark' => 'Bitte aktualisiere Dein Lesezeichen oder melde den Link, dem Du eventuell gefolgt bist, dem zuständigen Seitenadministrator, da diese Seite nun unter einer anderen URL verfügbar ist.',
	 'plugins:error:invalid_release' => "Die gewünschte Plugin-Version konnte nicht gefunden werden.",
	 'plugins:forward:recommended_release' => "Weitergeleitet zur empfohlenen Plugin-Version.",
	 'plugins:error:unrecognized_plugin' => "Dieses Plugin ist unbekannt.",

	/**
	 *	Actions
	 */
	'plugins:action:combine:invalid_guids' => 'Die angegebenen GUIDs müssen zu zwei existierenden Plugin-Projekten passen.',
	'plugins:action:combine:success' => "%s wurde mit dem Plugin-Projekt %s zusammengeführt.",
	'plugins:action:normalize:invalid_guid' => "Es wurde keine GUID angegeben.",
	'plugins:action:normalize:notpreview' => "Der Download-Zähler wurde korrigiert. Es wurden %s Annotations entfernt.",
	'plugins:action:normalize:preview' => "Es wären %s Annotations entfernt worden unter Verwendung eines Maximums von %s.",
	'plugins:action:invalid_project' => 'Ungültiges Plugin-Projekt.',
	'plugins:action:transfer:invalid_recipient' => 'Ungültigen Benutzer als neuen Eigentümer angegeben.',
	'plugins:action:transfer:success' => 'Die Eigentümerschaft des Plugin-Projektes wurde erfolgreich übertragen.',
	'plugins:action:upgrade:not_required' => 'Es ist keine Aktualisierung notwendig.',
	'plugins:action:upgrade:success' => "Das Community-Plugins-Plugin wurde erfolgreich aktualisiert.",
	'plugins:action:invalid_contributors' => 'Ungültigen Benutzer als neuen Mitwirkenden angegeben.',
	'plugins:action:add_contributors:success' => 'Die Mitwirkenden wurden hinzugefügt.',
	'plugins:action:invalid_user' => "Ungültiger Benutzer",
	'plugins:action:delete_contributor:success' => 'Der Benutzer wurde aus der Liste der Mitwirkenden entfernt.',
	'plugins:action:invalid_access' => 'Unbekannter Zugangslevel oder nicht ausreichende Zugangsberechtigung für diese Plugin-Version.',
	'plugins:action:transfer:not_moved' => "Release ID: %s - the file could not be moved on the file system",
);
