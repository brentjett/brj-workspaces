$ = jQuery.noConflict();
$(document).ready(function() {

    var theme = "ace/theme/clouds";

    var php_editor = ace.edit("php-editor");
    php_editor.setTheme(theme);
    php_editor.getSession().setMode({path:"ace/mode/php", inline:true});
    php_editor.getSession().setUseWrapMode(true);
    php_editor.setOption('displayIndentGuides', true);
    php_editor.setShowPrintMargin(false);
    php_editor.setReadOnly(true);

    var css_editor = ace.edit("css-editor");
    css_editor.setTheme(theme);
    css_editor.getSession().setMode({path:"ace/mode/css", inline:true});
    css_editor.getSession().setUseWrapMode(true);
    css_editor.setOption('displayIndentGuides', true);
    css_editor.setShowPrintMargin(false);
    css_editor.setReadOnly(true);

    $('.editor-tab').on('click', function() {
        var tab = $(this).data('trigger-tab');
        $('.editor-tab.active').removeClass('active');
        $('.' + tab + '-tab').addClass('active');
        if (tab == 'php') {
            $('#php-editor').show();
            $('#css-editor').hide();
        } else {
            $('#php-editor').hide();
            $('#css-editor').show();
        }
    });
});
