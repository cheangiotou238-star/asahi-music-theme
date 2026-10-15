/**
 * Asahi Music Theme — front-end behaviours.
 * - Initialise Plyr on all `.plyr-audio` elements.
 * - Extract the cover's dominant colour via Color Thief and apply a soft
 *   dark gradient to the page background.
 */
(function () {
	'use strict';

	function initPlyr() {
		if (typeof Plyr === 'undefined') {
			return;
		}
		document.querySelectorAll('.plyr-audio').forEach(function (el) {
			new Plyr(el, {
				controls: ['play', 'progress', 'current-time', 'duration', 'mute', 'volume']
			});
		});
	}

	function applyBackgroundPalette(palette) {
		if (!palette || palette.length < 3) {
			return;
		}
		var r = palette[0];
		var g = palette[1];
		var b = palette[2];

		// Darken the dominant colour to keep text readable.
		var top = [Math.max(0, Math.round(r * 0.12)), Math.max(0, Math.round(g * 0.12)), Math.max(0, Math.round(b * 0.12))];
		var bottom = [Math.max(0, Math.round(r * 0.28)), Math.max(0, Math.round(g * 0.28)), Math.max(0, Math.round(b * 0.28))];

		var gradient = 'linear-gradient(160deg, rgb(' + top.join(', ') + ') 0%, rgb(' + bottom.join(', ') + ') 100%)';
		document.body.style.background = gradient;
		document.body.style.backgroundColor = 'rgb(' + bottom.join(', ') + ')';
	}

	function initColorThief() {
		var img = document.getElementById('song-cover-img');
		if (!img || typeof ColorThief === 'undefined') {
			return;
		}

		var colorThief = new ColorThief();

		function extract() {
			try {
				applyBackgroundPalette(colorThief.getColor(img));
			} catch (err) {
				// Ignore canvas/CORS errors; fall back to the default background.
			}
		}

		if (img.complete && img.naturalWidth > 0) {
			extract();
		} else {
			img.addEventListener('load', extract);
		}
	}

	document.addEventListener('DOMContentLoaded', function () {
		initPlyr();
		initColorThief();
	});
})();
