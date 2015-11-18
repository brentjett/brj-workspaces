<?php
print "\n\t// Register Post Types\n";
foreach($post_types as $post_type) {
$name = $post_type->settings->label;
$handle = $post_type->settings->handle;
$labels = self::get_labels($post_type);
$args = self::get_args($post_type);
print "\t// $name Post Type \n";
BRJ_ThemeElementsGenerator::print_array('args', $args, "\t");
if (!empty(array_values($labels))) {
BRJ_ThemeElementsGenerator::print_array('labels', $labels, "\t");
print "\t" . '$args["labels"] = $labels;' . "\n";
}
?>
    register_post_type('<?php echo $handle ?>', $args);

<?php
}
?>
