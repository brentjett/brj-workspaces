(function($){

    var editor = ace.edit("stylesheet-<?php echo $id; ?>-frontend-editor");
    editor.setTheme("ace/theme/dawn");
    editor.getSession().setMode({path:"ace/mode/css", inline:true});
    editor.getSession().setUseWrapMode(true);
    editor.setOption('displayIndentGuides', true);
    editor.setShowPrintMargin(false);
    editor.setReadOnly(true);

})(jQuery);
