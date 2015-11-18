<?php
$type = strtolower(str_replace(' ', '_', $settings->label));
$count = wp_count_posts($type);
?>
<div class="post-type post-type-<?php echo $type ?> theme-element-module">
    <div><span class="menu-icon accent-color <?php echo $settings->menu_icon ?>"></span> <span class="post-type-name accent-color"><?php echo $settings->label ?></span> Post Type <?php /*<span class="post-count"><?php echo $count->publish ?> posts</span> */ ?></div>
</div>
