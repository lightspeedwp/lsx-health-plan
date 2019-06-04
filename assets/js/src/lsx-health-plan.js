var LSX_HEALTH_PLAN = Object.create( null );
;( function( $, window, document, undefined ) {

    'use strict';

    LSX_HEALTH_PLAN.document = $(document);

    //Holds the slider function
    LSX_HEALTH_PLAN.sliders = Object.create( null );

    /**
     * Start the JS Class
     */
    LSX_HEALTH_PLAN.init = function() {
        LSX_HEALTH_PLAN.sliders.element = jQuery('.lsx-videos-slider.slick-slider');
        if ( 0 <  LSX_HEALTH_PLAN.sliders.element.length ) {
            LSX_HEALTH_PLAN.sliders.init();
        }
    };

    /**
     * Initiate the Sliders
     */
    LSX_HEALTH_PLAN.sliders.init = function( ) {
        LSX_HEALTH_PLAN.sliders.element.each( function() {

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
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        } );
    };

    /**
     * On document ready.
     *
     * @package    lsx-health-plan
     * @subpackage scripts
     */
    LSX_HEALTH_PLAN.document.ready( function() {
        LSX_HEALTH_PLAN.init();
    } );

} )( jQuery, window, document );