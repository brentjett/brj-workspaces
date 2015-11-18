<?php
ob_start();
do_action('brj_theme_elements/generate_css');
$css = ob_get_clean();
if (!trim($css)) {
    $css = "/*\n";
    $css .= "No CSS to see yet. How bout make some!\n";
    $css .= "*/\n";
}
print $css;
?>
