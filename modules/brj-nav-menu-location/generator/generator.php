<?php
print "\n\t// Nav Menu Locations\n";
foreach($locations as $location) {
$handle = $location->settings->handle;
$label = $location->settings->label;
?>
    register_nav_menu('<?php echo $handle ?>', '<?php echo $label ?>');
<?php }
?>
