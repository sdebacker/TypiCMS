/*
 * Slug 1.0, jQuery plugin
 * 
 * Copyright(c) 2013, Samuel De Backer
 * http://www.typi.be
 *	
 * Transform field to slug.
 * Thanks to jQuery community 
 * Licenced under the MIT Licence
 */
(function($)
{
	var settings = {
		slugField: '#slug'
	};
	var methods = {
		init: function (options) {
			return this.each(function() {

				if (options) {
					$.extend(settings, options);
				}

				this.slugField = settings.slugField;

				$(this).keyup(methods.convertToSlug);

			});
		},
		convertToSlug: function () {

			var slugcontent = $(this).val()
				.replace('œ','oe')
				.replace('æ','ae');

			// remove accents, swap ñ for n, etc
			var from = "ÃÀÁÄÂẼÈÉËÊÌÍÏÎÕÒÓÖÔÙÚÜÛÑÇãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;-";
			var to   = "AAAAAEEEEEIIIIOOOOOUUUUNCaaaaaeeeeeiiiiooooouuuunc       ";
			for (var i=0, l=from.length ; i<l ; i++) {
				slugcontent = slugcontent.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
			}

			slugcontent = slugcontent
				.toLowerCase()
				.replace(/[^\w ]+/g,'')
				.replace(/ +/g,'-');

			$(this.slugField).val(slugcontent);

		},

	};
	$.fn.slug = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method == 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.slug');
		}
	};
})(jQuery);
