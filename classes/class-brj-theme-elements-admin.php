<?php
class BRJ_ThemeElementsAdmin {

    static function admin_menu() {
        $parent_slug = 'edit.php?post_type=brj-workspace';
        $page_title = __('Export', 'bb-theme-elements');
        $menu_title = __('Export', 'bb-theme-elements');
        $capability = 'manage_options';
        $menu_slug = 'brj-theme-elements-admin';
        $callback = 'BRJ_ThemeElementsAdmin::render';
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback );
    }

    static function admin_enqueue($hook) {
        if ($hook == 'brj-workspace_page_brj-theme-elements-admin') {
            wp_enqueue_style('theme-elements-admin', BB_THEME_ELEMENTS_URL . 'css/admin.css');
            wp_enqueue_script('ace', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.2/ace.js');
            wp_enqueue_script('theme-elements-admin', BB_THEME_ELEMENTS_URL . 'js/admin.js', array('jquery', 'ace'));
        }
    }

    static function render() {
        $module_types = BRJ_ThemeElements::$worker_module_types;

        $module_groups = BRJ_ThemeElements::get_modules();
        ?>
        <div class="wrap brj-theme-elements-wrap">

        	<h1><?php _e('Theme Elements', 'bb-theme-elements') ?></h1>

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

    static function register_post_types() {
        $labels = array(
    		'name' => 'Workspaces',
    		'singular_name' => 'Workspace',
            'add_new_item' => 'Add New Workspace'
    	);
        $args = array(
    		'label' => 'Workspaces',
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
        register_post_type('brj-workspace', $args);

        // Enable Beaver Builder for Workspace Post Type
        $types = get_option('_fl_builder_post_types');
        if (!in_array('brj-workspace', $types)) {
            $types[] = 'brj-workspace';
            update_option('_fl_builder_post_types', $types);
        }
    }

    static function admin_bar() {
        global $wp_admin_bar;
        $posts = BRJ_ThemeElements::get_posts();

    	$args = array(
    		'id'     => 'brj-workspaces',
    		'title'  => __( 'Workspace Pages', 'fl-builder' ),
            'href' => admin_url('edit.php?post_type=brj-workspace')
    	);
    	$wp_admin_bar->add_menu( $args );

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

        // Add New
        $args = array(
    		'id' => 'brj-create-workspace',
    		'parent' => 'brj-workspaces',
    		'title' => __( 'Add New', 'fl-builder' ),
            'href' => admin_url('post-new.php?post_type=brj-workspace')
    	);
    	$wp_admin_bar->add_menu( $args );

        // Export
        $args = array(
    		'id' => 'brj-export-workspace',
    		'parent' => 'brj-workspaces',
    		'title' => __( 'Export Code', 'fl-builder' ),
            'href' => admin_url('edit.php?post_type=brj-workspace&page=brj-theme-elements-admin')
    	);
    	$wp_admin_bar->add_menu( $args );
    }

    static function filter_edit_post_link($url, $post_id, $context) {
        if (get_post_type($post_id) == 'brj-workspace') {
            $url = FLBuilderModel::get_edit_url($post_id);
        }
        return $url;
    }

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
}
?>