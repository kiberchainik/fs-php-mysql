(function($) {
    "use strict";

    /*****************************
     * Commons Variables
     *****************************/
    var $window = $(window),
        $body = $('body');

    /****************************
     * Sticky Menu
     *****************************/
    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop();
        if (scroll < 100) {
            $(".sticky-header").removeClass("sticky");
        } else {
            $(".sticky-header").addClass("sticky");
        }
    });

    /***************************
	Humberger Main menu
	***************************/
    // Add slideDown animation to Bootstrap dropdown when expanding.
    $('.dropdown').on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });

    // Add slideUp animation to Bootstrap dropdown when collapsing.
    $('.dropdown').on('hide.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });

    /**************************
     * Offcanvas: Menu Content
     **************************/
    function mobileOffCanvasMenu() {
        var $offCanvasNav = $('.offcanvas-menu'),
            $offCanvasNavSubMenu = $offCanvasNav.find('.mobile-sub-menu');

        /*Add Toggle Button With Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.parent().prepend('<div class="offcanvas-menu-expand"></div>');

        /*Category Sub Menu Toggle*/
        $offCanvasNav.on('click', 'li a, .offcanvas-menu-expand', function(e) {
            var $this = $(this);
            if ($this.attr('href') === '#' || $this.hasClass('offcanvas-menu-expand')) {
                e.preventDefault();
                if ($this.siblings('ul:visible').length) {
                    $this.parent('li').removeClass('active');
                    $this.siblings('ul').slideUp();
                    $this.parent('li').find('li').removeClass('active');
                    $this.parent('li').find('ul:visible').slideUp();
                } else {
                    $this.parent('li').addClass('active');
                    $this.closest('li').siblings('li').removeClass('active').find('li').removeClass('active');
                    $this.closest('li').siblings('li').find('ul:visible').slideUp();
                    $this.siblings('ul').slideDown();
                }
            }
        });
    }
    mobileOffCanvasMenu();

    /*************************
     *   Hero Slider Active
     **************************/
    var heroSlider = new Swiper('.hero-slider .swiper-container', {
        slidesPerView: 1,
        speed: 5500,
        effect: 'fade',
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: true,
        autoplaySpeed: 3000,
        pauseOnHover: false,
    });


    /****************************************
     *   Product Slider Active - 3 Grids 2 Rows
     *****************************************/
    var product_slider_3grids_2rows = new Swiper('.product-slider-3grids-2rows .swiper-container', {
        slidesPerView: 4,
        spaceBetween: 25,
        speed: 1500,
        slidesPerColumn: 2,
        slidesPerColumnFill: 'row',
        navigation: {
            nextEl: '.center-slider-nav .button-next',
            prevEl: '.center-slider-nav .button-prev',
        },

        breakpoints: {

            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 4,
            },
            
        }
    });

    var vacance_slider_3grids_2rows = new Swiper('.product-slider-3grids-2rows .swiper-container', {
        slidesPerView: 4,
        spaceBetween: 25,
        speed: 1500,
        slidesPerColumn: 2,
        slidesPerColumnFill: 'row',
        navigation: {
            nextEl: '.vacance-slider-nav .button-next',
            prevEl: '.vacance-slider-nav .button-prev',
        },

        breakpoints: {

            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 4,
            },
            
        }
    });
    /****************************************
     *   Product Slider Active - 3 Grids 2 Rows
     *****************************************/
    var top_slider_3grids_1row = new Swiper('.top-slider-3grids-2rows .swiper-container', {
        slidesPerView: 4,
        spaceBetween: 25,
        speed: 1500,
        slidesPerColumn: 2,
        slidesPerColumnFill: 'row',
        navigation: {
            nextEl: '.top-slider-buttons .button-next',
            prevEl: '.top-slider-buttons .button-prev',
        },

        breakpoints: {

            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 4,
            },
            
        }
    });
    
    /****************************************
     *   Users Slider Active - 3 Grids 2 Rows
     *****************************************/
    var users_slider_3grids_1row = new Swiper('.users-slider-3grids-1row .swiper-container', {
        slidesPerView: 4,
        spaceBetween: 25,
        speed: 1500,
        navigation: {
            nextEl: '.users-slider-buttons .button-next',
            prevEl: '.users-slider-buttons .button-prev',
        },

        breakpoints: {

            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 4,
            },
            
        }
    });
    
    /****************************************
     *   Blog Slider Active - 3 Grids 2 Rows
     *****************************************/
    var blog_slider_3grids_1row = new Swiper('.blog-slider-3grids-1row .swiper-container', {
        slidesPerView: 4,
        spaceBetween: 25,
        speed: 1500,
        navigation: {
            nextEl: '.blog-slider-buttons .button-next',
            prevEl: '.blog-slider-buttons .button-prev',
        },

        breakpoints: {

            0: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 4,
            },
            
        }
    });

    
    /****************************************
     *   company Logo
     *****************************************/
    var company_logo_slider = new Swiper('.company-slider .swiper-container', {
        slidesPerView: 5,
        autoplay: true,
        speed: 1500,
        loop: true,

        breakpoints: {

            0: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 4,
            },
            1200: {
                slidesPerView: 5,
            },
            
        }
    });

    /****************************************
     *   Blog Feed - 2 Grids 1 Row
     *****************************************/
    var blog_feed_slider = new Swiper('.blog-feed-slide .swiper-container', {
        slidesPerView: 4,
        spaceBetween: 25,
        speed: 1500,
        loop: true,
        autoplay: true,
        breakpoints: {

            0: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 2,
            },
            1200: {
                slidesPerView: 3,
            },
        }
    });


    /************************************************
     * Price Range
     ***********************************************/
    $(".js-range-slider").ionRangeSlider({
        skin: "round",
        hide_min_max: true,    // show/hide MIN and MAX labels
    });

})(jQuery);
