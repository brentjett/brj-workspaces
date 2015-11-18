<?php
$fn_name = $prefix . 'add_image_size_names';
?>

/**
/* Add Image Size Names to Chooser
*/
function <?php echo $fn_name ?>($sizes) {

<?php foreach($sizes as $size) {
    $handle = $size->settings->handle;
    $name = $size->settings->name;
    ?>
    $sizes['<?php echo $handle ?>'] = '<?php echo $name ?>';
<?php } ?>
    return $sizes;
}
add_filter('image_size_names_choose', '<?php echo $fn_name?>');
