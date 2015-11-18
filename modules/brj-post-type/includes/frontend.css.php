<?php
$global_settings = FLBuilderModel::get_global_settings();
$accent_color_handle = 'brj-post-type-accent-color';
$accent_color = $global_settings->{$accent_color_handle};
?>
.fl-node-<?php echo $id; ?> .fl-module-content {
    border-top: 5px solid #<?php echo $accent_color ?>;
}
.fl-node-<?php echo $id; ?> .theme-element-module {
    border-top:none;
}
.fl-node-<?php echo $id; ?> .accent-color {
    color: #<?php echo $accent_color ?>;
}
