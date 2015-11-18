<?php
class BRJ_WorkspaceModule extends FLBuilderModule {

    public function __construct($args) {

        if (!isset($args['enabled'])) {
            $args['enabled'] = self::is_enabled();
        }
        parent::__construct($args);

        $this->accent_color = $args['accent_color'];

        self::register_workspace_module($args);
		$this->add_css('brj-theme-elements-shared');
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

    static function is_enabled() {
        global $post;
        /*
        // I don't know why this isn't working
        print_r($post->post_type);
        if ($post->post_type != "brj-workspace") {
            return false;
        }
        */
        return true;
    }
}
