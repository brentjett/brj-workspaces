<?php
class BRJ_WorkspacesAdmin {

    /**
    * Sets up the admin menu page for code generation.
    *
    * @since 0.2
    * @return void
    */
    static function admin_menu() {
        $parent_slug = 'edit.php?post_type=brj-workspace';
        $page_title = __('Export', 'brj-workspaces');
        $menu_title = __('Export', 'brj-workspaces');
        $capability = 'manage_options';
        $menu_slug = 'brj-workspaces-admin-export';
        $callback = 'BRJ_WorkspacesAdmin::render';
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback );
    }

    /**
    * Setup scripts and stylesheets for admin pages
    *
    * @since 0.2
    * @param string $hook The handle for the current admin screen.
    * @return void
    */
    static function admin_enqueue($hook) {
        if ($hook == 'brj-workspace_page_brj-workspaces-admin-export') {
            wp_enqueue_style('brj-workspaces-admin', BB_THEME_ELEMENTS_URL . 'css/admin.css');
            wp_enqueue_script('ace', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.2/ace.js');
            wp_enqueue_script('brj-workspaces-admin', BB_THEME_ELEMENTS_URL . 'js/admin.js', array('jquery', 'ace'));
        }
    }

    /**
    * Render the main admin page 'Export'
    *
    * @since 0.1
    * @return void
    */
    static function render() {
        $module_types = BRJ_ThemeElements::$worker_module_types;

        $module_groups = BRJ_ThemeElements::get_modules();
        ?>
        <div class="wrap brj-theme-elements-wrap">

        	<h1><?php _e('Workspaces', 'brj-workspaces') ?></h1>

            <div class="editor-tabs">
                <div class="editor-tab php-tab active" data-trigger-tab="php">PHP</div>
                <div class="editor-tab css-tab" data-trigger-tab="css">CSS</div>
            </div>

            <div class="page-content">

                <div class="module-list box">
                <?php
                if (!empty($module_groups)) {
                    foreach($module_groups as $type => $modules) {

                        $module_type = $module_types[$type];
                        $type_label = $module_type['label_plural'];
                        $accent_color = $module_type['accent_color'];
                        if ($accent_color) {
                            $style = "style='border-left-color: #$accent_color; '";
                        }
                        print "<div class='module-type' $style>$type_label</div>";
                        foreach($modules as $module_id => $module) {
                            $label_field = $module_type['label_field'];
                            $label = '';
                            if ($label_field && $module->settings->{$label_field}) {
                                $label = $module->settings->{$label_field};
                            }
                            print "<div class='module-name'>$label</div>";
                        }
                    }
                }
                ?>
                </div>

                <div class="generator-wrap">
                    <div id="php-editor" class="generated-php editor"><?php BRJ_ThemeElementsGenerator::render_php() ?></div>

                    <div id="css-editor" class="generated-css editor"><?php BRJ_ThemeElementsGenerator::render_css() ?></div>
                </div>
            </div><!-- /.page-content -->
        </div>
        <?php
    }

    /**
    * Register the Workspaces Post Type
    *
    * @since 0.2
    * @return void
    */
    static function register_post_types() {
        $handle = 'brj-workspace';
        $labels = array(
    		'name' => __('Workspaces', 'brj-workspaces'),
    		'singular_name' => __('Workspace', 'brj-workspaces'),
            'add_new_item' => __('Add New Workspace', 'brj-workspaces'),
    	);
        $args = array(
    		'label' => __('Workspace', 'brj-workspaces'),
            'labels' => $labels,
    		'hierarchical' => false,
    		'public' => true,
    		'show_ui' => true,
    		'menu_icon' => 'dashicons-art',
    		'show_in_admin_bar' => true,
    		'show_in_nav_menus' => true,
    		'can_export' => true,
    		'has_archive' => false,
    		'exclude_from_search' => true,
    		'publicly_queryable' => true,
            'supports' => array('title', 'revisions'),
            'rewrite' => array(
                'with_front' => false,
                'slug'       => 'workspaces'
            ),
            'menu_position' => 100
    	);
        register_post_type($handle, $args);

        // Enable Beaver Builder for Workspace Post Type
        $types = get_option('_fl_builder_post_types');
        if (!in_array($handle, $types)) {
            $types[] = $handle;
            update_option('_fl_builder_post_types', $types);
        }
    }

    /**
    * Add Workspace pages to admin bar menu.
    *
    * @since 0.2
    * @return void
    */
    static function admin_bar() {
        global $wp_admin_bar;

        // Top Level "Workspace Pages" Menu
    	$args = array(
    		'id'     => 'brj-workspaces',
    		'title'  => __( 'Workspace Pages', 'fl-builder' ),
            'href' => admin_url('edit.php?post_type=brj-workspace')
    	);
    	$wp_admin_bar->add_menu( $args );

        // Link to each published workspace
        $posts = BRJ_ThemeElements::get_posts();
        if (!empty($posts)) {
            foreach($posts as $id) {
                $args = array(
            		'id' => 'brj-workspace-' . $id,
            		'parent' => 'brj-workspaces',
            		'title' => get_the_title($id),
                    'href' => get_permalink($id)
            	);
            	$wp_admin_bar->add_menu( $args );
            }
        }

        // "Add New" Item
        $args = array(
    		'id' => 'brj-create-workspace',
    		'parent' => 'brj-workspaces',
    		'title' => __( 'Add New', 'fl-builder' ),
            'href' => admin_url('post-new.php?post_type=brj-workspace')
    	);
    	$wp_admin_bar->add_menu( $args );

        // "Export" Item
        $args = array(
    		'id' => 'brj-export-workspace',
    		'parent' => 'brj-workspaces',
    		'title' => __( 'Export Code', 'fl-builder' ),
            'href' => admin_url('edit.php?post_type=brj-workspace&page=brj-theme-elements-admin')
    	);
    	$wp_admin_bar->add_menu( $args );
    }

    /**
    * Filter the edit link
    *
    * @since 0.3
    * @param string $url
    * @param int $post_id
    * @param string $context
    * @return string $url The Url to an edit screen
    */
    static function filter_edit_post_link($url, $post_id, $context) {
        if (get_post_type($post_id) == 'brj-workspace') {
            $url = FLBuilderModel::get_edit_url($post_id);
        }
        return $url;
    }

    /**
    * Plugin activation setup
    *
    * @since 0.3
    * @return void
    */
    static function activate() {
        self::register_post_types();
        flush_rewrite_rules();

        // Setup Example Workspace
        $exists = post_exists('Example Workspace');
        $published = (get_post_status($exists) == 'publish');
        if (!$exists || !$published) {
            $args = array(
                'post_title' => 'Example Workspace',
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'brj-workspace'
            );
            $id = wp_insert_post($args);
            if ($id) {
                $data = file_get_contents(BB_THEME_ELEMENTS_DIR . '/data/demo-layout.dat');
                $layout = unserialize($data);
                update_post_meta($id, '_fl_builder_enabled', 1);
                update_post_meta($id, '_fl_builder_draft', $layout);
                update_post_meta($id, '_fl_builder_data', $layout);
            }
        }
    }

    static function setup_updater() {
        if (is_admin() && class_exists('WP_GitHub_Updater')) { // note the use of is_admin() to double check that this is happening in the admin
            $config = array(
                'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
                'proper_folder_name' => 'brj-workspaces', // this is the name of the folder your plugin lives in
                'api_url' => 'https://api.github.com/repos/brentjett/brj-workspaces', // the github API url of your github repo
                'raw_url' => 'https://raw.github.com/brentjett/brj-workspaces/master', // the github raw url of your github repo
                'github_url' => 'https://github.com/brentjett/brj-workspaces', // the github url of your github repo
                'zip_url' => 'https://github.com/brentjett/brj-workspaces/zipball/master', // the zip url of the github repo
                'sslverify' => true, // wether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
                'requires' => '4.3.1', // which version of WordPress does your plugin require?
                'tested' => '4.3.1', // which version of WordPress is your plugin tested up to?
                'readme' => 'README.MD', // which file to use as the readme for the version number
                'access_token' => '72c0d3c26cd49014a44e5b6cc618cc76bf1a79e2'
            );
            print_r($config);
            $updater = new WPGitHubUpdater($config);
            print_r($updater);
        }
    }
}
?>
