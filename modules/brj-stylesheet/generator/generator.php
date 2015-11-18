
<?php
if (!empty($modules)) {
    foreach($modules as $module) {
        if ($module->settings->css) {
        $name = $module->settings->label;
        print "\n\n/* $name Stylesheet */\n";
        print $module->settings->css;
        }
    }
}
?>
