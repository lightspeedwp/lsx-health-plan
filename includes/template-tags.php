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
            <h3 class="title"><?php esc_html_e( 'Your Warmup', '' ); ?></h3>
            <div class="spacer"></div>
            <div class="excerpt">
                <p>Dont underestimate sdfsdsdsdf</p>
            </div>
            <a href="#" class="btn"><?php esc_html_e( 'Start your warmup', '' ); ?></a>
        </div>
    </div>
<?php
}