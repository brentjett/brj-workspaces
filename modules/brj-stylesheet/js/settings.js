(function($){
	FLBuilder.registerModuleHelper('brj-stylesheet', {

        init: function()
		{
			var form = $('.fl-builder-settings');
            var css = form.find('textarea[name=css]');
            console.log(css);


			// Validation events.
			css.on('change', this.cssChanged );
		},
        cssChanged: function() {
            console.log('test changed');
            var form = $('.fl-builder-settings');
            var css = form.find('textarea[name=css]');
			var node = form.data('node');
			if ($('#' + node + '-stylesheet')) {
				$('head').append('<style id="' + node + '-stylesheet"></style>');
			}
            $('#' + node + '-stylesheet').text(css.val());
        }
    });
})(jQuery);
