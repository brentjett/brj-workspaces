<?php
class BRJ_NavMenuLocation extends BRJ_WorkspaceModule {

	public function __construct() {
		parent::__construct(array(
			'name'          => __('Nav Menu Location', 'fl-builder'),
			'description'   => __('Register a nav menu location', 'fl-builder'),
			'category'      => BB_THEME_ELEMENTS_MODULE_CATEGORY,
			'dir'           => BB_THEME_ELEMENTS_DIR . 'modules/brj-nav-menu-location/',
            'url'           => BB_THEME_ELEMENTS_URL . 'modules/brj-nav-menu-location/',
			'handle' => 'brj-nav-menu-location',
			'label' => __('Menu Location', 'fl-builder'),
			'label_plural' => __('Menu Locations', 'fl-builder'),
			'label_field' => 'label',
			'accent_color' => 'D0027C'
		));
		$this->add_css('brj-theme-elements-shared');
		$this->add_css('font-awesome');

		add_action('brj_theme_elements_render/after_setup_theme', 'BRJ_NavMenuLocation::render_php');
		add_action('after_setup_theme', 'BRJ_NavMenuLocation::register_nav_menus');
	}

    static function render_php() {
        $modules = BRJ_ThemeElements::get_modules();
		$locations = $modules['brj-nav-menu-location'];
		if (!empty($locations)) {
			require dirname(__FILE__) . '/generator/generator.php';
		}
    }

    static function register_nav_menus() {
        $modules = BRJ_ThemeElements::get_modules();
		$modules = $modules['brj-nav-menu-location'];
		if (!empty($modules)) {
			foreach($modules as $module) {
				$handle = $module->settings->handle;
				$label = $module->settings->label;
				register_nav_menu($handle, $label);
			}
		}
    }
}

FLBuilder::register_module('BRJ_NavMenuLocation', array(
	'general'       => array(
		'title'         => __('General', 'fl-builder'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
                    'handle' => array(
                        'type' => 'text',
                        'label' => 'Handle',
                        'placeholder' => 'header_nav'
                    ),
                    'label' => array(
                        'type' => 'text',
                        'label' => 'Name',
                        'placeholder' => 'Header Nav'
                    )
                )
            )
        )
    )
));
?>
