<?php
$prep_time     = get_post_meta( get_the_ID(), 'recipe_prep_time', true );
$cooking_time  = get_post_meta( get_the_ID(), 'recipe_cooking_time', true );
$serves        = get_post_meta( get_the_ID(), 'recipe_serves', true );
$portion       = get_post_meta( get_the_ID(), 'recipe_portion', true );
$energy        = get_post_meta( get_the_ID(), 'recipe_energy', true );
$protein       = get_post_meta( get_the_ID(), 'recipe_protein', true );
$carbohydrates = get_post_meta( get_the_ID(), 'recipe_carbohydrates', true );
$fibre         = get_post_meta( get_the_ID(), 'recipe_fibre', true );
$fat           = get_post_meta( get_the_ID(), 'recipe_fat', true );
?>
<?php if ( ( ! empty( $prep_time ) ) || ( ! empty( $cooking_time ) ) || ( ! empty( $serves ) ) || ( ! empty( $portion ) ) ) { ?>
<table class="recipe-table cooking-info-table">
	<?php if ( is_single() && is_singular( 'recipe' ) ) { ?>
		<thead>
			<tr>
				<th>Cooking Info</th>
			</tr>
		</thead>
	<?php } ?>
	<tbody>
		<?php
		if ( 1 >= (int) $serves ) {
			$serves       = '1';
			$serves_label = __( 'Person', 'lsx-health-plan' );
		} else {
			$serves_label = __( 'People', 'lsx-health-plan' );
		}
		?>
		<tr class="serves">
			<td><?php esc_html_e( 'Serves:', 'lsx-health-plan' ); ?>&nbsp;</td>
			<td>
			<?php
				echo wp_kses_post( $serves ) . ' ' . esc_html( $serves_label );
			?>
			</td>
		</tr>
		<?php
		if ( ! empty( $prep_time ) ) {
		?>
		<tr class="prep-time">
		<td><?php esc_html_e( 'Prep time: ', 'lsx-health-plan' ); ?>&nbsp;</td>
			<td>
			<?php
				echo wp_kses_post( $prep_time );
			?>
			</td>
		</tr>
		<?php
		}
		?>
		<?php
		if ( ! empty( $cooking_time ) ) {
		?>
		<tr class="cooking-time">
			<td><?php esc_html_e( 'Cooking time: ', 'lsx-health-plan' ); ?>&nbsp;</td>
			<td>
			<?php
				echo wp_kses_post( $cooking_time );
			?>
			</td>
		</tr>
		<?php
		}
		?>
		<?php
		if ( ! empty( $portion ) ) {
		?>
		<tr class="portion-size">
			<td><?php esc_html_e( 'Portion size: ', 'lsx-health-plan' ); ?>&nbsp;</td>
			<td>
			<?php
				echo wp_kses_post( $portion );
			?>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?php } ?>
<?php if ( is_single() && is_singular( 'recipe' ) && ( ( ! empty( $energy ) ) || ( ! empty( $protein ) ) || ( ! empty( $carbohydrates ) ) || ( ! empty( $fibre ) ) || ( ! empty( $fat ) ) ) ) { ?>
	<table class="recipe-table nutritional-info-table">
		<thead>
			<tr>
				<th>Nutritional Info (per portion)</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ( ! empty( $energy ) ) {
			?>
			<tr class="energy">
			<td><?php esc_html_e( 'Energy: ', 'lsx-health-plan' ); ?>&nbsp;</td>
				<td>
				<?php
					echo wp_kses_post( $energy );
				?>
				</td>
			</tr>
			<?php
			}
			?>
			<?php
			if ( ! empty( $protein ) ) {
			?>
			<tr class="protein">
			<td><?php esc_html_e( 'Protein: ', 'lsx-health-plan' ); ?>&nbsp;</td>
				<td>
				<?php
					echo wp_kses_post( $protein );
				?>
				</td>
			</tr>
			<?php
			}
			?>
			<?php
			if ( ! empty( $carbohydrates ) ) {
			?>
			<tr class="carbohydrates">
			<td><?php esc_html_e( 'Carbohydrates: ', 'lsx-health-plan' ); ?>&nbsp;</td>
				<td>
				<?php
					echo wp_kses_post( $carbohydrates );
				?>
				</td>
			</tr>
			<?php
			}
			?>
			<?php
			if ( ! empty( $fibre ) ) {
			?>
			<tr class="fibre">
			<td><?php esc_html_e( 'Fibre: ', 'lsx-health-plan' ); ?>&nbsp;</td>
				<td>
				<?php
					echo wp_kses_post( $fibre );
				?>
				</td>
			</tr>
			<?php
			}
			?>
			<?php
			if ( ! empty( $fat ) ) {
			?>
			<tr class="fat">
			<td><?php esc_html_e( 'Fat: ', 'lsx-health-plan' ); ?>&nbsp;</td>
				<td>
				<?php
					echo wp_kses_post( $fat );
				?>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
<?php } ?>
