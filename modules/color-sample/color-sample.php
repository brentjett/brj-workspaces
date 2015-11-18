<?php

/**
 * @class FLVideoModule
 */
class BRJ_ColorSampleModule extends BRJ_WorkspaceModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          => __('Color Sample', 'fl-builder'),
			'description'   => __('Render a color sample block', 'fl-builder'),
			'category'      => BB_THEME_ELEMENTS_MODULE_CATEGORY,
			'dir'           => BB_THEME_ELEMENTS_DIR . 'modules/color-sample/',
            'url'           => BB_THEME_ELEMENTS_URL . 'modules/color-sample/',
		));
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('BRJ_ColorSampleModule', array(
	'general'       => array(
		'title'         => __('General', 'fl-builder'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'color' => array(
						'type' => 'color',
						'label' => 'Color',

					),
					'name' => array(
						'type' => 'text',
						'label' => 'Name'
					),
					'rules' => array(
						'type' => 'form',
						'label' => 'Target',
						'multiple' => true
					)
				)
			)
		)
	)
));
