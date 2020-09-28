<?php
namespace lsx_health_plan\classes\frontend;

/**
 * Contains the gallery functionality.
 *
 * @package lsx-health-plan
 */
class Gallery {

	/**
	 * Holds class instance
	 *
	 * @var object \lsx_health_plan\classes\lib\Gallery()
	 */
	protected static $instance = null;

	/**
	 * The current item ID.
	 *
	 * @var boolean | int
	 */
	public $item_id = false;

	/**
	 * The current item post_type used in the custom field retrival..
	 *
	 * @var boolean | int
	 */
	public $post_type = false;

	/**
	 * Holds the the default parameters for the gallery output.
	 *
	 * @var array
	 */
	public $defaults = array();

	/**
	 * If the current post has a gallery.
	 *
	 * @var boolean
	 */
	public $has_gallery = false;

	/**
	 * Holds the array of gallery images.
	 *
	 * @var array
	 */
	public $gallery = array();

	/**
	 * Holds the html for the current gallery being output.
	 *
	 * @var array
	 */
	public $html = array();

	/**
	 * Holds the parameters for the current gallery being output.
	 *
	 * @var array
	 */
	public $args = array();

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return    object \lsx_health_plan\classes\lib\Gallery()    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Check if the item has a gallery of images returns true or false.
	 *
	 * @param  string $item_id
	 * @param  string $post_type
	 * @return boolean
	 */
	public function has_gallery( $item_id = '', $post_type = '' ) {
		if ( '' === $item_id ) {
			$this->item_id = get_the_ID();
		} else {
			$this->item_id = $item_id;
		}
		$this->has_gallery = false;
		if ( '' === $post_type ) {
			$this->post_type = get_post_type( $this->item_id );
		}
		$gallery = get_post_meta( $this->item_id, $this->post_type . '_gallery', true );

		if ( ! empty( $gallery ) && ( '' !== $gallery ) ) {
			$this->gallery     = $gallery;
			$this->has_gallery = true;
			wp_enqueue_script( 'slick', LSX_HEALTH_PLAN_URL . 'assets/js/src/slick.min.js', array( 'jquery' ), LSX_HEALTH_PLAN_VER, true );
			wp_enqueue_script( 'lsx-health-plan-slider', LSX_HEALTH_PLAN_URL . 'assets/js/src/lsx-health-plan-slider.js', array( 'slick' ), LSX_HEALTH_PLAN_VER, true );
		}
		return $this->has_gallery;
	}

	/**
	 * Returns the defaults for the gallery, after grabbing the setting from the item.
	 *
	 * @param  string $item_id
	 * @param  string $post_type
	 * @return array
	 */
	public function get_defaults( $item_id = '', $post_type = '' ) {
		if ( '' === $item_id ) {
			$item_id = $this->item_id;
		}
		if ( '' === $post_type ) {
			$post_type = $this->post_type;
		}
		$this->defaults = array(
			'columns'   => '3',
			'layout'    => 'slider',
			'interval'  => false,
			'css_class' => false,
		);
		foreach ( $this->defaults as $key => $default ) {
			$override = get_post_meta( $item_id, $this->post_type . '_gallery_' . $key, true );
			if ( '' !== $override && false !== $override && ! empty( $override ) ) {
				$this->defaults[ $key ] = $override;
			}
		}
		return $this->defaults;
	}

	/**
	 * Gets and returns the gallery html.
	 *
	 * @param string $item_id
	 * @param string $post_type
	 * @return void
	 */
	public function get_gallery( $item_id = '', $post_type = '', $args = array() ) {
		$return     = '';
		$this->html = array();
		$this->args = wp_parse_args( $args, $this->get_defaults( $item_id, $post_type ) );
		if ( ! empty( $this->gallery ) ) {
			$this->args['count'] = 1;
			if ( '' !== $post_type ) {
				$this->args['post_type'] = $post_type;
			} else {
				$this->args['post_type'] = $this->post_type;
			}

			// output the opening boostrap row divs.
			$this->before_loop();

			foreach ( $this->gallery as $key => $gallery ) {

				$this->loop_start();

				if ( isset( $gallery['exercise_gallery_image_id'] ) && ! empty( $gallery['exercise_gallery_image_id'] ) ) {
					$size         = apply_filters( 'lsx_hp_exercise_gallery_size', 'full' );
					$thumbnail    = wp_get_attachment_image( $gallery['exercise_gallery_image_id'], $size );
					$this->html[] = $thumbnail;
				} elseif ( isset( $gallery['exercise_gallery_external'] ) && ! empty( $gallery['exercise_gallery_external'] ) ) {
					$this->html[] = $gallery['exercise_gallery_external']; // WPCS: XSS OK.
				} elseif ( isset( $gallery['exercise_gallery_embed'] ) && ! empty( $gallery['exercise_gallery_embed'] ) ) {
					$embed_args = array(
						'width' => '530',
					);
					$embed        = wp_oembed_get( $gallery['exercise_gallery_embed'], $embed_args );
					$this->html[] = str_replace( 'width="530"', 'width="100%"', $embed ); // WPCS: XSS OK.
				}

				$this->loop_end();

				$this->args['count']++;
			}

			// output the closing boostrap row divs.
			$this->after_loop();
		}

		// Join the html output if its not empty.
		if ( ! empty( $this->html ) ) {
			$return = implode( '', $this->html );
		}
		return $return;
	}

	/**
	 * Outputs the CSS class for the panels
	 *
	 * @param string $columns
	 * @return string
	 */
	public function column_class() {
		$cols  = 'col-xs-12 col-sm-';
		$cols .= '5' === $this->args['columns'] ? '15' : 12 / $this->args['columns'];
		return $cols;
	}

	/**
	 * Runs just after the if and before the while statement in $this->output()
	 */
	public function before_loop() {
		if ( 'slider' === $this->args['layout'] ) {
			$this->carousel_id = wp_rand( 20, 20000 );
			$this->html[]      = "<div class='lsx-hp-widget-items slick-slider slick-dotted slick-has-arrows {$this->args['css_class']} ' data-interval='{$this->args['interval']}' data-slick='{ \"slidesToShow\": 1, \"slidesToScroll\": 1'>";
		} else {
			$this->html[] = "<div class='lsx-hp-widget-items widget-item-grid-layout'>";
		}
	}

	/**
	 * Runs at the very end of the loop before it runs again.
	 */
	public function loop_start() {
		// Get the call for the active slide.
		if ( 'slider' === $this->args['layout'] ) {
			$this->html[] = "<div class='lsx-hp-widget-item-wrap lsx-{$this->args['post_type']}'>";
		} else {
			if ( 1 === $this->args['count'] ) {
				$this->html[] = "<div class='row'>";
			}
			$this->html[] = '<div class="' . $this->column_class() . '">';
		}
	}

	/**
	 * Runs at the very end of the loop before it runs again.
	 */
	public function loop_end() {
		if ( 'slider' !== $this->args['layout'] ) {
			$this->html[] = '</div>';
		}
		// Close the current slide panel.
		if ( 'slider' === $this->args['layout'] ) {
			$this->html[] = '</div>';
		} elseif ( 0 === $this->args['count'] % $this->args['columns'] || count( $this->gallery ) === $this->args['count'] ) {
			$this->html[] = '</div>';

			if ( $this->args['count'] < count( $this->gallery ) ) {
				$this->html[] = "<div class='row'>";
			}
		}
	}

	/**
	 * Runs just after the if and before the while statement in $this->output()
	 */
	public function after_loop() {
		// Slider output Closing.
		if ( 'slider' === $this->args['layout'] ) {
			$this->html[] = '</div>';
		} else {
			$this->html[] = '</div>';
		}
	}
}
