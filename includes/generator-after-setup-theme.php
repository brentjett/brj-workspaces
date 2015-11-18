<?php
if (!has_action('brj_theme_elements_render/after_setup_theme')) return;
$fn_name = $prefix . 'after_setup_theme';
?>

/**
* after_theme_setup action.
*/
function <?php echo $fn_name ?>() {
<?php do_action('brj_theme_elements_render/after_setup_theme') ?>
}
add_action('after_setup_theme', '<?php echo $fn_name ?>');
<?php
