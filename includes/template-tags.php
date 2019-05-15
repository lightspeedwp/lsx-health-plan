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
            <h3 class="title"><?php esc_html_e( 'Your Warmup', 'lsx-health-plan' ); ?></h3>
            <div class="spacer"></div>
            <div class="excerpt">
                <p>Pellentesque non scelerisque dui.</p>
            </div>
            <?php 
            $warm_ups = get_post_meta( get_the_ID(), 'plan_warmup', true );

            if ( ! empty( $warm_ups ) ) {
                foreach( $warm_ups as $warm_up ) {
                    ?>
                        <a href="<?php echo wp_kses_post( get_the_permalink( $warm_up ) ); ?>" class="btn"><?php esc_html_e( 'Start your warmup', 'lsx-health-plan' ); ?></a>
                    <?php
                }
            }?>
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
            <h3 class="title"><?php esc_html_e( 'Your Workout', 'lsx-health-plan' ); ?></h3>
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
            <h3 class="title"><?php esc_html_e( 'Your Meal Plan', 'lsx-health-plan' ); ?></h3>
            <div class="spacer"></div>
            <div class="excerpt">
                <p>Nam vestibulum augue id condimentum consectetur.</p>
            </div>
            <a href="#" class="btn"><?php esc_html_e( 'View your meal plan', 'lsx-health-plan' ); ?></a>
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
            <h3 class="title"><?php esc_html_e( 'Recipes', 'lsx-health-plan' ); ?></h3>
            <div class="spacer"></div>
            <a href="#" class="btn"><?php esc_html_e( 'Recipe 1', 'lsx-health-plan' ); ?></a>
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
            <h3 class="title"><?php esc_html_e( 'Downloads', 'lsx-health-plan' ); ?></h3>
            <div class="spacer"></div>
            <div class="download-list">
                <ul>
                    <li><a href=""><i class="fa fa-file-pdf"></i> Workout PDF</a></li>
                    <li><a href=""><i class="fa fa-file-pdf"></i> Recipe PDF</a></li>
                    <li><a href=""><i class="fa fa-file-pdf"></i> Download PDF</a></li>
                </ul>
            </div>
        </div>
    </div>
<?php
}