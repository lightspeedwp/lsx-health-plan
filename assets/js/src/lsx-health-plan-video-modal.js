var LSX_HP_VIDEO_MODAL = Object.create( null );
;( function( $, window, document, undefined ) {

    'use strict';

    LSX_HP_VIDEO_MODAL.document = $(document);

    //Holds the slider function
	LSX_HP_VIDEO_MODAL.sliders = Object.create( null );
	
	//Holds the slider function
    LSX_HP_VIDEO_MODAL.tipsliders = Object.create( null );

    /**
     * Start the JS Class
     */
    LSX_HP_VIDEO_MODAL.init = function() {
        LSX_HP_VIDEO_MODAL.sliders.element = jQuery('.lsx-videos-shortcode.slick-slider, .lsx-recipes-shortcode.slick-slider');
        if ( 0 <  LSX_HP_VIDEO_MODAL.sliders.element.length ) {
            LSX_HP_VIDEO_MODAL.sliders.init();
		}
		LSX_HP_VIDEO_MODAL.tipsliders.element = jQuery('.lsx-tips-shortcode.slick-slider');
        if ( 0 <  LSX_HP_VIDEO_MODAL.tipsliders.element.length ) {
            LSX_HP_VIDEO_MODAL.sliders.init();
        }
	};
	

    /**
     * Initiate the Sliders
     */
    LSX_HP_VIDEO_MODAL.sliders.init = function( ) {
        LSX_HP_VIDEO_MODAL.sliders.element.each( function() {

            var slidesToShow = 1;
            var slidesToScroll = 1;
            var slickData = $(this).attr('data-slick');
            if ( undefined !== slickData) {

                if ( undefined !== slickData.slidesToShow ) {
                    slidesToShow = slickData.slidesToShow;
                }
                if ( undefined !== slickData.slidesToScroll ) {
                    slidesToScroll = slickData.slidesToScroll;
                }
            }

            $(this).slick({
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: slidesToShow,
				slidesToScroll: slidesToScroll,
				adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: slidesToShow,
                            slidesToScroll: slidesToScroll,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
							slidesToScroll: 1,
							arrows: false
                        }
                    }
                ]
            });
		} );
		
		LSX_HP_VIDEO_MODAL.tipsliders.element.each( function() {
            $(this).slick({
                dots: true,
                infinite: false,
				speed: 300,
                slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				adaptiveHeight: true
            });
        } );
	};
	
	

    /**
     * On document ready.
     *
     * @package    lsx-health-plan
     * @subpackage scripts
     */
    LSX_HP_VIDEO_MODAL.document.ready( function() {
        LSX_HP_VIDEO_MODAL.init();
    } );

} )( jQuery, window, document );