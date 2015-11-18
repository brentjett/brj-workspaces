<?php

/**
 * @class FLVideoModule
 */
class BRJ_ImageSizeModule extends BRJ_WorkspaceModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          => __('Custom Image Size', 'fl-builder'),
			'description'   => __('Create A Custom Image Size', 'fl-builder'),
			'category'      => BB_THEME_ELEMENTS_MODULE_CATEGORY,
			'dir'           => BB_THEME_ELEMENTS_DIR . 'modules/brj-image-size/',
            'url'           => BB_THEME_ELEMENTS_URL . 'modules/brj-image-size/',
			'handle' => 'brj-image-size',
			'label' => __('Image Size', 'fl-builder'),
			'label_plural' => __('Image Sizes', 'fl-builder'),
			'label_field' => 'name',
			'accent_color' => '02D07F'
		));
		$this->add_css('brj-theme-elements-shared');

		add_action('after_setup_theme', 'BRJ_ImageSizeModule::setup_sizes');
		add_filter('image_size_names_choose', 'BRJ_ImageSizeModule::filter_sizes' );

		// Generator Actions
		add_action('brj_theme_elements_render/after_setup_theme', 'BRJ_ImageSizeModule::render_php');
		add_action('brj_theme_elements_render_filters', 'BRJ_ImageSizeModule::render_image_names_filter');
	}

	static function render_php() {
		$modules = BRJ_ThemeElements::get_modules();
		$sizes = $modules['brj-image-size'];
		if (!empty($sizes)) {
			require 'generator/generator.php';
		}
	}

	static function render_image_names_filter($prefix) {
		$modules = BRJ_ThemeElements::get_modules();
		$sizes = $modules['brj-image-size'];
		if (!empty($sizes)) {
			require 'generator/filter.php';
		}
	}

	static function setup_sizes() {
		$modules = BRJ_ThemeElements::get_modules();
		$sizes = $modules['brj-image-size'];
		if (!empty($sizes)) {
			foreach($sizes as $size) {
				$crop = false;
				if ($crop != 'default') {
					$crop = explode('-', $crop);
				}
				add_image_size($size->settings->handle, $size->settings->width, $size->settings->height, $crop);
			}
		}
	}

	static function filter_sizes($sizes) {
		$modules = BRJ_ThemeElements::get_modules();
		$modules = $modules['brj-image-size'];

		if (!empty($modules)) {
			foreach($modules as $module) {
				$handle = $module->settings->handle;
				$name = $module->settings->name;
				$sizes[$handle] = $name;
			}
		}
		return $sizes;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('BRJ_ImageSizeModule', array(
	'general'       => array(
		'title'         => __('General', 'fl-builder'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'name' => array(
						'type' => 'text',
						'label' => 'Name',
						'placeholder' => 'My Image Size',
                        'preview' => array(
                            'type' => 'text',
                            'selector' => '.image-size-name'
                        )
					),
					'handle' => array(
						'type' => 'text',
						'label' => 'Handle',
                        'placeholder' => 'my_handle'
					),
                    'width' => array(
                        'type' => 'text',
                        'label' => 'Width',
                        'preview' => array(
                            'type' => 'text',
                            'selector' => '.image-size-dimensions .width'
                        )
                    ),
                    'height' => array(
                        'type' => 'text',
                        'label' => 'Height',
                        'preview' => array(
                            'type' => 'text',
                            'selector' => '.image-size-dimensions .height'
                        )
                    ),
                    'crop' => array(
                        'type' => 'select',
                        'label' => 'Crop',
                        'default' => 'default',
                        'options'       => array(
                            'default'      => __( 'No', 'fl-builder' ),

                            'left-top' => __('Top Left', 'fl-builder'),
                            'center-top' => __('Top Center', 'fl-builder'),
                            'right-top' => __('Top Right', 'fl-builder'),

                            'left-center' => __('Center Left', 'fl-builder'),
                            'center-center' => __('Center', 'fl-builder'),
                            'right-center' => __('Center Right', 'fl-builder'),

                            'left-bottom' => __('Bottom Left', 'fl-builder'),
                            'center-bottom' => __('Bottom Center', 'fl-builder'),
                            'right-bottom' => __('Bottom Right', 'fl-builder'),
                        ),
                    ),
					/*
                    'color' => array(
                        'type' => 'color',
                        'label' => 'Background Color',
                        'default' => 'eee',
                        'preview' => array(
                            'type' => 'css',
                            'rules' => array(
                                array(
                                    'selector' => '.image-size',
                                    'property' => 'background-color'
                                )
                            )
                        )
                    )
					*/
				)
			)
		)
	)
));
