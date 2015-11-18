<?php
if (!has_action('brj_theme_elements_render/wp_enqueue_scripts')) return;
$fn_name = $prefix . 'enqueue_scripts';
?>

/**
* wp_enqueue_scripts action.
*/
function <?php echo $fn_name ?>() {
<?php do_action('brj_theme_elements_render/wp_enqueue_scripts') ?>
}
add_action('wp_enqueue_scripts', '<?php echo $fn_name ?>');
<?php
