<?php
/**
 * Template used to display post content on widgets and archive pages.
 *
 * @package lsx-health-plan
 */

lsx_entry_before();
$tip_id         = get_the_id();
$featured_image = get_the_post_thumbnail( $tip_id, array( 600, 300 ) );
?>
<div class="content-box box-shadow diet-tip-wrapper quick-tip">
	<div class="row">
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
			<?php lsx_get_svg_icon( 'meal.svg' ); ?>
		</div>
		<div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
			<h3 class="tip-title"><?php the_title(); ?></h3>
			<?php the_content(); ?>
		</div> 
	</div>
</div>
<?php
lsx_entry_after();
