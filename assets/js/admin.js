/**
 * Asahi Music Theme — admin behaviours.
 * Wire the "從媒體庫選擇/上傳音檔" button to the WordPress media library
 * (audio items only) and write the selected URL back into the MP3 field.
 */
(function ($) {
	'use strict';

	$(function () {
		var frame;

		$('.asahi-media-upload').on('click', function (e) {
			e.preventDefault();

			var button = $(this);
			var input = button.closest('.asahi-media-field').find('.asahi-media-url');

			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media({
				title: '選擇或上傳音檔',
				library: { type: 'audio' },
				button: { text: '使用此音檔' },
				multiple: false
			});

			frame.on('select', function () {
				var attachment = frame.state().get('selection').first().toJSON();
				input.val(attachment.url);
			});

			frame.open();
		});
	});
})(jQuery);
