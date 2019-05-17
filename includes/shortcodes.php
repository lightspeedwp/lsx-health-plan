<?php
namespace lsx_health_plan\shortcodes;
/**
 * LSX Health Plan Conditional Helpers.
 *
 * @package lsx-health-plan
 */

/**
 * Only display the my account page is the user is logged out.
 *
 * @return string
 */
function restricted_content() {
    $content = '';
    if ( ! is_user_logged_in() ) {
        ob_start();
        echo do_shortcode( '[woocommerce_my_account]' );
        $content = ob_get_clean();
    }  
    return $content;
}

 /**
  * outputs the my profile box on the frontpage
  *
  * @return void
  */
function my_profile_box() {
    ob_start();
    echo lsx_health_plan_my_profile_box();
    $content = ob_get_clean();
    return $content;
}