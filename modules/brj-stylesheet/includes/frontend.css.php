<?php
$accent_color = BRJ_WorkspaceModule::get_accent_color('brj-stylesheet');
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
