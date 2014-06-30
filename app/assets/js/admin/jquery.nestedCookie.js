/*
 * nestedCookie 1.1b, jQuery plugin
 * 
 * Copyright(c) 2011, Samuel De Backer
 * http://www.typi.be
 *	
 * nestedCookie create and read cookie to preserve open/close state
 * it also add alt+click functionnality
 * Thanks to jQuery community 
 * Licenced under the MIT Licence
 */
(function ($){
	var settings = {
		enableAltKey: true
	};
	var methods = {
		init: function (options) {
			return this.each( function() {
				
				if (options) {
					$.extend(settings, options);
				}
				
				var folderStateFromCookie, folderState, date, listLi, li;
				folderState = {};
				date = new Date();
				date.setDate(date.getDate() + 365);
				folderStateFromCookie = methods.readCookie('folderState');
				if (folderStateFromCookie !== null) {
					folderState = methods.objectFromCookie(folderStateFromCookie);
				}
				listLi = $(this).find('li');
				listLi.each(function () {
					if ($(this).hasClass('mjs-nestedSortable-branch') && folderState[$(this).attr('id')] === 'close') {
						$(this).addClass('mjs-nestedSortable-collapsed').removeClass('mjs-nestedSortable-expanded');
					}
				});
				$('.mjs-nestedSortable-branch .disclose').on('click', function (evt) {
					li = $(this).closest('li');
					li.toggleClass('mjs-nestedSortable-collapsed mjs-nestedSortable-expanded');

					if (li.hasClass('mjs-nestedSortable-collapsed')) {
						// console.log('Collapse');
						folderState[li.attr('id')] = 'close';
						if (evt.altKey === true && settings.enableAltKey === true) {
							li.find('.mjs-nestedSortable-branch').each(function () {
								$(this).addClass('mjs-nestedSortable-collapsed').removeClass('mjs-nestedSortable-expanded');
								folderState[$(this).attr('id')] = 'close';
							});
						}
					} else {
						// console.log('Expand');
						delete folderState[li.attr('id')];
						if (evt.altKey === true && settings.enableAltKey === true) {
							li.find('.mjs-nestedSortable-branch').each(function () {
								$(this).addClass('mjs-nestedSortable-expanded').removeClass('mjs-nestedSortable-collapsed');
								delete folderState[$(this).attr('id')];
							});
						}
					}
					document.cookie = 'folderState=' + methods.toSource(folderState) + '; expires=' + date.toUTCString();
				});

			});
		},

		readCookie: function (name) {
			var nameEQ, ca, i, c;
			nameEQ = name + '=';
			ca = document.cookie.split(';');
			for (i = 0; i < ca.length; i += 1) {
				c = ca[i];
				while (c.charAt(0) === ' ') {
					c = c.substring(1, c.length);
				}
				if (c.indexOf(nameEQ) === 0) {
					return c.substring(nameEQ.length, c.length);
				}
			}
			return null;
		},

		toSource: function (object) {
			var array, i;
			array = [];
			for (i in object) {
				if (object.hasOwnProperty(i)) {
					array.push(i + ':' + object[i]);
				}
			}
			return array.join(',');
		},

		objectFromCookie: function (str) {
			var parts, obj, i, machin;
			parts = str.split(',');
			obj = {};
			for (i = 0; i < parts.length; i += 1) {
				machin = parts[i].split(':');
				obj[machin[0]] = machin[1];
			}
			return obj;
		}		
	};
	$.fn.nestedCookie = function (method) {
		// Method calling logic
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.nestedCookie');
		}
	}
})(jQuery);
