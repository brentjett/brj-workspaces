<?php
class BRJ_Sidebar extends BRJ_WorkspaceModule {

	public function __construct() {
		parent::__construct(array(
			'name'          => __('Sidebar', 'fl-builder'),
			'description'   => __('Register a sidebar', 'fl-builder'),
			'category'      => BB_THEME_ELEMENTS_MODULE_CATEGORY,
			'dir'           => BB_THEME_ELEMENTS_DIR . 'modules/brj-sidebar/',
            'url'           => BB_THEME_ELEMENTS_URL . 'modules/brj-sidebar/',
			'handle' => 'brj-sidebar',
			'label' => __('Sidebar', 'fl-builder'),
			'label_plural' => __('Sidebars', 'fl-builder'),
			'label_field' => 'label',
			'accent_color' => 'A290FF'
		));
		$this->add_css('brj-theme-elements-shared');
		$this->add_css('font-awesome');

		add_action('brj_theme_elements_render/after_setup_theme', 'BRJ_Sidebar::render_php');
		add_action('after_setup_theme', 'BRJ_Sidebar::register_sidebars');
	}

    static function render_php() {
        $modules = BRJ_ThemeElements::get_modules();
		$modules = $modules['brj-sidebar'];
		if (!empty($modules)) {
			require dirname(__FILE__) . '/generator/generator.php';
		}
    }

	static function get_args($module) {
		$args = array(
			'name'          => $module->settings->label,
			'id'            => $module->settings->handle,
			'description'   => $module->settings->description,
			'class'         => $module->settings->class,
			'before_widget' => $module->settings->before_widget,
			'after_widget'  => $module->settings->after_widget,
			'before_title'  => $module->settings->before_title,
			'after_title'   => $module->settings->after_title
		);
		return $args;
	}

    static function register_sidebars() {
        $modules = BRJ_ThemeElements::get_modules();
		$modules = $modules['brj-sidebar'];
		if (!empty($modules)) {
			foreach($modules as $module) {

				$args = self::get_args($module);
				register_sidebar($args);
			}
		}
    }
}

FLBuilder::register_module('BRJ_Sidebar', array(
	'general'       => array(
		'title'         => __('General', 'fl-builder'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
                    'handle' => array(
                        'type' => 'text',
                        'label' => 'Handle',
                        'placeholder' => 'default_sidebar'
                    ),
                    'label' => array(
                        'type' => 'text',
                        'label' => 'Name',
                        'placeholder' => 'Default Sidebar'
                    ),
					'description' => array(
						'type' => 'textarea',
						'label' => 'Description'
					),
					'class' => array(
						'type' => 'text',
						'label' => 'Class'
					),
					'before_widget' => array(
						'type' => 'text',
						'label' => 'Before Widget',
						'placeholder' => ''
					),
					'after_widget' => array(
						'type' => 'text',
						'label' => 'After Widget',
						'placeholder' => ''
					),
					'before_title' => array(
						'type' => 'text',
						'label' => 'Before Title',
						'placeholder' => ''
					),
					'after_title' => array(
						'type' => 'text',
						'label' => 'After Title',
						'placeholder' => ''
					)
                )
            )
        )
    )
));
?>
