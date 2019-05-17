<?php
/**
 * LSX Health Plan Template Tags.
 *
 * @package lsx-health-plan
 */

/**
  * Outputs the warmup box on the single plan page.
  *
  * @return void
  */
function lsx_health_plan_warmup_box() { ?>
    <div class="col-md-4" >
        <div class="lsx-health-plan-box">
            <h3 class="title warm-up-title title-lined"><?php esc_html_e( 'Your Warm-up', 'lsx-health-plan' ); ?></h3>
            <div class="spacer"></div>
            <div class="excerpt">
                <p>Pellentesque non scelerisque dui.</p>
            </div>
            <a href="<?php the_permalink(); ?>warm-up/" class="btn"><?php esc_html_e( 'Start your warm-up', 'lsx-health-plan' ); ?></a>
        </div>
    </div>
<?php
}

/**
  * Outputs the workout box on the single plan page.
  *
  * @return void
  */
  function lsx_health_plan_workout_box() { ?>
    <div class="col-md-4" >
        <div class="lsx-health-plan-box">
            <h3 class="title work-out-title title-lined"><?php esc_html_e( 'Your Workout', 'lsx-health-plan' ); ?></h3>
            <div class="spacer"></div>
            <div class="excerpt">
                <p>Vestibulum quis mi eu nisl eleifend maximus.</p>
            </div>
            <a href="<?php the_permalink(); ?>workout/" class="btn"><?php esc_html_e( 'Start your workout', 'lsx-health-plan' ); ?></a>
        </div>
    </div>
<?php
}

/**
  * Outputs the meal plan box on the single plan page.
  *
  * @return void
  */
  function lsx_health_plan_meal_box() { ?>
    <div class="col-md-4" >
        <div class="lsx-health-plan-box">
            <h3 class="title meal-plan-title title-lined"><?php esc_html_e( 'Your Meal Plan', 'lsx-health-plan' ); ?></h3>
            <div class="spacer"></div>
            <div class="excerpt">
                <p>Nam vestibulum augue id condimentum consectetur.</p>
            </div>
            <a href="<?php the_permalink(); ?>meal/" class="btn"><?php esc_html_e( 'View your meal plan', 'lsx-health-plan' ); ?></a>
        </div>
    </div>
<?php
}

/**
  * Outputs the recipe box on the single plan page.
  *
  * @return void
  */
  function lsx_health_plan_recipe_box() { ?>
    <div class="col-md-4" >
        <div class="lsx-health-plan-box">
            <h3 class="title recipes-title title-lined"><?php esc_html_e( 'Recipes', 'lsx-health-plan' ); ?></h3>
            <div class="spacer"></div>
            <a href="<?php the_permalink(); ?>recipes/" class="btn"><?php esc_html_e( 'Recipe 1', 'lsx-health-plan' ); ?></a>
            <a href="<?php the_permalink(); ?>recipes/" class="btn"><?php esc_html_e( 'View all', 'lsx-health-plan' ); ?></a>
        </div>
    </div>
<?php
}

/**
  * Outputs the downloads box on the single plan page.
  *
  * @return void
  */
  function lsx_health_plan_downloads_box() { ?>
    <div class="col-md-4" >
        <div class="lsx-health-plan-box">
            <h3 class="title downloads-title title-lined"><?php esc_html_e( 'Downloads', 'lsx-health-plan' ); ?></h3>
            <div class="spacer"></div>
            <div class="download-list">
                <ul>
                    <?php
                        $downloads = \lsx_health_plan\functions\get_downloads();
                        if ( ! empty( $downloads ) ) {
                            foreach( $downloads as $download ) {
                                echo wp_kses_post( '<li><a href=""><i class="fa fa-file-pdf"></i>' . do_shortcode( '[download id="' . $download . '"]') . '</li>' );
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
<?php
}

/**
 * Only display the my account page is the user is logged out.
 *
 * @return string
 */
function lsx_health_plan_restricted_content() {
    $content = '';
    if ( ! is_user_logged_in() ) {
        ob_start();
        echo do_shortcode( '[woocommerce_my_account]' );
        $content = ob_get_clean();
    }  
    return $content;
}

/**
 * outputs the dynamic classes for the nav tabs.
 *
 * @param string $tab
 * @return void
 */
function lsx_health_plan_nav_class( $tab = '' ) {
    $nav_classes = array();
    if ( lsx_health_plan_is_current_tab( $tab ) ) {
        $nav_classes[] = 'active';
    }
    if ( ! empty( $nav_classes ) ) {
        echo wp_kses_post( implode( ' ', $nav_classes ) );
    }
}