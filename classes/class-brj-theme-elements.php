<?php
class BRJ_ThemeElements {

    /**
    * Array of all registered workspace modules
    *
    * @since 0.1
    * @var array $worker_module_types
    */
    static public $worker_module_types = array();

    /**
    * Array of all workspace module instances inside workspace layouts.
    *
    * @since 0.2
    * @var array $modules
    */
    static $modules = array();

    /**
    * Initialize modules
    *
    * @since 0.1
    * @return void
    */
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

    /**
    * Enqueue Stylesheets and Scripts
    *
    * @since 0.1
    * @return void
    */
    static function enqueue() {
        wp_enqueue_style('brj-theme-elements-shared', BB_THEME_ELEMENTS_URL . '/css/module.css');
    }

    /**
    * Collect posts to be used for configuration.
    *
    * @since 0.1
    * @return array of post ids
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
    * Collect layouts from posts to be used for configuration.
    *
    * @since 0.1
    * @return array
    */
    static function get_layouts() {
        $posts = self::get_posts();
        $layouts = array();
        if (!empty($posts)) {
            foreach($posts as $post_id) {

                // get post meta
                $draft_layout = get_post_meta($post_id, '_fl_builder_draft', true);
                $layout = get_post_meta($post_id, '_fl_builder_data', true);

                /**
                * @todo add conditions around using draft or published.
                */
                if ($draft_layout != $layout) {
                    $layout = $draft_layout;
                }
                if (!empty($layout)) {

                    $layouts[$post_id] = $layout;
                }
            }
        }
        return $layouts;
    }

    /**
    * Collect instances of workspace modules inside layouts.
    *
    * @since 0.1
    * @return array
    */
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

    /**
    * Filter the beaver builder global settings for and add workspace settings.
    *
    * @since 0.2
    * @param array $form
    * @param string $id
    * @return array beaver builder form data
    */
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

    /**
    * NOT IN USE - Stub for method to get url base locations for settings fields.
    *
    * @since 0.2
    * @return array
    */
    static function get_base_paths() {
        $paths = array(
            'themes' => 'my theme',
            'plugins' => 'my plugin'
        );
        return $path;
    }

    /**
    * NOT IN USE - gets an array of all stylesheets that are registered.
    *
    * @since 0.2
    * @return array
    */
    static function get_registered_stylesheets() {
        global $wp_styles;
        $stylesheets = array_keys($wp_styles->registered);
        return $stylesheets;
    }

}
?>
