function initTinymce(selector) {
	tinymce.init({
		selector: selector,
		fix_list_elements : true,
		relative_urls: false,
		height : 400,
		menubar: false,
		entity_encoding : 'raw',
		plugins: 'paste,table,nonbreaking,link,code,image',
		// statusbar: false,
		style_formats : [
			{title : 'File (link)', selector : 'a', classes : 'file'},
			{title : 'Button (link)', selector : 'a', classes : 'btn'},
		],
		content_css : '/plugins/tinymce/css/tiny_mce.css',
		toolbar: 'formatselect | styleselect | bold italic | subscript superscript | bullist numlist outdent indent | link unlink | alignleft aligncenter alignright alignjustify | table | nonbreaking | image | code',
		language_url: '/plugins/tinymce/langs/fr.js'
	});
}

!function( $ ){

	"use strict";

	$(function () {

		for (var i = 0; i < langues.length; i++) {
			var titleField = $('#' + langues[i] + '\\[title\\]');
			if ( ! titleField.val()) {
				titleField.slug({
					slugField: '#' + langues[i] + '\\[slug\\]',
				});
			};
		};

		initTinymce('.editor');

		if ($('.datepicker').length) {
			$('.datepicker').parent().parent().datetimepicker({
				format: 'dd.MM.yyyy',
				pickTime: false,
				language: lang
			});
		};

		if ($('.hourpicker').length) {
			$('.hourpicker').parent().parent().datetimepicker({
				pickDate: false,
				pickSeconds: false,
				language: lang
			});
		};


	});

}( window.jQuery || window.ender );
