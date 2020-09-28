<?php

$type         = lsx_health_plan_exercise_type();
$equipment    = lsx_health_plan_exercise_equipment();
$muscle_group = lsx_health_plan_muscle_group_equipment();

?>
<?php if ( ( ! empty( $type ) ) || ( ! empty( $equipment ) ) || ( ! empty( $muscle_group ) ) ) { ?>
<table class="exercise-table">
	<tbody>
		<?php
		if ( ! empty( $type ) ) {
		?>
			<tr class="types">
				<td><?php esc_html_e( 'Type:', 'lsx-health-plan' ); ?>&nbsp;</td>
				<td>
				<?php
					echo wp_kses_post( $type );
				?>
				</td>
			</tr>
		<?php
		}
		?>
		<?php
		if ( ! empty( $muscle_group ) ) {
		?>
			<tr class="muscle-group">
				<td><?php esc_html_e( 'Muscle:', 'lsx-health-plan' ); ?>&nbsp;</td>
				<td>
				<?php
					echo wp_kses_post( $muscle_group );
				?>
				</td>
			</tr>
		<?php
		}
		?>
		<?php
		if ( ! empty( $equipment ) ) {
		?>
			<tr class="equipment">
				<td><?php esc_html_e( 'Equipment:', 'lsx-health-plan' ); ?>&nbsp;</td>
				<td>
				<?php
					echo wp_kses_post( $equipment );
				?>
				</td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?php } ?>
