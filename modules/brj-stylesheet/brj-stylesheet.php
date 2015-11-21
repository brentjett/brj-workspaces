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

        $this->add_js('ace', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.2/ace.js');

		add_action('wp_head', 'BRJ_Stylesheet::print_head');
        add_action('brj_theme_elements/generate_css', 'BRJ_Stylesheet::render_css');
	}

    static function print_head() {
        global $post;
        $modules = BRJ_ThemeElements::get_modules();
		$modules = $modules['brj-stylesheet'];
        if (!empty($modules)) {
            foreach($modules as $module) {
                //print_r($module);

                // don't include
                if ($module->settings->include_on == 'none') {
                    continue;
                } else if ($module->settings->include_on == 'workspaces' && (get_post_type($post->ID) != 'brj-workspace')) {
                    continue;
                } else if ($module->settings->include_on == 'this') {
                    $origin = $module->origin_post;
                    if ($origin != $post->ID) continue;
                }
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

    static function get_fields() {
        $fields = array(
        	'general' => array(
        		'title' => __('General', 'fl-builder'),
        		'sections' => array(
        			'general' => array(
        				'title' => '',
        				'fields' => array(
                            'label' => array(
                                'type' => 'text',
                                'label' => 'Name',
                                'placeholder' => 'Main Stylesheet'
                            ),
                            'include_on' => array(
                                'type' => 'select',
                                'label' => 'Include Styles On',
                                'options' => array(
                                    'all' => 'Entire Site',
                                    'this' => 'Only This Page',
                                    'workspaces' => 'Only Workspace Pages',
                                    'none' => 'Do Not Include'
                                )
                            ),
                            'css' => array(
                                'type' => 'code',
                                'editor' => 'css',
                                'rows' => '14'
                            )
                        )
                    )
                )
            )
        );
        return apply_filters('brj-workspace/filter-module-fields', $fields, 'BRJ_Stylesheet');
    }
}

// Register module
FLBuilder::register_module('BRJ_Stylesheet', BRJ_Stylesheet::get_fields());
?>
