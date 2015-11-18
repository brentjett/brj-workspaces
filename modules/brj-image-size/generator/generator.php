<?php
print "\n\t// Image Sizes\n";
foreach($sizes as $size) {
$name = $size->settings->name;
$handle = strtolower(str_replace(' ', '_', $name));
$width = $size->settings->width;
$height = $size->settings->height;
$crop = $size->settings->crop;
if ($crop == 'default') {
    $crop = false;
} else {
    $crop = explode('-', $crop);
    $crop = ', array("' . $crop[0] . '", "' . $crop[1] . '")';
}
?>
    add_image_size('<?php echo $handle ?>', <?php echo $width ?>, <?php echo $height ?><?php echo $crop ?>);
<?php }
?>
