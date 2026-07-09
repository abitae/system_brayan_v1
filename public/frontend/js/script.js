( function( $ ) {

    "use strict";


    //Hide Loading Box (Preloader)
    function handlePreloader() {
      if ( $('.preloader' ).length ) {
        $( '.preloader' ).delay( 500 ).fadeOut( 500 );
      }
    }


    // stickyheader
    function stickyHeader() {
        if ( $( '.stricky' )
            .length ) {
            var strickyScrollPos = 100;
            if ( $( window )
                .scrollTop() > strickyScrollPos ) {
                $( '.stricky' )
                    .removeClass( 'fadeIn animated' );
                $( '.stricky' )
                    .addClass( 'stricky-fixed fadeInDown animated' );
                $( '.scroll-to-top' )
                    .fadeIn( 500 );
            } else if ( $( this )
                .scrollTop() <= strickyScrollPos ) {
                $( '.stricky' )
                    .removeClass( 'stricky-fixed fadeInDown animated' );
                $( '.stricky' )
                    .addClass( 'slideIn animated' );
                $( '.scroll-to-top' )
                    .fadeOut( 500 );
            }
        };
    }


    // Scroll to top
    function scrollToTop() {
        if ( $( '.scroll-top' )
            .length ) {
            var h = $( '.scroll-top' );
            //Check to see if the window is top if not then display button
            $( window )
                .scroll( function() {
                    if ( $( this )
                        .scrollTop() > 200 ) {
                        h.fadeIn();
                    } else {
                        h.fadeOut();
                    }
                } );

            //Click event to scroll to top
            h.click( function() {
                $( 'html, body' )
                    .animate( {
                        scrollTop: 0
                    }, 1500 );
                return false;
            } );
        }
    }


    //Update Header Style + Scroll to Top
    function headerStyle() {
        if ( $( '.main-header' )
            .length ) {
            var topHeader = $( '.header-top' )
                .innerHeight();
            var windowpos = $( window )
                .scrollTop();
            if ( windowpos >= topHeader ) {
                $( '.main-header' )
                    .addClass( 'fixed-header' );
                $( '.scroll-to-top' )
                    .fadeIn( 300 );
            } else {
                $( '.main-header' )
                    .removeClass( 'fixed-header' );
                $( '.scroll-to-top' )
                    .fadeOut( 300 );
            }
        }
    }

    //Search Box Hide / Show
    if ( $( '.header-lower .search-btn' )
        .length ) {
        $( '.header-lower .search-btn' )
            .on( 'click', function() {
                $( '.search-box.toggle-box' )
                    .slideToggle( 500 );
                // animate
                $( 'html, body' )
                    .animate( {
                        scrollTop: $( 'html, body' )
                            .offset()
                            .top
                    }, 1000 );
            } );
    }



    //Main Slider
    if ( $( '#slider1' ).length ) {
        $( "#slider1" )
            .show()
            .revolution( {
                sliderType: "standard"
                , sliderLayout: "fullwidth"
                , delay: 9000
                , sliderType: "standard",

                gridwidth: 1200
                , gridheight: 900
                , navigation: {
                    keyboardNavigation: "on"
                    , keyboard_direction: "horizontal"
                    , mouseScrollNavigation: "off"
                    , onHoverStop: "on"
                    , touch: {
                        touchenabled: "off"
                        , swipe_treshold: 75
                        , swipe_min_touches: 1
                        , drag_block_vertical: false
                        , swipe_direction: "horizontal"
                    }
                    , arrows: {
                        style: "main-slider-1-nav tp-resizeme"
                        , enable: true
                        , rtl: false
                        , hide_onmobile: true
                        , hide_onleave: true
                        , hide_delay: 5000
                        , hide_delay_mobile: 5000
                        , hide_under: 767
                        , hide_over: 9999
                        , tmp: ''
                        , left: {
                            container: "layergrid"
                            , h_align: "left"
                            , v_align: "center"
                            , h_offset: 50
                            , v_offset: 0
                        }
                        , right: {
                            container: "layergrid"
                            , h_align: "right"
                            , v_align: "center"
                            , h_offset: 50
                            , v_offset: 0
                        }
                    }
                , }
            , } );
    }
    //Main Slider
    if ($('#slider2').length) {
        $("#slider2").show().revolution( {
                sliderType: "standard"
                , sliderLayout: "fullwidth"
                , delay: 9000
                , sliderType: "standard",

                gridwidth: 1200
                , gridheight: 758
                , navigation: {
                    keyboardNavigation: "on"
                    , keyboard_direction: "horizontal"
                    , mouseScrollNavigation: "off"
                    , onHoverStop: "on"
                    , touch: {
                        touchenabled: "off"
                        , swipe_treshold: 75
                        , swipe_min_touches: 1
                        , drag_block_vertical: false
                        , swipe_direction: "horizontal"
                    }
                    , arrows: {
                        style: "main-slider-1-nav tp-resizeme"
                        , enable: true
                        , rtl: false
                        , hide_onmobile: true
                        , hide_onleave: true
                        , hide_delay: 5000
                        , hide_delay_mobile: 5000
                        , hide_under: 767
                        , hide_over: 9999
                        , tmp: ''
                        , left: {
                            container: "layergrid"
                            , h_align: "left"
                            , v_align: "center"
                            , h_offset: 50
                            , v_offset: 0
                        }
                        , right: {
                            container: "layergrid"
                            , h_align: "right"
                            , v_align: "center"
                            , h_offset: 50
                            , v_offset: 0
                        }
                    }
                , }
            , } );
    }

    //Main Slider
    if ( $( '#slider3' )
        .length ) {
        $( "#slider3" )
            .show()
            .revolution( {
                sliderType: "standard"
                , sliderLayout: "fullwidth"
                , delay: 9000
                , sliderType: "standard",

                gridwidth: 1200
                , gridheight: 900
                , navigation: {
                    keyboardNavigation: "on"
                    , keyboard_direction: "horizontal"
                    , mouseScrollNavigation: "off"
                    , onHoverStop: "on"
                    , touch: {
                        touchenabled: "off"
                        , swipe_treshold: 75
                        , swipe_min_touches: 1
                        , drag_block_vertical: false
                        , swipe_direction: "horizontal"
                    }
                    , arrows: {
                        style: "main-slider-1-nav tp-resizeme"
                        , enable: true
                        , rtl: false
                        , hide_onmobile: true
                        , hide_onleave: true
                        , hide_delay: 5000
                        , hide_delay_mobile: 5000
                        , hide_under: 767
                        , hide_over: 9999
                        , tmp: ''
                        , left: {
                            container: "layergrid"
                            , h_align: "left"
                            , v_align: "center"
                            , h_offset: 80
                            , v_offset: -26
                        }
                        , right: {
                            container: "layergrid"
                            , h_align: "right"
                            , v_align: "center"
                            , h_offset: 80
                            , v_offset: -26
                        }
                    }
                , }
            , } );
    }

    //testimonial carousel activation
    if ( $( '.testimonial-slider' )
        .length ) {
        $( '.testimonial-slider' )
            .owlCarousel( {
                autoplay: true
                , smartSpeed: 1500
                , mouseDrag: true
                , dots: true
                , items: 1
                , dotsContainer: "#owl-dots"
                , autoplayTimeout: 5000
                , responsiveClass: false
                , nav: false
                , responsive: {
                    0: {
                        items: 1
                    , }
                    , 768: {
                        items: 1
                    , }
                    , 1024: {
                        items: 1
                    , }
                }
            } );
    }

    //testimonial carousel activation
    if ( $( '.clients-1-carousel' )
        .length ) {
        $( '.clients-1-carousel' )
            .owlCarousel( {
                autoplay: true
                , smartSpeed: 500
                , mouseDrag: true
                , dots: false
                , loop: true
                , items: 5
                , merge: true
                , margin: 10
                , autoplayTimeout: 5000
                , responsiveClass: false
                , nav: false
                , responsive: {
                    0: {
                        items: 1
                    , }
                    , 768: {
                        items: 2
                    , }
                    , 1024: {
                        items: 5
                    , }
                }
            } );
    }


    // hidden-bar activation
    var menuWrap = $( '.hidden-bar .main-menu' );
    menuWrap.find( '.dropdown' )
        .children( 'a' )
        .append( function() {
            return '<button type="button" class="btn expander"><i class="fa fa-chevron-down"></i></button>';
        } );
    menuWrap.find( '.dropdown' )
        .children( 'ul' )
        .hide();
    // toggling child ul
    menuWrap.find( '.btn.expander' )
        .each( function() {
            $( this )
                .on( 'click', function() {
                    $( this )
                        .parent() // return parent of .btn.expander (a)
                        .parent() // return parent of a (li)
                        .children( 'ul' )
                        .slideToggle();

                    // adding class to expander container
                    $( this )
                        .parent()
                        .toggleClass( 'current' );
                    // toggling arrow of expander
                    $( this )
                        .find( 'i' )
                        .toggleClass( 'fa-chevron-up fa-chevron-down' );


                    return false;

                } );
        } );

    if ( $( '.hidden-bar-closer' )
        .length ) {
        $( '.hidden-bar-closer' )
            .on( 'click', function() {
                $( '.hidden-bar' )
                    .css( {
                        'right': '-150%'
                    } );
            } );
    };
    if ( $( '.hidden-bar-opener' )
        .length ) {
        $( '.hidden-bar-opener' )
            .on( 'click', function() {
                $( '.hidden-bar' )
                    .css( {
                        'right': '0%'
                    } );
            } );
    };


    //Show Popup
    $( '.search-box-btn' )
        .on( 'click', function() {
            $( '#search-popup' )
                .addClass( 'popup-visible' );
        } );

    //Hide Popup
    $( '.close-search' )
        .on( 'click', function() {
            $( '#search-popup' )
                .removeClass( 'popup-visible' );
        } );

    //Adjust Footer Background
    function footerStyle() {
        if ( $( '.main-footer .contact-widget' )
            .length ) {
            var contactWidth = $( '.main-footer .contact-widget' )
                .innerWidth();
            //var windowWidth = $(window).width();
            var contWidth = $( '.main-footer .auto-container' )
                .width();
            $( '.main-footer .footer-bg-layer' )
                .css( {
                    'width': contWidth - contactWidth + 15
                } );
        }
    }

    //Date TimePicker
    if ( $( '.map-detail-closer' )
        .length ) {
        $( '.map-detail-closer' )
            .click( function() {
                $( '.map-detail' )
                    .addClass( 'dn' );
            } );
    }

    // mixItUp function
    $( '.gallery' )
        .mixItUp( {
            activeClass: 'on'
            , callbacks: {
                onMixEnd: function( state ) {
                    masonryGrid(); // ******* here call masonry function
                }
            }
        } );

    function masonryGrid() {
        var $container = $( '.grid' );
        // initialize
        $container.masonry( {
            itemSelector: '.grid-item'
            , columnWidth: '.grid-item', //as you wish , you can use numeric
            isAnimated: true
        , } );
        $container.masonry( 'reloadItems' );
        $container.masonry( 'layout' );
    }


    //Skill Progress Bar
    if ( $( '.skill-box .bar-fill' )
        .length ) {
        $( ".skill-box .bar-fill" )
            .each( function() {
                var progressWidth = $( this )
                    .attr( 'data-percent' );
                $( this )
                    .css( 'width', progressWidth + '%' );
                $( this )
                    .parents( '.bar' )
                    .children( '.percent' )
                    .html( progressWidth + '%' );
            } );
    }

    //Filters Section / Mixitup
    if ( $( '.filter-list' )
        .length ) {
        $( '.filter-list' )
            .mixitup( {} );
    }



    //Accordions
    if ( $( '.accordion-box' )
        .length ) {
        $( '.accordion-box .acc-btn' )
            .on( 'click', function() {
                if ( $( this )
                    .hasClass( 'active' ) !== true ) {
                    $( '.accordion-box .acc-btn' )
                        .removeClass( 'active' );
                }

                if ( $( this )
                    .next( '.acc-content' )
                    .is( ':visible' ) ) {
                    $( this )
                        .removeClass( 'active' );
                    $( this )
                        .next( '.acc-content' )
                        .slideUp( 500 );
                } else {
                    $( this )
                        .addClass( 'active' );
                    $( '.accordion-box .acc-content' )
                        .slideUp( 500 );
                    $( this )
                        .next( '.acc-content' )
                        .slideDown( 500 );
                }
            } );
    }

    //LightBox / Fancybox
    if ( $( '.lightbox-image' )
        .length ) {
        $( '.lightbox-image' )
            .fancybox();
    }


    //Contact Form Validation
    if ( $( '#contact-form' )
        .length ) {
        $( '#contact-form' )
            .validate( {
                rules: {
                    username: {
                        required: true
                    }
                    , email: {
                        required: true
                        , email: true
                    }
                    , subject: {
                        required: true
                    }
                    , message: {
                        required: true
                    }
                }
            } );
    }


    // Google Map Settings
    if ( $( '#map-location' )
        .length ) {
        var map;
        map = new GMaps( {
            el: '#map-location'
            , zoom: 14
            , scrollwheel: false
            , //Set Latitude and Longitude Here
            lat: -37.817085
            , lng: 144.955631
        } );

        //Add map Marker
        map.addMarker( {
            lat: -37.817085
            , lng: 144.955631
            , infoWindow: {
                content: '<p style="text-align:center;"><strong>Envato</strong><br>Melbourne VIC 3000, Australia</p>'
            }

        } );
    }


    // Scroll to top
    if ( $( '.scroll-to-top' )
        .length ) {
        $( ".scroll-to-top" )
            .on( 'click', function() {
                // animate
                $( 'html, body' )
                    .animate( {
                        scrollTop: $( 'html, body' )
                            .offset()
                            .top
                    }, 1000 );

            } );
    }


    //Masonary Gallery
    function enableMasonry() {
        if ( $( '.masonry-gallery' )
            .length ) {
            // Needed variables
            var $container = $( '.masonry-gallery .items-container' );
            var selector = $( '.masonry-gallery .masonry-item' );

            $container.isotope( {
                filter: selector
                , masonry: {
                    columnWidth: 1
                }
                , animationOptions: {
                    duration: 500
                    , easing: 'linear'
                }
            } );
        }
    }

    enableMasonry();




    //Product Tabs
    if ( $( '.prod-tabs .tab-btn' )
        .length ) {
        $( '.prod-tabs .tab-btn' )
            .on( 'click', function( e ) {
                e.preventDefault();
                var target = $( $( this )
                    .attr( 'href' ) );
                $( '.prod-tabs .tab-btn' )
                    .removeClass( 'active-btn' );
                $( this )
                    .addClass( 'active-btn' );
                $( '.prod-tabs .tab' )
                    .fadeOut( 0 );
                $( '.prod-tabs .tab' )
                    .removeClass( 'active-tab' );
                $( target )
                    .fadeIn( 500 );
                $( target )
                    .addClass( 'active-tab' );
            } );

    }

    //Single Item Carousel
    if ( $( '.single-item-carousel' )
        .length ) {
        $( '.single-item-carousel' )
            .owlCarousel( {
                loop: true
                , margin: 0
                , nav: true
                , smartSpeed: 700
                , autoplay: 5000
                , navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ]
                , responsive: {
                    0: {
                        items: 1
                    }
                    , 1024: {
                        items: 1
                    }
                    , 1200: {
                        items: 1
                    }
                }
            } );
    }


    //LightBox / Fancybox
    if ( $( '.lightbox-image' )
        .length ) {
        $( '.lightbox-image' )
            .fancybox( {
                openEffect: 'none'
                , closeEffect: 'none'
                , helpers: {
                    media: {}
                }
            } );
    }

    //Jquery Spinner / Quantity Spinner
    if ( $( '.quantity-spinner' )
        .length ) {
        $( "input.quantity-spinner" )
            .TouchSpin( {
                verticalbuttons: true
            } );
    }

    // Fact Counter
    function factCounter() {
        if ( $( '.fact-counter' )
            .length ) {
            $( '.fact-counter .counter-column.animated' )
                .each( function() {

                    var $t = $( this )
                        , n = $t.find( ".count-text" )
                        .attr( "data-stop" )
                        , r = parseInt( $t.find( ".count-text" )
                            .attr( "data-speed" ), 10 );

                    if ( !$t.hasClass( "counted" ) ) {
                        $t.addClass( "counted" );
                        $( {
                                countNum: $t.find( ".count-text" )
                                    .text()
                            } )
                            .animate( {
                                countNum: n
                            }, {
                                duration: r
                                , easing: "linear"
                                , step: function() {
                                    $t.find( ".count-text" )
                                        .text( Math.floor( this.countNum ) );
                                }
                                , complete: function() {
                                    $t.find( ".count-text" )
                                        .text( this.countNum );
                                }
                            } );
                    }

                } );
        }
    }


    //Price Range Slider
    if ( $( '.range-slider-price' )
        .length ) {

        var priceRange = document.getElementById( 'range-slider-price' );

        noUiSlider.create( priceRange, {
            start: [ 30, 300 ]
            , limit: 1000
            , behaviour: 'drag'
            , connect: true
            , range: {
                'min': 10
                , 'max': 500
            }
        } );

        var limitFieldMin = document.getElementById( 'min-value-rangeslider' );
        var limitFieldMax = document.getElementById( 'max-value-rangeslider' );

        priceRange.noUiSlider.on( 'update', function( values, handle ) {
            ( handle ? limitFieldMax : limitFieldMin )
            .value = values[ handle ];
        } );
    }





    // Elements Animation
    if ( $( '.wow' )
        .length ) {
        var wow = new WOW( {
            boxClass: 'wow', // animated element css class (default is wow)
            animateClass: 'animated', // animation css class (default is animated)
            offset: 0, // distance to the element when triggering the animation (default is 0)
            mobile: true, // trigger animations on mobile devices (default is true)
            live: true // act on asynchronously loaded content (default is true)
        } );
        wow.init();
    }

    /* ==========================================================================
       When document is ready, do
       ========================================================================== */

    $( document )
        .on( 'ready', function() {
            headerStyle();
            footerStyle();
        } );

    /* ==========================================================================
       When document is Scrollig, do
       ========================================================================== */

    $( window )
        .on( 'scroll', function() {
            headerStyle();
            stickyHeader();
            scrollToTop();
            factCounter();
        } );

    /* ==========================================================================
       When document is loading, do
       ========================================================================== */

    $( window )
        .on( 'load', function() {
            handlePreloader();
            enableMasonry();
        } );


    /* ==========================================================================
       When Window is resizing, do
       ========================================================================== */

    $( window )
        .on( 'resize', function() {
            footerStyle();
            enableMasonry();
        } );
















} )( window.jQuery );
