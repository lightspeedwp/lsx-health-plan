var LSX_HP_SLIDER = Object.create(null);

(function($, window, document, undefined) {
	'use strict';

	LSX_HP_SLIDER.document = $(document);

	// Holds the slider function.
	LSX_HP_SLIDER.sliders = Object.create(null);

	// Holds the tip slider function.
	LSX_HP_SLIDER.tipSliders = Object.create(null);

	/**
	 * Start the JS Class
	 */
	LSX_HP_SLIDER.init = function() {
		LSX_HP_SLIDER.sliders.element = [];
		LSX_HP_SLIDER.sliders.element = jQuery(
			'.lsx-videos-shortcode.slick-slider, .lsx-hp-widget-items.slick-slider:not(.modal-slider)'
		);
		console.log(LSX_HP_SLIDER.sliders.element);
		if (0 < LSX_HP_SLIDER.sliders.element.length && undefined !== LSX_HP_SLIDER.sliders.element) {
			LSX_HP_SLIDER.sliders.init();
		}
		LSX_HP_SLIDER.sliders.element = jQuery('.lsx-recipes-shortcode.slick-slider');
		if (0 < LSX_HP_SLIDER.sliders.element.length && undefined !== LSX_HP_SLIDER.sliders.element) {
			LSX_HP_SLIDER.sliders.init();
		}

		LSX_HP_SLIDER.tipSliders.element = jQuery('.lsx-tips-shortcode.slick-slider');
		if (
			0 < LSX_HP_SLIDER.tipSliders.element.length &&
			undefined !== LSX_HP_SLIDER.tipSliders.element
		) {
			LSX_HP_SLIDER.tipSliders.init();
		}
	};

	/**
	 * Initiate the Sliders
	 */
	LSX_HP_SLIDER.sliders.init = function() {
		LSX_HP_SLIDER.sliders.element.each(function() {
			var slidesToShow = 1;
			var slidesToScroll = 1;
			var slickData = $(this).attr('data-slick');
			if (undefined !== slickData) {
				if (undefined !== slickData.slidesToShow) {
					slidesToShow = slickData.slidesToShow;
				}
				if (undefined !== slickData.slidesToScroll) {
					slidesToScroll = slickData.slidesToScroll;
				}
			}

			$(this).slick({
				dots: true,
				infinite: false,
				speed: 300,
				slidesToShow: slidesToShow,
				slidesToScroll: slidesToScroll,
				adaptiveHeight: true,
				responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: slidesToShow,
							slidesToScroll: slidesToScroll,
							infinite: true,
							dots: true,
						},
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
							arrows: false,
						},
					},
				],
			});
		});
	};

	/**
	 * Initiate the Sliders
	 */
	LSX_HP_SLIDER.tipSliders.init = function() {
		LSX_HP_SLIDER.tipSliders.element.each(function() {
			$(this).slick({
				dots: true,
				infinite: false,
				speed: 300,
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: true,
				adaptiveHeight: true,
			});
		});
	};

	/**
	 * On document ready.
	 *
	 * @package    lsx-health-plan
	 * @subpackage scripts
	 */
	LSX_HP_SLIDER.document.ready(function() {
		LSX_HP_SLIDER.init();
	});
})(jQuery, window, document);
