<?php
class BRJ_Stylesheet extends BRJ_WorkspaceModule {

    public function __construct() {
		parent::__construct(array(
			'name'          => __('Stylesheet', 'fl-builder'),
			'description'   => __('Register a enqueue a stylesheet', 'fl-builder'),
			'category'      => BB_THEME_ELEMENTS_MODULE_CATEGORY,
			'dir'           => BB_THEME_ELEMENTS_DIR . 'modules/brj-stylesheet/',
            'url'           => BB_THEME_ELEMENTS_URL . 'modules/brj-stylesheet/',
            'handle' => 'brj-stylesheet',
			'label' => __('Stylesheet', 'fl-builder'),
			'label_plural' => __('Stylesheets', 'fl-builder'),
			'label_field' => 'label',
			'accent_color' => 'FF7878'
		));
        
		add_action('wp_head', 'BRJ_Stylesheet::print_head');
        add_action('brj_theme_elements/generate_css', 'BRJ_Stylesheet::render_css');
	}

    static function print_head() {
        $modules = BRJ_ThemeElements::get_modules();
		$modules = $modules['brj-stylesheet'];
        if (!empty($modules)) {
            foreach($modules as $module) {
            ?>
            <style id="<?php echo $module->node ?>-stylesheet">
            <?php echo $module->settings->css ?>
            </style>
            <?php
            }
        }
    }

    static function render_css() {
        $modules = BRJ_ThemeElements::get_modules();
		$modules = $modules['brj-stylesheet'];
        require dirname(__FILE__) . '/generator/generator.php';
    }
}

FLBuilder::register_module('BRJ_Stylesheet', array(
	'general'       => array(
		'title'         => __('General', 'fl-builder'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
                    /*
                    'handle' => array(
                        'type' => 'text',
                        'label' => 'Handle',
                        'placeholder' => 'main_stylesheet'
                    ),
                    */
                    'label' => array(
                        'type' => 'text',
                        'label' => 'Name',
                        'placeholder' => 'Main Stylesheet'
                    ),
                    /*
                    'kind' => array(
                        'type' => 'select',
                        'label' => 'Type',
                        'options' => array(
                            'stylesheet_uri' => 'Main Stylesheet',
                            'external' => 'External',
                            'embed' => 'Embedded'
                        ),
                        'toggle'        => array(
							'external'      => array(
								'fields'      => array()
							),
							'embed'     => array(
								'fields'      => array('css')
							)
						)
                    ),
                    'base_path' => array(
                        'type' => 'select',
                        'label' => 'Base Path',
                        'options' => array(
                            'active_theme' => 'Active Theme'
                        )
                    ),
                    'path' => array(
                        'type' => 'text',
                        'label' => 'path',
                        'placeholder' => '/path/to/style.css'
                    ),
                    */
                    'css' => array(
                        'type' => 'code',
                        'editor'        => 'css',
                        'rows'          => '14'
                    )
                )
            )
        )
    ),
    /*
    'dependencies' => array(
        'title' => __('Dependencies', 'fl-builder'),
        'sections' => array(
            'general' => array(
				'title' => '',
				'fields' => array(
                    'stylesheets' => array(
                        'type' => 'select',
                        'label' => 'Registered Stylesheets',
                        'options' => array(),
                        'multi-select'  => true
                    )
                )
            )
        )
    )
    */
));
?>
