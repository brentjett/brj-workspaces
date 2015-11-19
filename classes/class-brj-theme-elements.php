<?php
class BRJ_ThemeElements {

    static public $worker_module_types = array();
    static $modules = array();

    static function init() {
        if ( class_exists('FLBuilderModule') ) {

            // Include Modules
            //require_once BB_THEME_ELEMENTS_DIR . '/modules/color-sample/color-sample.php';
            require_once BB_THEME_ELEMENTS_DIR . '/modules/brj-image-size/brj-image-size.php';
    		require_once BB_THEME_ELEMENTS_DIR . '/modules/brj-post-type/brj-post-type.php';
            require_once BB_THEME_ELEMENTS_DIR . '/modules/brj-nav-menu-location/brj-nav-menu-location.php';
            require_once BB_THEME_ELEMENTS_DIR . '/modules/brj-sidebar/brj-sidebar.php';
            require_once BB_THEME_ELEMENTS_DIR . '/modules/brj-stylesheet/brj-stylesheet.php';

            // Collect all configuration modules from posts being used as component layouts.
            self::$modules = self::get_modules();
        }
    }

    static function enqueue() {
        wp_enqueue_style('brj-theme-elements-shared', BB_THEME_ELEMENTS_URL . '/css/module.css');
    }

    /**
    * Gather all posts to be read for configuration.
    */
    static function get_posts() {

        $default_posts = array();
        //$default_posts[] = get_option('bb_theme_tools_component_page');
        $workspace_posts = get_posts(array(
            'post_type' => 'brj-workspace',
            'post_status' => 'publish'
        ));
        foreach($workspace_posts as $post) {
            $default_posts[] = $post->ID;
        }
        return apply_filters('brj_get_component_posts', $default_posts);
    }

    /**
    *  Gather the layout data from each post.
    */
    static function get_layouts() {
        /**
        * filter: brj_get_component_posts
        * This filter gets all posts to be used as component layouts.
        */
        $component_posts = self::get_posts();
        $layouts = array();
        if (!empty($component_posts)) {
            foreach($component_posts as $post_id) {

                // get post meta
                $draft_layout = get_post_meta($post_id, '_fl_builder_draft', true);
                $layout = get_post_meta($post_id, '_fl_builder_data', true);
                if ($draft_layout != $layout) {
                    $layout = $draft_layout;
                }
                if (!empty($layout)) {
                    // read layout and collect known modules
                    $layouts[$post_id] = $layout;
                }
            }
        }
        return $layouts;
    }

    static function get_modules() {

        $modules = array();

        if (!empty(self::$modules)) {
            $modules = self::$modules;
        } else {
            $layouts = self::get_layouts();
            $module_types = array_keys(self::$worker_module_types);
            if (!empty($layouts)) {
                foreach($layouts as $post_id => $data ) {
                    foreach($data as $node_id => $node) {

                        // Is it a module? Is it a configurable module?
                        if ( $node->type == 'module' && in_array( $node->settings->type, $module_types ) ) {
                            $node->origin_post = $post_id;
                            $modules[$node->settings->type][] = $node;
                        }
                    }
                }
            }
        }
        return $modules;
    }

    static function add_global_settings($form, $id) {

        $module_types = self::$worker_module_types;

        if ($id == 'global') {
            if (!empty($module_types)) {
                $theme_module_settings = array(
                    'title' => __('Workspaces', 'brj-workspaces'),
                    'sections' => array(
                        'general' => array(
                            'title' => '',
                            'fields' => array(

                            )
                        )
                    )
                );
                foreach($module_types as $handle => $module) {
                    if (!isset($module['accent_color'])) {
                        $module['accent_color'] = '333';
                    }
                    $theme_module_settings['sections'][$handle] = array(
                        'title' => $module['label'],
                        'fields' => array(
                            $handle . '-accent-color' => array(
                                'type' => 'color',
                                'label' => __('Accent Color', 'fl-builder'),
                                'default' => $module['accent_color']
                            )
                        )
                    );
                }
            }
            $form['tabs']['theme-elements'] = $theme_module_settings;
        }

        return $form;
    }

    // Get include base urls
    static function get_base_paths() {
        $paths = array(
            'themes' => 'my theme',
            'plugins' => 'my plugin'
        );
        return $path;
    }

    static function get_registered_stylesheets() {
        global $wp_styles;
        $stylesheets = array_keys($wp_styles->registered);
        return $stylesheets;
    }

}
?>
