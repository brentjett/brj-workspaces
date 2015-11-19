<?php
if ($settings->css) {
    $text = $settings->css;
} else {
    $text = __('/* No Styles Defined */', 'brj-workspaces');
}
?>
<div class="stylesheet theme-element-module brj-workspace-module">
    <div class="module-heading"><span class="accent-color"><span class="fa fa-th-list"></span> <?php echo $settings->label ?></span> Stylesheet</div>
    <div id="stylesheet-<?php echo $id; ?>-frontend-editor" class="stylesheet-frontend-editor"><?php echo $text ?></div>
</div>
