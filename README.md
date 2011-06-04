Elgg Community Plugin Repository
================================

Data Model
-----------

There are two primary classes: PluginProject and PluginRelease. A PluginProject
holds the general information about a plugin such as its description, license,
and categories. The PluginRelease holds the release notes and the actual
zip file or tarball. A PluginProject serves as the container for one or more
PluginReleases.


Views Structure
---------------

The repository uses its own layout for many of the pages. This layout has a
right sidebar, a main content area, and an optional footer. The other pages use
the default sidebar on left with a main content area.


Search
-------

Search uses Elgg's search plugin with its own custom hook: plugins_search_hook().
The hook makes sure that category selection is used and searches over some
metadata fields. To support Elgg's search plugin, it also defines some views
that are automatically picked up. This can be hard to follow if you do not have
experience with the search plugin (or maybe it is just always hard to follow).


Contributions
-------------
What to contribute to the plugin repository? The first step is getting a Github
account and forking [the git repository](https://github.com/Elgg/community_plugins).