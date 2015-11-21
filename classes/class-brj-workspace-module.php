<?php
class BRJ_WorkspaceModule extends FLBuilderModule {

    public function __construct($args) {
        parent::__construct($args);

        $this->accent_color = $args['accent_color'];

        self::register_workspace_module($args);
		$this->add_css('brj-theme-elements-shared');

        add_action('wp', array($this, 'set_enabled') );
        add_filter('brj-workspace/filter-module-fields', 'BRJ_WorkspaceModule::filter_module_form', 10, 2);
    }

    function set_enabled() {
        global $post;
        if ($post->post_type != 'brj-workspace') {
            $this->enabled = false;
        }
    }

    static function get_accent_color($handle) {
        $global_settings = FLBuilderModel::get_global_settings();
        $accent_color_handle = $handle . '-accent-color';
        return $global_settings->{$accent_color_handle};
    }

    static function register_workspace_module($args) {
        $handle = $args['handle'];
        BRJ_ThemeElements::$worker_module_types[$handle] = $args;
    }

    /**
    * Placeholder function for subclasses to override.
    */
    static function get_fields() { return array(); }

    static function filter_module_form($form, $class_name) {
        $settings = array(
            'title' => 'Settings',
            'sections' => array(
                'general' => array(
                    'title' => '',
                    'fields' => array(
                        'enable' => array(
                            'type' => 'select',
                            'label' => 'Enable',
                            'options' => array(
                                'yes' => 'Yes',
                                'no' => 'No'
                            )
                        )
                    )
                )
            )
        );
        $settings = apply_filters('brj-workspace/filter-global-module-settings', $settings);
        if (!empty($settings)) {
            $form['settings'] = $settings;
        }
        return $form;
    }
}
