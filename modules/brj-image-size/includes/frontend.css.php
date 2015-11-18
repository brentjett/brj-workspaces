<?php
/*
$background_color = $settings->color;
if ($background_color) {
    // test brightness

    $r = hexdec(substr($background_color,0,2));
    $g = hexdec(substr($background_color,2,2));
    $b = hexdec(substr($background_color,4,2));
    $bright = $r + $g + $b > 382;
    if ($bright) {
        $color = FLBuilderColor::adjust_brightness( $background_color, 60, 'darken' );
    } else {
        $color = FLBuilderColor::adjust_brightness( $background_color, 60, 'lighten' );
    }
    ?>
    .fl-node-<?php echo $id; ?> .image-size {
        color: #<?php echo $color ?>;
        border-color: #<?php echo $color ?>;
        background-color: #<?php echo $background_color ?>;
        max-width: <?php echo $settings->width ?>px;
        margin:auto;
    }
    <?php
}
*/

if ($settings->height && $settings->width) {
    $pad = ($settings->height / $settings->width) * 100;
    ?>
    .fl-node-<?php echo $id; ?> .image-size:before {
        padding-top:<?php echo $pad ?>%;
    }
    .fl-node-<?php echo $id; ?> .image-size .image-size-inner {
        position: absolute;

        bottom:0px;
        left:0px;
        right:0px;
    }
    <?php
}
$accent_color = BRJ_WorkspaceModule::get_accent_color('brj-image-size');
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
