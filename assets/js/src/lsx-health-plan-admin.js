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
			if (1 < weight && 1 < height_m) {
				var bmi = weight / (height_m * height_m);
				var bmiRound = bmi.toFixed(1);
				$('.woocommerce-MyAccount-content .my-stats-wrap .my-stats').append(
					'<p class="form-row bmi-total">BMI: ' + bmiRound + '</p>'
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
	 * On document ready.
	 *
	 * @package    lsx-health-plan
	 * @subpackage scripts
	 */
	LSX_HP_ADMIN.document.ready(function() {
		LSX_HP_ADMIN.init();
	});
})(jQuery, window, document);
