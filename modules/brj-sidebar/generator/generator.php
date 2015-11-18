<?php
print "\n\t// Sidebars\n";
foreach($modules as $module) {
$args = self::get_args($module);
BRJ_ThemeElementsGenerator::print_array('args', $args, "\t");
?>
    register_sidebar($args);
<?php } ?>
