<?php
if ($settings->crop == 'default') {
    $cropped_label = "";
} else {
    $value = $settings->crop;
    $cropped_label = "Cropped to $value";
}

?>
<div class="image-size theme-element-module">
    <div class="image-size-inner">
        <div class="image-size-name"><span class="accent-color"><?php echo $settings->name ?></span> <?php _e('Image Size', 'fl-builder')?></div>
        <div class="image-size-dimensions"><span class="width"><?php echo $settings->width?></span> x <span class="height"><?php echo $settings->height ?></span></div>
        <?php if ($cropped_label) { ?>
            <div class="image-size-crop"><?php echo $cropped_label ?></div>
        <?php } ?>
    </div>
</div>
