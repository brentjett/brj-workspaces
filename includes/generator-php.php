<?php
print "&lt;?php\n";
?>
/**
* Generated PHP - Add this to your functions.php file or any php file that has been included.
*/
<?php
do_action('brj_theme_elements_before_render_php');
// if anything is registered to this action
self::render_after_setup_theme();
self::render_wp_enqueue_scripts();
do_action('brj_theme_elements_render_filters', $prefix);
do_action('brj_theme_elements_after_render_php', $prefix);
print "?>";
