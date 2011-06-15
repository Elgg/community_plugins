<?php
    global $CONFIG;
    $url = $vars['url'] . 'pg/plugins/all';
?>

    <div id="plugin_filters">
		<div class="plugins_sidebar_box">
			<a class="plugins_highlight" href="<?php echo $url; ?>">Plugins home</a>
		</div>

		<div class="plugins_sidebar_box">
        
        <form method="get" name="plugin_search_form" id="plugin_search_form" action="<?php echo $CONFIG->wwwroot?>pg/plugins/search">
            <h3 class="filter_title"><?php echo elgg_echo('plugins:filters:title'); ?></h3>
            <br />

            <?php if (is_array($vars['categories'])) : ?>
            <div class="filter_fields">
                <div class="filter_label"><?php echo elgg_echo('plugins:filters:category'); ?></div>
                <div>
                    <select name="f[c][]" class="input-select multiselect" multiple="multiple">
                    <?php foreach ($vars['categories'] as $key => $category) :?>
                        <option value="<?php echo $key; ?>"><?php echo $category; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <?php if (is_array($vars['versions'])) : ?>
            <div class="filter_fields">
                <div class="filter_label"><?php echo elgg_echo('plugins:filters:version'); ?></div>
                <div>
                    <select name="f[v][]" class="input-select multiselect" multiple="multiple">
                    <?php foreach ($vars['versions'] as $version) :?>
                        <option value="<?php echo $version; ?>"><?php echo $version; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <?php if (is_array($vars['licences'])) : ?>
            <div class="filter_fields">
                <div class="filter_label"><?php echo elgg_echo('plugins:filters:licence'); ?></div>
                <div>
                    <select name="f[l][]" class="input-select multiselect" multiple="multiple">
                    <?php foreach ($vars['licences'] as $key => $licence) :?>
                        <option value="<?php echo $key; ?>"><?php echo $licence; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <div class="filter_fields">
                <div class="filter_label"><?php echo elgg_echo('plugins:filters:text'); ?></div>
                <div>
                    <input type="text" name="f[t]" value="<?php echo $vars['filters']['text']; ?>" class="input-text"/>
                </div>
            </div>

            <div class="filter_fields">
                <div class="filter_label">
                	<input type="checkbox" name="f[s]" />
                	<?php echo elgg_echo('plugins:filters:screenshot'); ?>
                </div>
            </div>

            <div class="search_fields">
                <input type="submit" class='search_plugins' name="submit_button" value="Search" />
                <button type="button" id="clear_search" class='clear_search' name="clear">Clear values</button>
            </div>
        </form>
        
        </div>
    </div>