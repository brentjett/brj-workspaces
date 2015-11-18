<?php

class BRJ_PostTypeModule extends BRJ_WorkspaceModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'          => __('Custom Post Type', 'fl-builder'),
			'description'   => __('Create A Custom Post Type', 'fl-builder'),
			'category'      => BB_THEME_ELEMENTS_MODULE_CATEGORY,
			'dir'           => BB_THEME_ELEMENTS_DIR . 'modules/brj-post-type/',
            'url'           => BB_THEME_ELEMENTS_URL . 'modules/brj-post-type/',
			'handle' => 'brj-post-type',
			'label' => __('Post Type', 'fl-builder'),
			'label_plural' => __('Post Types', 'fl-builder'),
			'label_field' => 'label',
			'accent_color' => '02A6D0'
		));
		$this->add_css('brj-theme-elements-shared');

		add_action('brj_theme_elements_render/after_setup_theme', 'BRJ_PostTypeModule::render_php');
		add_action('after_setup_theme', 'BRJ_PostTypeModule::register_post_types');
	}

	static function get_labels($module) {
		$properties = array(
			'name',
			'singular_name',
			'menu_name',
			'name_admin_bar',
			'parent_item_colon',
			'all_items',
			'add_new_item',
			'add_new',
			'new_item',
			'edit_item',
			'update_item',
			'view_item',
			'search_items',
			'not_found',
			'not_found_in_trash',
			'items_list',
			'items_list_navigation',
			'filter_items_list'
		);
		foreach($properties as $prop) {
			if (isset($module->settings->{$prop})) {
				$labels[$prop] = $module->settings->{$prop};
			}
		}
		return $labels;
	}
	static function get_args($module) {
		$supports = "";
		$args = array();
		$properties = array(
			'label',
			'description',
			'supports',
			'taxonomies',
			'hierarchical',
			'public',
			'show_ui',
			'show_in_menu',
			'menu_position',
			'menu_icon',
			'show_in_admin_bar',
			'show_in_nav_menus',
			'can_export',
			'has_archive',
			'exclude_from_search',
			'publicly_queryable',
			'capability_type'
		);
		foreach($properties as $prop) {
			if (isset($module->settings->{$prop})) {
				$args[$prop] = $module->settings->{$prop};
			}
		}
		$args['public'] = self::convert_value($args['public'], 'bool');
		$args['show_ui'] = self::convert_value($args['show_ui'], 'bool');
		$args['hierarchical'] = self::convert_value($args['hierarchical'], 'bool');
		$args['show_in_admin_bar'] = self::convert_value($args['show_in_admin_bar'], 'bool');
		$args['show_in_nav_menus'] = self::convert_value($args['show_in_nav_menus'], 'bool');
		$args['can_export'] = self::convert_value($args['can_export'], 'bool');
		$args['has_archive'] = self::convert_value($args['has_archive'], 'bool');
		$args['publicly_queryable'] = self::convert_value($args['publicly_queryable'], 'bool');
		$args['exclude_from_search'] = self::convert_value($args['exclude_from_search'], 'bool');


		if (isset($args['menu_icon'])) {
			$args['menu_icon'] = str_replace('dashicons dashicons-before ', '', $args['menu_icon']);
		}
		return $args;
	}

	static function register_post_types() {
		$modules = BRJ_ThemeElements::get_modules();
		$post_types = $modules['brj-post-type'];
		if (!empty($post_types)) {
			foreach($post_types as $module) {
				$handle = $module->settings->handle;
				$labels = self::get_labels($module);
				$args = self::get_args($module);
				register_post_type($handle, $args);
			}
		}
	}

	static function render_php() {
		$modules = BRJ_ThemeElements::get_modules();
		$post_types = $modules['brj-post-type'];
		if (!empty($post_types)) {
			require dirname(__FILE__) . '/generator/generator.php';
		}
	}

	static function convert_value($var, $type) {
		if ($type == 'bool') {
			if ($var == 'true') {
				$var =  true;
			} else if ($var == 'false') {
				$var = false;
			}
		}
		return $var;
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('BRJ_PostTypeModule', array(
	'general'       => array(
		'title'         => __('General', 'fl-builder'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'label' => array(
						'type' => 'text',
						'label' => 'Label',
                        'preview' => array(
                            'type' => 'text',
                            'selector' => '.post-type-name'
                        )
					),
					'handle' => array(
						'type' => 'text',
						'label' => 'Handle',
						'placeholder' => 'my_post_type'
					),
					'description' => array(
						'type' => 'textarea',
						'label' => 'Description'
					),
					'hierarchical' => array(
						'type' => 'select',
						'label' => 'Hierarchical',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
					'menu_icon' => array(
						'type' => 'icon',
						'label' => 'Menu Icon',
						'description' => 'Choose an icon from the dashicons collection'
					),
					'menu_position' => array(
						'type' => 'text',
						'label' => 'Menu Position'
					),

					'can_export' => array(
						'type' => 'select',
						'label' => 'Can Be Exported',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
					'has_archive' => array(
						'type' => 'select',
						'label' => 'Has Archive',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
				)
			)
		)
	),
	'labels' => array(
		'title' => __('Labels', 'fl-builder'),
		'sections' => array(
			'general' => array(
				'title' => '',
				'fields' => array(
					'name' => array(
						'type' => 'text',
						'label' => 'Name (plural)'
					),
					'singular_name' => array(
						'type' => 'text',
						'label' => 'Name (singular)'
					),
					'menu_name' => array(
						'type' => 'text',
						'label' => 'Menu Name'
					),
					'name_admin_bar' => array(
						'type' => 'text',
						'label' => 'Admin Bar Name'
					),
					'parent_item_colon' => array(
						'type' => 'text',
						'label' => 'Parent Item Name',
						'placeholder' => 'Parent Item:'
					),
					'all_items' => array(
						'type' => 'text',
						'label' => 'All Items'
					),
					'add_new_item' => array(
						'type' => 'text',
						'label' => 'Add New Item'
					)
				)
			)
		)
	),
	'visibility' => array(
		'title' => 'Visibility',
		'sections' => array(
			'general' => array(
				'title' => '',
				'fields' => array(
					'public' => array(
						'type' => 'select',
						'label' => 'Public',
						'default' => 'true',
						'options' => array( 'false' => 'No', 'true' => 'Yes')
					),
					'show_ui' => array(
						'type' => 'select',
						'label' => 'Show UI',
						'default' => 'true',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
					'show_in_admin_bar' => array(
						'type' => 'select',
						'label' => 'Show In Admin Bar',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
					'show_in_nav_menus' => array(
						'type' => 'select',
						'label' => 'Show In Nav Menus',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
					'exclude_from_search' => array(
						'type' => 'select',
						'label' => 'Exclude From Search',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
					'publicly_queryable' => array(
						'type' => 'select',
						'label' => 'Publicly Queryable',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
				)
			)
		)
	),
	'supports' => array(
		'title' => 'Supports',
		'sections' => array(
			'general' => array(
				'title' => '',
				'fields' => array(
					'title' => array(
						'type' => 'select',
						'label' => 'Title',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
					'editor' => array(
						'type' => 'select',
						'label' => 'Editor',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
					'excerpt' => array(
						'type' => 'select',
						'label' => 'Excerpt',
						'options' => array('false' => 'No', 'true' => 'Yes')
					),
				)
			)
		)
	)
));
