<?php
/**
 * Elgg community plugin repository language pack
 */

return array(
	/**
	 * Administration area
	 */

	'admin:community_plugins' => 'Lista di plugin',
	'admin:community_plugins:statistics' => 'Statistiche',
	'admin:community_plugins:upgrade' => 'Aggiorna',
	'admin:community_plugins:utilities' => 'Utilità',
	'admin:settings:community_plugins' => 'Lista di plugin',
	'plugins:admin:trends:title' => 'Andamento dei plugin in base ai download',
	'plugins:admin:trends:help' => "Questo mostra i download dei 30 giorni scorsi. Per vedere i download per un particolare plugin, inserire il GUID del progetto del plugin al di sotto.",
	'plugins:admin:trends:single' => "Statistiche per %s",
	'plugins:admin:trends:all' => "Statistiche per tutti i plugin",
	'plugins:admin:upgrade:required' => "È necessario un aggiornamento per questo plugin.",
	'plugins:admin:upgrade:ok' => "Nessun aggiornamento richiesto.",
	'plugins:admin:utilities:combine' => 'Unisci i progetti del plugin',
	'plugins:admin:combine:old_guid' => 'Il GUID del progetto del plugin è cambiato in seguito all\'unione',
	'plugins:admin:combine:new_guid' => 'Il GUID del progetto del plugin è rimasto tale in seguito all\'unione',
	'plugins:admin:normalize:help' => 'Rimuovi i download "gonfiati" per il grafico del plugin',
	'plugins:admin:transfer:title' => "Cambia la proprietà del plugin ad un altro utente.",
	'plugins:admin:transfer:help' => 'Inizia scrivendo il nome dell\'utente al quale vorresti trasferire la proprietà del plugin e selezionalo dalla lista.
⇥Seleziona un utente,se ne hai selezionato più di uno, solo il primo utente riceverà la proprietà del plugin.',
	'plugins:admin:contributors:title' => "Lista dei collaboratori per questo plugin",
	'plugins:admin:contributors:help' => "Aggiungendo utenti come collaboratori <b>non</b>  gli dai speciali privilegi per quanto riguardo la pagina del plugin, però li aggiunge nella lista dei membri collaboratori.
⇥⇥Questo è un modo per diconoscere i membri della comunità grazie al loro lavoro di segnalazione dei bug, rilascio di patch e miglioramenti.
⇥⇥Inizia digitando il nome dell'utente che ha contribuito al plugin. Puoi selezionare molti utenti se necessario.",


	/**
	 *	Object views
	 */
	'plugins:uploadtime' => "Caticato %s (%s)",
	'plugins:updatedtime' => "Updated %s (%s)",
	'plugins:release:version_warning' => 'Attenzione: L\'autore consiglia di utilizzare una diversa versione di questo plugin! Vuoi ancora scaricare questa versione?',
	'plugins:download:version' => "%s Download",
	'plugins:project:title:version' => "%s per Elgg %s",
	'plugins:author:byline' => "per %s",
	'plugins:last:updated' => "Ultimo aggiornamento %s",

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

	'plugins' => "Plugin",
	'pluginss' => "Plugin",

	'plugins:new' => "Nuovo plugin",

	'plugins:types:' => "plugins, temi e pacchetti di lingua",
	'plugins:types:plugin' => "plugins",
	'plugins:types:theme' => "temi",
	'plugins:types:languagepack' => "pacchetti di linguaggio",

	'plugins:yours' => "Il tuo %s",
	'plugins:user' => "%s's %s",

	'plugins:admin' => "Amministrazione repository dei plugin",
	'plugins:admin:menu' => "Lista di plugin Admin",

	'plugins:yours:friends' => "I plugin. i temi e i pacchetti di lingua dei tuoi amici",
	'plugins:friends' => "%s plugin, temi e pacchetti di lingua di amici",
	'plugins:all' => "Tutti i siti di plugins, temi e pacchetti di lingua",
	'plugins:category:title' => "Plugin per categoria: %s",
	'plugins:search:title' => "Cerca plugin per \"%s\" nella categoria: %s",


	'plugins:cat:all' => 'Tutto',

	'plugins:listing:newest' => 'I più nuovi',
	'plugins:listing:popular' => 'Più scaricato',
	'plugins:listing:dugg' => 'Più raccomandato',


	'plugins:upload:new' => "Carica un nuovo plugin",


	'plugins:search:instruct' => 'cerca un plugin',
	'plugins:search:choose' => 'scegli una categoria',


	'plugins:front:welcome' => "Benvenuto nell'elenco dei plugin Elgg",
	'plugins:front:intro:title' => "Cosa sono i plugins?",
	'plugins:front:intro:text' => "I plugin estendono le funzionalità del tuo sito Elgg, lingue e temi. Essi sono un contributo di membri della communità di Elgg.

⇥⇥Per iniziare potresti esplorare i plugin disponibili, cercare un plugin specifico, caricarne uno tuo, o votare e commentare gli altri plugin.",




	'plugins:more' => "più plugins, temi e pacchetti di lingua",
	'plugins:list' => "vedi lista",
	'plugins:group' => "Gruppo di plugins, temi e pacchetti di lingua",
	'plugins:gallery' => "vedi la galleria",
	'plugins:gallery_list' => "Galleria o lista",
	'plugins:num_files' => "Numero di plugin, temi e pacchetti linguistici da visualizzare",
	'plugins:yes' => 'Si',
	'plugins:no' => 'No',
	'plugins:num_plugins and themes' => "Numero di plugin, temi e pacchetti linguistici da visualizzare",

	'plugins:new:project' => "Carica un nuovo plugin",
	'plugins:new:release' => "Carica una nuova versione",

	'plugins:edit' => "Modifica",
	'plugins:edit:project' => "Modifica i dettagli del progetto",
	'plugins:edit:release' => "Modifica la versione del plugin",
	'plugins:contributors:add' => "Aggiungi collaboratori",
	'plugins:delete:project' => "Elimina progetto",
	'plugins:requests:ownership' => "Pending ownership requests",
	'plugins:transfer:ownership' => "Trasferimento della proprietà",
	'plugins:author:homepage' => "Pagina web dell'autore",
	'plugins:author:recommended' => "L'autore raccomanda",
	'plugins:project:page:view' => "Project Page",

	'plugins:elggversion' => "Versione(i) di Elgg dove questo plugin è stato testato",
	'plugins:elgg_version' => "Versione Elgg",
	'plugins:version' => "Versione del plugin",
	'plugins:updated' => "Aggiornato",
	'plugins:repo' => "Codice dell'archivio",
	'plugins:homepage' => "Pagina iniziale del Plugin/progetto",
	'plugins:category' => "Categoria",
	'plugins:categories' => "Categorie",
	'plugins:myplugins' => "I tuoi plugins",
	'plugins:All' => "Tutto",
	'plugins:file' => 'File da caricare',
	'plugins:donate' => 'Donazioni',
	'plugins:file:uploadagain' => 'Carica una nuova versione',
	'plugins:version' => 'Versione del plugin',
	'plugins:downloads' => "Downloads",
	'plugins:recommendations' => "Raccomandazioni",
	'plugins:upload' => "Carica un nuovo plugin,tema o pacchetto di lingua",
	'plugins:changelog' => "Novità",
	'plugins:noproject' => "Temo che il sistema non è stato in grado di trovare il progetto del plug-in che hai tentato di aggiornare",
	'plugins:plugin or theme' => "File",
	'plugins:updated' => "Aggiornato",
	'plugins:update' => "Carica una nuova versione di questo plugin",
	'plugins:title' => "Titolo",
	'plugins:desc' => "Descrizione",
	'plugins:tags' => "Tag",
	'plugins:notfound' => "The requested plugin cannot be found, please try a search",

	'plugins:plugin_type' => 'Tipo di plugin?',
	'plugins:plugin' => 'Plugin',
	'plugins:theme' => 'Tema',
	'plugins:languagepack' => 'Pacchetto di lingua',

	'plugins:user:plugin' => "Vedi i plugin di %s",
	'plugins:user:theme' => "Vedi i temi di %s",
	'plugins:user:languagepack' => "Vedi i pacchetti linguistici di %s",

	'plugins:types' => "Caricate le proprietà di plugins, temi o pacchetto di lingua",

	'plugins:type:all' => "Plugins Elgg",
	'plugins:type:plugin' => 'Plugin',
	'plugins:type:theme' => 'Temi',
	'plugins:type:languagepack' => 'Pacchetto linguistico',
	'plugins:user:type:languagepack' => "pacchetti di lingua di %s",
	'plugins:user:type:general' => "Plugins e temi di %s",
	'plugins:widget' => "Plugin widget",
	'plugins:widget:description' => "Mostra i tuoi ultimi plugin, temi e pacchetti di lingua",

	'plugins:download' => "Download",

	'plugins:delete_release:confirm' => "Sei sicuro di eliminare questa versione?",
	'plugins:delete_project:confirm' => 'Questo progetto e tutte le sue versioni verranno eliminati. Sei sicuro di eliminare questo progetto?',
	'plugins:delete_project_image:confirm' => 'Eliminare l\'immagine?',
	'plugins:tagcloud' => "Tag cloud",
	'plugins:diggit' => "Hai raccomandato questo plugin.",
	'plugins:display:number' => "Numero di plugin, temi e pacchetti linguistici da visualizzare",

	'plugins:files:acceptable' => 'I pacchetti di distribuzione devono essere .zip o .tar.zip',

	'item:object:plugin_project' => 'Progetti del plugin',
	'item:object:plugin_release' => 'Versioni del Plugin',
	'item:object:file' => 'Anteprime del Plugin',

	'plugins:tabs:stats' => 'Statistiche',
	'plugins:tabs:upgrade' => 'Aggiornamenti ',
	'plugins:tabs:utilities' => 'Utilità',
	'plugins:tabs:search' => 'Cerca impostazioni',
	'plugins:matching' => 'Plugin trovati',
	'plugins:add:contributor' => "Aggiungi collaboratori: %s",
	'plugins:title:transfer_plugin' => "Trasferisci plugin: %s",
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
	'plugins:plugin_project:notify:subject' => '%s ha caricato un nuovo plugin chiamato %s',
	'plugins:plugin_release:notify:subject' => '%s ha rilasciato una nuova versione del plugin %s',
	'plugins:plugin_project:notify:body' => "%s ha caricato un nuovo plugin chiamato %s \n\n %s \n\n %s",
	'plugins:plugin_release:notify:body' => "%s ha rilasciato una nuova versione del plugin %s \n\n %s \n\n %s",
	'plugins:plugin_project:notify:summary' => 'Il nuovo progetto del plugin chiamato %s',
	'plugins:plugin_release:notify:summary' => 'Nuova versione del plugin %s',

	'plugins:ownership_request:notify:subject' => 'A new plugin ownership request',
	'plugins:ownership_request:notify:body' => "There's a new plugin ownership request:
%s",

	/**
	 * Licenses
	 */
	'license' => 'Licenza',
	'license:none' => 'Nessuna licenza selezionata',
	'license:blurb' => 'Il tuo plugin o tema deve essere rilasciato con una licenza compatibile a quella GPL versione 2. Si prega di selezionare dalla lista qui sotto, oppure clicca qui per maggiori informazioni.',
	'license:gpl2' => 'GNU General Public License (GPL) versione 2',
	'license:gpl3' => 'GNU General Public License (GPL) versione 3',
	'license:lgpl3' => 'GNU Lesser General Public License (LGPL) versione 3',
	'license:lgpl2.1' => 'GNU Lesser General Public License (LGPL) versione 2.1',
	'license:agpl3' => 'GNU Affero General Public License (AGPL) versione 3',
	'license:apache' => 'Licenza Apache, Versione 2.0',
	'license:artistic' => 'Livenza artistica 2.0',
	'license:artistic' => 'Livenza artistica 2.0',
	'license:berkeleydb' => 'Berkeley Database License (conosciuto come the Sleepycat Software Product License)',
	'license:boost' => 'Boost Software License',
	'license:mbsd' => 'Licenza BSD modificata',
	'license:cbsd' => 'Licenza BSD "clear"',
	'license:cecill' => 'CeCILL versione 2',
	'license:cryptix' => 'Cryptix General License',
	'license:ecos' => 'eCos license versione 2.0',
	'license:edu' => 'Educational Community License 2.0',
	'license:eiffel' => 'Eiffel Forum License, versione 2',
	'license:eudatagrid' => 'EU DataGrid Software License',
	'license:expat' => 'Licenza Expat (MIT)',
	'license:freebsd' => 'Licenza FreeBSD',
	'license:freetype' => 'Freetype Project License',
	'license:jpeg' => 'Licenza Independent JPEG Group',
	'license:intel' => 'Licenza Intel Open Source',
	'license:openbsd' => 'Licenza ISC (OpenBSD)',
	'license:ncsa' => 'Licenza NCSA/University of Illinois Open Source',
	'license:public' => 'Dominio pubblico',
	'license:sgi' => 'SGI Free Software License B, versione 2.0',
	'license:w3c' => 'W3C Software Avvertenze and Licenza',
	'license:x11' => 'Licenza X11',
	'license:zope' => 'Zope Public License, versioni 2.0 e 2.1',

	/**
	 * Status messages
	 */

	'plugins:project:saved' => "Il plugin è stato salvato con successo.",
	'plugins:release:saved' => "La versione del plugin è stata salvata con successo.",
	'plugins:project:deleted' => "Il plugin è stato rimosso.",
	'plugins:release:deleted' => "La versione del plugin è stata rimossa.",
	'plugins:ownership_request:success' => "Ownership request has been sent",

	/**
	 * Error messages
	 */

	'plugins:none' => "Non abbiamo potuto trovare alcun plugin, temi o pacchetti di lingua al momento.",
	'plugins:error:deletefailed' => "Il tuo plugin o tema non è stato eliminato.",
	'plugins:error:permissions' => 'C\'è stato un errore di autorizzazioni.',
	'plugins:error:downloadfailed' => "Download fallito.",
	'plugins:error:uploadfailed' => "Ci dispiace; non abbiamo salvato i tuoi plugin, temi o pacchetto di lingua.",
	'plugins:error:badformat' => 'Sono concessi solo file .zip e .tar.gz',
	'plugins:error:badlicense' => 'Dovresti selezionare una licenza compatibile con la GPL.',
	'plugins:error:notitle' => 'È richiesto un titolo.',
	'plugins:error:no_version' => 'È necessaria una versione.',
	'plugins:error:no_elgg_version' => 'È necessaria una versione di Elgg',
	'plugins:error:duplicate_version' => 'Questa versione è già in uso per questo progetto',
	'plugins:error:not_found' => 'The plugin project was not found',
	'plugins:error:invalid_ownership_request' => 'The description is a required field',
	'plugins:error:ownership_request_failed' => 'The ownership request failed',
	'plugins:error:ownership_request_exists' => 'You already have a pending ownership request',

	/**
	 * New frontpage
	 **/

	'plugins:search' => "Cerca plugin",
	'plugins:stats' => "Statistiche dei download",
	'plugins:popular' => "Più popolare",
	'plugins:popular:more' => "Cerca altri plugin popolari",
	'plugins:counter' => "%s plugin con %s download totali",


	'replace' => 'Sostituisci',
	"unknown:version" => 'Versione sconosciuta',

	'plugins:prevversions' => "Versione precedente",
	'plugins:nextversions' => "Attenzione! C'è una nuova versione disponiible",

	'plugins:browse_more:newest' => "Sfoglia i plugin più recenti",
	'plugins:browse_more:popular' => "Sfoglia i plugin più scaricati",
	'plugins:browse_more:dugg' => "Sfoglia i plugin più raccomandati",


	/**
	 * Sort field labels
	 */

	'plugins:sort:info' => 'Ordinato per:',
	'plugins:sort:title' => 'Titolo',
	'plugins:sort:author' => 'Autore',
	'plugins:sort:downloads' => 'Downloads',
	'plugins:sort:recommendations' => 'Raccomandazioni',
	'plugins:sort:created' => 'Crato',
	'plugins:sort:updated' => 'Aggiornato',


	/**
	 * Filters
	 */

	'plugins:filters:title' => 'Cerca plugin in base...',
	'plugins:filters:category' => 'Categoria',
	'plugins:filters:version' => 'Versione Elgg',
	'plugins:filters:licence' => 'Tipo di licenza',
	'plugins:filters:text' => 'Qualunque testo',
	'plugins:filters:screenshot:label' => 'Schermata',
	'plugins:filters:screenshot' => 'Solo con anteprime',

	/**
	 * Search labels
	 */

	'plugins:search:title' => 'Cerca plugin per \"%s\" nella categoria: %s',
	'plugins:search:results' => 'Trovati %d plugin, visualizzati il %d al %d',
	'plugins:search:noresults' => 'Nessun plugin trovato',
	'plugins:search:noresults:info' => 'La tua ricerca non ha trovato alcun plugin nel nostro elenco. Si prega di riprovare con termini meno specifici.',

	/**
	 * What's new
	 */

	'plugins:front:intro:whatsnew' => 'Quali sono le novità?',
	'plugins:front:intro:whatsnew:text' => 'Ora puoi cercare ed esplorare i plugin in modo più efficace. Usa la colonna di destra per filtrare i plugin in base alle categorie, in base alla compatibilità con la versione di Elgg e altro. Ordina i risultati per download, raccomandazioni, autori e altre proprietà.',

	/**
	 * Search settings
	 */

	'plugins:settings:sort:label'	=> "Abilita la lista ordinata dei plugin",
	'plugins:settings:filter:multiple:label'	=> "Permetti l'uso di più filtri in una singola ricerca",
	'plugins:settings:filter:category:label'	=> "Abilita il filtro in base alla categoria del plugin",
	'plugins:settings:filter:category:multiple'	=> "Permetti la selezione di più categorie",
	'plugins:settings:filter:version:label'	=> "Abilita il filtro in base alla compatibilità con la versione Elgg",
	'plugins:settings:filter:version:multiple'	=> "Permetti la selezione di più versioni",
	'plugins:settings:filter:licence:label'	=> "Abilita il filtro in base al tipo di licenza",
	'plugins:settings:filter:licence:multiple'	=> "Permetti la selezione di più licenze",
	'plugins:settings:filter:text:label'	=> "Abilita il filtro in base a qualunque testo (mostra il titolo e la descrizione di default)",
	'plugins:settings:filter:text:author:name'	=> "Mostra anche il nome dell'autore",
	'plugins:settings:filter:text:author:username'	=> "Mostra anche il nome utente dell'autore",
	'plugins:settings:filter:text:summary'	=> "Mostra anche il sommarrio del plugin",
	'plugins:settings:filter:text:tags'	=> "Mostra anche i tag del plugin",
	'plugins:settings:filter:screenshot:label'	=> "Abilita il filtro in base alla disponibilità di schermate",


	'plugins:settings:save:success'	=> "Le impostazioni di ricerca dei plugin sono state aggiornate con successo",
	'plugins:settings:save:failure'	=> "Impossibile salvare le impostazioni di ricerca dei plugin: parametri non riconosciuti.",

	'plugins:filters:or' => '...o',
	
	'plugins:placeholder:categories' => "Choose categories",
	'plugins:placeholder:versions' => "Choose Elgg versions",
	'plugins:placeholder:licences' => "Choose licenses",
	'plugins:placeholder:keyword' => "Filter by keyword",


	'river:comment:object:plugin_release' => '%s ha commentato il plugin %s',
	'river:comment:object:plugin_project' => '%s ha commentato il plugin %s',
	'river:create:object:plugin_project' => "%s ha caricato un nuovo plugin: %s",
	'river:create:object:plugin_release' => "%s ha rilasciato una nuova versione del plugin %s",

	/* Edit Form */
	'plugins:edit:helptext' => "Stai modificando le informazioni del progetto del plugin per %s. Per caricare una nuova versione cliccare %s.",
	'plugins:add:helptext' => "Stai creando un nuovo progetto del plugin. Se desideri rilasciare una nuova
⇥versione del plugin già esistente, vai nella sezione modifica delle pagina del progetto del plugin. Puoi vedere tutti i tuoi plugin %s",
	'plugins:edit:label:name' => "Nome del progetto",
	'plugins:edit:label:project_summary' => 'Sommario del progetto',
	'plugins:edit:help:project_summary' => "Crea un sommario di una o due frasi (250 caratteri) per le principali caratteristiche del tuo progetto.",
	'plugins:edit:label:description' => "Descrizione del progetto",
	'plugins:edit:help:description' => "Una descrizione completa delle caratteristiche del progetto. (Come per %s, immagini e collegamenti verranno rimossi.)",
	'plugins:edit:label:plugin_type' => "Tipo di progetto",
	'plugins:edit:label:project_homepage' => "Pagina web del progetto",
	'plugins:edit:label:donate' => "URL per le donazioni",
	'plugins:edit:help:donate' => "Se accetti le donazioni, inserisci l'URL per la sezione \"Donazioni\" nel tuo sito.",
	'plugins:edit:help:tags' => "Una lista,serapata da virgole, di tag importanti per il tuo progetto.",
	'plugins:edit:help:access' => "Il livello di accesso al tuo progetto. Si noti che le singole versioni possono avere varie impostazioni di accesso.",
	'plugins:edit:recommended:none' => 'Nessuna versione raccomandata',
	'plugins:edit:label:project_images' => "Immagini del progetto",
	'plugins:edit:help:project_images' => "Mostra il tuo progetto caricando immagini!",
	'plugins:edit:image' => "Immagine",
	'plugins:edit:help:release' => "Si sta caricando l'informazione per questa versione. Per modificare i
dettagli generali del progetto, visita la sezione modifica nella pagina del progetto.",
	'plugins:edit:help:file' => 'Si sta caricando l\'informazione per questa versione. Per modificare i
dettagli generali del progetto, visita la sezione modifica nella pagina del progetto.',
	'plugins:edit:label:release_version' => "Versione",
	'plugins:edit:label:release_notes' => "Note",
	'plugins:edit:help:release_notes' => "Lista di cambiamenti, correzioni di bug, bug, e note generali per questa versione. (Come per %s, le immagini e i collegamenti verranno rimossi.)",
	'plugins:edit:label:elgg_version' => "Compatibilità Elgg",
	'plugins:edit:help:elgg_version' => "Questo plugin è stato sviluppato e testato su questa versione di Elgg",
	'plugins:edit:label:comments' => "Permetti i commenti",
	'plugins:edit:help:access' => "Il livello di accesso al tuo progetto. Si noti che le singole versioni possono avere varie impostazioni di accesso.",
	'plugins:edit:label:recommended' => "Imposta come versione raccomandata",
	'plugins:edit:help:recommended' => "Raccomandare a tutti gli utenti questa versione del plugin?",
	'plugins:link:here' => 'qui',

	/**
	 * Misc
	 */
	 'plugins:warning:page:all:bookmark' => 'Si prega di aggiornare o segnalare questo collegamento al proprietario del sito poiché questa pagina è stata spostata.',
	 'plugins:error:invalid_release' => "Impossibile trovare la versione da te richiesta.",
	 'plugins:forward:recommended_release' => "Versione raccomandata inoltrata.",
	 'plugins:error:unrecognized_plugin' => "Non abbiamo riconosciuto il plugin",

	/**
	 *	Actions
	 */
	'plugins:action:combine:invalid_guids' => 'I GUID devono essere per 2 progetti di plugin',
	'plugins:action:combine:success' => "%s è stato unito nel progetto %s",
	'plugins:action:normalize:invalid_guid' => "Nessuna GUID specificata",
	'plugins:action:normalize:notpreview' => "Numero di download normalizzato rimuovendo %s annotazioni",
	'plugins:action:normalize:preview' => "Vuoi rimuovere %s annotazioni usando un massimo di %s",
	'plugins:action:invalid_project' => 'Progetto non valido',
	'plugins:action:transfer:invalid_recipient' => 'Destinatario non valido',
	'plugins:action:transfer:success' => 'La proprietà del plugin è stata cambiata.',
	'plugins:action:upgrade:not_required' => 'Nessun è necessario alcun aggiornamento',
	'plugins:action:upgrade:success' => "La lista dei plugin della comunità è stata aggiornata",
	'plugins:action:invalid_contributors' => 'Collaboratori non validi',
	'plugins:action:add_contributors:success' => 'I collaboratori sono stati aggiunti.',
	'plugins:action:invalid_user' => "Utente non valido",
	'plugins:action:delete_contributor:success' => 'L\'utente è stato rimosso dalla lista di collaboratori',
	'plugins:action:invalid_access' => 'Accesso sconosciuto o insufficiente per rilasciare la versione',
	'plugins:action:transfer:not_moved' => "Release ID: %s - the file could not be moved on the file system",
);
