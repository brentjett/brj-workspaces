(function($){

	FLBuilder.registerModuleHelper('brj-image-size', {

        init: function()
		{
			var form = $('.fl-builder-settings');
            var width = form.find('input[name=width]');
            var height = form.find('input[name=height]');
			var color = form.find('input[name=color]');

			// Validation events.
			//width.on('keyup', this.sizeChanged);
            //height.on('keyup', this.sizeChanged);
			//color.on('change', this.colorChanged);
		},
		/*
        sizeChanged: function() {

            var form = $('.fl-builder-settings');
			var node = form.data('node');
            var width = form.find('input[name=width]').val();
            var height = form.find('input[name=height]').val();
            var percentage = (height / width) * 100;
            console.log('size changed', width, height, percentage);
            $('.fl-module[data-node="' + node + '"] .image-size').before().css('padding-top', percentage + '%');
        },
		*/
        colorChanged: function() {
            var form = $('.fl-builder-settings');
			var node = form.data('node');
            var bg_color = form.find('input[name=color]').val();
			var rgb = brj_hexToRGB(bg_color);
			console.log(rgb);
			var bright = rgb.r + rgb.g + rgb.b > 382;
			if (bright) {
				// darken
				var color = brj_lightenDarkenColor(bg_color, -60);
			} else {
				// lighten
				var color = brj_lightenDarkenColor(bg_color, 60);
			}

            $('.fl-module[data-node="' + node + '"] .image-size').css('color', '#' + color);
            $('.fl-module[data-node="' + node + '"] .image-size').css('border-color', '#' + color);
        }

    });
})(jQuery);

function brj_hexToRGB(hex) {
	var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	return result ? {
		r: parseInt(result[1], 16),
		g: parseInt(result[2], 16),
		b: parseInt(result[3], 16)
	} : null;
}

function brj_lightenDarkenColor(col,amt) {
    var num = parseInt(col,16);
    var r = (num >> 16) + amt;
    var b = ((num >> 8) & 0x00FF) + amt;
    var g = (num & 0x0000FF) + amt;
    var newColor = g | (b << 8) | (r << 16);
    return newColor.toString(16);
}
