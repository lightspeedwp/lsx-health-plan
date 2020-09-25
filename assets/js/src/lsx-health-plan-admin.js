/**
 * LSX Health Plan scripts (admin).
 *
 * @package lsx-health-plan
 */

var LSX_HP_ADMIN = Object.create(null);

(function($, window, document, undefined) {
	'use strict';

	LSX_HP_ADMIN.document = $(document);

	/**
	 * Start the JS Class
	 */
	LSX_HP_ADMIN.init = function() {
		LSX_HP_ADMIN.changeName();
		LSX_HP_ADMIN.singleExerciseRemoveClass();
		LSX_HP_ADMIN.calculateBMI();
		LSX_HP_ADMIN.setListLayout();
		LSX_HP_ADMIN.initIsotope();
		LSX_HP_ADMIN.removeOriginalTeamTabs();
		LSX_HP_ADMIN.progressBar();
	};

	LSX_HP_ADMIN.changeName = function() {
		$('.wpua-edit .button')
			.last()
			.attr('value', 'Update Profile Image');
	};

	/**
	 * All Meta Tag terms will have target blank
	 */
	LSX_HP_ADMIN.singleExerciseRemoveClass = function() {
		$('body.single-exercise').removeClass('using-gutenberg');
	};

	/**
	 * Calculate BMI
	 */
	LSX_HP_ADMIN.calculateBMI = function() {
		$('.woocommerce-MyAccount-content .my-stats-wrap .calculate-bmi .btn').on('click', function(e) {
			e.preventDefault();
			var weight = $(
				'.woocommerce-MyAccount-content .my-stats-wrap #weight_field .input-text'
			).val();
			var height = $(
				'.woocommerce-MyAccount-content .my-stats-wrap #height_field .input-text'
			).val();

			var height_m = height / 100;
			var resultText = '';

			if (1 < weight && 1 < height_m) {
				var bmi = weight / (height_m * height_m);
				var bmiRound = bmi.toFixed(1);

				// (C) Show Results
				if (bmiRound < 18.5) {
					resultText = bmiRound + ' - Underweight';
				} else if (bmiRound < 25) {
					resultText = bmiRound + ' - Normal weight';
				} else if (bmiRound < 30) {
					resultText = bmiRound + ' - Pre-obesity';
				} else if (bmiRound < 35) {
					resultText = bmiRound + ' - Obesity class I';
				} else if (bmiRound < 40) {
					resultText = bmiRound + ' - Obesity class II';
				} else {
					resultText = bmiRound + ' - Obesity class III';
				}

				$('.woocommerce-MyAccount-content .my-stats-wrap .description .bmi-title').append(
					'<p class="btn border-btn bmi-total">BMI: ' + resultText + '</p>'
				);
			}
		});
	};

	/**
	 * Add extra class for list layout workouts
	 */
	LSX_HP_ADMIN.setListLayout = function() {
		var workoutList = $('.set-box .set-list .workout-list');
		workoutList.each(function() {
			var listLength = $(this).children().length;
			if (3 < listLength) {
				$(this).addClass('longer-list');
			}
		});
	};

	/**
	 * Add extra class for progress bar
	 */
	LSX_HP_ADMIN.progressBar = function() {
		var progressBar = $('.progress progress');
		progressBar.each(function() {
			var progressBarLength = $(this).val();
			if (50 > progressBarLength) {
				$(this).addClass('less-progress');
			}
			if (50 <= progressBarLength) {
				$(this).addClass('half-progress');
			}
			if (100 == progressBarLength) {
				$(this).addClass('completed-progress');
			}
		});
	};

	/**
	 * Removes the original team tabs in favor of the HP tabs
	 */
	LSX_HP_ADMIN.removeOriginalTeamTabs = function() {
		$('.single-team .entry-tabs:not(.hp-entry-tabs)').remove();
		$('.single-team .entry-tabs.hp-entry-tabs .lsx-sharing-wrapper').remove();
	};

	/**
	 * Filter nav for archives
	 */
	LSX_HP_ADMIN.initIsotope = function() {
		if (
			$('body')
				.first()
				.hasClass('archive') &&
			$.isFunction($.fn.isotope)
		) {
			var $container = $('.lsx-plan-row');

			$container.isotope({
				itemSelector: '.lsx-plan-column',
				layoutMode: 'fitRows',
			});

			var $option_sets = $('.lsx-type-nav-filter'),
				$option_links = $option_sets.find('a');

			$option_links.click(function() {
				var $this = $(this);

				if ($this.parent().hasClass('active')) {
					return false;
				}

				$option_sets.find('.active').removeClass('active');
				$this.parent().addClass('active');

				var selector = $(this).attr('data-filter');
				$container.isotope({ filter: selector });

				return false;
			});

			setTimeout(function() {
				$container.isotope();
			}, 300);

			$(document).on('lazybeforeunveil', function() {
				setTimeout(function() {
					$container.isotope();
				}, 300);
			});

			$(window).load(function() {
				$container.isotope();
			});
		}
	};

	/**
	 * On document ready.
	 *
	 * @package    lsx-health-plan
	 * @subpackage scripts
	 */
	LSX_HP_ADMIN.document.ready(function() {
		LSX_HP_ADMIN.init();
	});
})(jQuery, window, document);
