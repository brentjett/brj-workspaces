(function($){

	FLBuilder.registerModuleHelper('color-sample', {

        init: function()
		{
			var form = $('.fl-builder-settings');
            var color = form.find('input[name=color]');

			// Validation events.
			color.on('change', this.colorChanged);
		},

        colorChanged: function() {

            var form = $('.fl-builder-settings');
			var node = form.data('node');
            var color = form.find('input[name=color]');
            val = color.val();
            console.log(val, node);
            $('.fl-module[data-node="' + node + '"] .color-sample-module').css('background-color', '#' + val);
			$('.fl-module[data-node="' + node + '"] .sample-hex').text('#' + val);
        }

    });

})(jQuery);
