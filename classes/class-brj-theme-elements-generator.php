<?php
class BRJ_ThemeElementsGenerator {

    // Helper function for generating array declarations.
    static function print_array($name, $array, $line_start) {
        if (!empty($array)) {
            print $line_start . '$' . $name . ' = array(' . "\n";
            foreach($array as $key => $val) {
                // quote the key if it's a string.
                if (is_string($key)) {
                    $key = "'" . $key . "'";
                }

                $val_type = gettype($val);
                if ($val_type == 'string') {
                    if ($val == '') continue;
                    $val = "'" . $val . "'";
                }
                if ($val_type == 'boolean') {
                    if ($val == true) $val = 'true';
                    if ($val == false) $val = 'false';
                }
                print $line_start . "\t" . $key . " => " . $val . ",\n";
            }
            print $line_start . ");\n";
        }
    }

    // Ouput Generated PHP
    static function render_php() {
        $prefix = self::get_prefix();
        include BB_THEME_ELEMENTS_DIR . '/includes/generator-php.php';
    }

    static function render_css() {
        include BB_THEME_ELEMENTS_DIR . '/includes/generator-css.php';
    }

    static function render_after_setup_theme() {
        $prefix = self::get_prefix();
        include BB_THEME_ELEMENTS_DIR . '/includes/generator-after-setup-theme.php';
    }

    static function render_wp_enqueue_scripts() {
        $prefix = self::get_prefix();
        include BB_THEME_ELEMENTS_DIR . '/includes/generator-wp-enqueue-scripts.php';
    }

    static function get_prefix() {
        return 'demo_';
    }
}
?>
