<?php
/*
Plugin Name: Workspace Pages for Beaver Builder
Author: Brent Jett
Version: 0.3-alpha
Description: This plugin offers a set of modules for Beaver Builder that allow you to simulate theme components while you construct your theme or plugin.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'BB_THEME_ELEMENTS_DIR', plugin_dir_path( __FILE__ ) );
define( 'BB_THEME_ELEMENTS_URL', plugins_url( '/', __FILE__ ) );
define( 'BB_THEME_ELEMENTS_MODULE_CATEGORY', 'Workspace Modules');

if (class_exists('FLBuilder')) {

    require_once BB_THEME_ELEMENTS_DIR . '/classes/class-brj-theme-elements.php';
    require_once BB_THEME_ELEMENTS_DIR . '/classes/class-brj-workspaces-admin.php';
    require_once BB_THEME_ELEMENTS_DIR . '/classes/class-brj-theme-elements-generator.php';
    require_once BB_THEME_ELEMENTS_DIR . '/classes/class-brj-workspace-module.php';

    // Kickoff Everything
    add_action('plugins_loaded', 'BRJ_ThemeElements::init' );
    add_action('wp_enqueue_scripts', 'BRJ_ThemeElements::enqueue');

    // Admin Actions
    add_action('admin_menu', 'BRJ_WorkspacesAdmin::admin_menu');
    add_action('admin_enqueue_scripts', 'BRJ_WorkspacesAdmin::admin_enqueue');
    add_action('wp_before_admin_bar_render', 'BRJ_WorkspacesAdmin::admin_bar');
    add_action('init', 'BRJ_WorkspacesAdmin::register_post_types');

    add_filter('fl_builder_register_settings_form', 'BRJ_ThemeElements::add_global_settings', 10, 2);
    //add_filter('get_edit_post_link', 'BRJ_ThemeElementsAdmin::filter_edit_post_link', 10, 3);

    register_activation_hook( __FILE__, 'BRJ_WorkspacesAdmin::activate' );
}
?>
