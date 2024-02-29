/*
	Foxstar 2.0
    by WowThemez
*/

(function($){ "use strict";
             
    $(window).on('load', function() {
        $('body').addClass('loaded');
    });

/*=========================================================================
    Navigation Menu
=========================================================================*/
    $(function() {
        var header = $("#header-9"),
            yOffset = 0,
            triggerPoint = 10;
        $(window).on( 'scroll', function() {
            yOffset = $(window).scrollTop();

            if (yOffset >= triggerPoint) {
                header.addClass("fixed-top");
            } else {
                header.removeClass("fixed-top");
            }

        });
    });
             
/*=========================================================================
    Sliders
=========================================================================*/
    // Slider 1
    var owlSlider1 = $('#main-slider-1');
    owlSlider1.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: false,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    // Slider animation
    owlSlider1.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('slideInUp animated').hide();
        $('.slider_content p, .slider_content .fs_btn').removeClass('fadeInUp animated').hide();
    });

    owlSlider1.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('slideInUp animated').show();
        $('.owl-item.active .slider_content p, .owl-item.active .slider_content .fs_btn').addClass('fadeInUp animated').show();
    });

    // Slider 2
    var owlSlider2 = $('#main-slider-2');
    owlSlider2.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    // Slider animation
    owlSlider2.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('fadeInUp animated').hide();
        $('.slider_content p').removeClass('fadeInUp animated').hide();
        $('.slider_content .btn_group_left').removeClass('fadeInDown animated').hide();
    });

    owlSlider2.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content p').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content .btn_group_left').addClass('fadeInDown animated').show();
    });

    // Slider 3
    var owlSlider3 = $('#main-slider-3');
    owlSlider3.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    // Slider animation
    owlSlider3.on('translate.owl.carousel', function () {
        $('.slider_content h1, .slider_content p, .slider_content .btn_group').removeClass('fadeInRight animated').hide();
        $('.slider_left').removeClass('fadeInLeft animated').hide();
    });

    owlSlider3.on('translated.owl.carousel', function () {
        $('.slider_content h1, .slider_content p, .slider_content .btn_group').addClass('fadeInRight animated').show();
        $('.owl-item.active .slider_left').addClass('fadeInLeft animated').show();
    });

    // Slider 4
    var owlSlider4 = $('#main-slider-4');
    owlSlider4.owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav:true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });

    owlSlider4.on("translate.owl.carousel", function(){
        $(".main_slide .hero_content").removeClass("animated zoomIn").css("opacity", "0");
    });
    
    owlSlider4.on("translated.owl.carousel", function(){
        $(".main_slide .hero_content").addClass("animated zoomIn").css("opacity", "1");
    });

    // Slider 5
    var owlSlider5 = $('#main-slider-5');
    owlSlider5.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider5.on('translate.owl.carousel', function () {
        $('.slider_content h1, .slider_content p').removeClass('fadeInLeft animated').hide();
        $('.slider_content .btn_group_left').removeClass('fadeInUp animated').hide();
    });

    owlSlider5.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1, .owl-item.active .slider_content p').addClass('fadeInLeft animated').show();
        $('.owl-item.active .slider_content .btn_group_left').addClass('fadeInUp animated').show();
    });

    // Slider 6
    var owlSlider6 = $('#main-slider-6');
    owlSlider6.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider6.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('bounceInDown animated').hide();
        $('.slider_content p').removeClass('fadeInUp animated').hide();
        $('.slider_content .btn_group').removeClass('fadeInDown animated').hide();
    });

    owlSlider6.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('bounceInDown animated').show();
        $('.owl-item.active .slider_content p').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content .btn_group').addClass('fadeInDown animated').show();
    });

    // Slider 7
    var owlSlider7 = $('#main-slider-7');
    owlSlider7.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider7.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('fadeInUp animated').hide();
        $('.slider_content p').removeClass('fadeInUp animated').hide();
        $('.slider_content .btn_group').removeClass('fadeInDown animated').hide();
    });

    owlSlider7.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content p').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content .btn_group').addClass('fadeInDown animated').show();
    });

    // Slider 8
    var owlSlider8 = $('#main-slider-8');
    owlSlider8.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider8.on('translate.owl.carousel', function () {
        $('.slider_content h1, .slider_content p, .slider_content a.fs_btn').removeClass('fadeInUp animated').hide();
    });

    owlSlider8.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1, .owl-item.active .slider_content p, .owl-item.active .slider_content a.fs_btn').addClass('fadeInUp animated').show();
    });

    // Slider 9
    var owlSlider9 = $('#main-slider-9');
    owlSlider9.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider9.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('slideInUp animated').hide();
        $('.slider_content p, .slider_content .fs_btn').removeClass('fadeInUp animated').hide();
    });

    owlSlider9.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('slideInUp animated').show();
        $('.owl-item.active .slider_content p, .owl-item.active .slider_content .fs_btn').addClass('fadeInUp animated').show();
    });

    // Slider 10
    var owlSlider10 = $('#main-slider-10');
    owlSlider10.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        autoplay: false,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
     
    owlSlider10.on('translate.owl.carousel', function () {
        $('.slider_content h1, .slider_content .list, .slider_content p, .slider_content a.fs_btn').removeClass('fadeInUp animated').hide();
        $('.slider_item .right_img').removeClass('slideInRight animated').hide();
    });

    owlSlider10.on('translated.owl.carousel', function () {
        $('.slider_content h1, .slider_content .list, .slider_content p, .slider_content a.fs_btn').addClass('fadeInUp animated').show();
        $('.slider_item .right_img').addClass('slideInRight animated').show();
    });

    // Slider 11
    var owlSlider11 = $('#main-slider-11');
    owlSlider11.owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav:true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });

    owlSlider11.on("translate.owl.carousel", function(){
        $(".main_slide .slider_content h1").removeClass("animated fadeInRight").css("opacity", "0");
        $(".main_slide .slider_content p, .main_slide .slider_content .btn_group").removeClass("animated fadeInRight").css("opacity", "0");
    });

    // Slider 11
    var owlSlider12 = $('#main-slider-12');
    owlSlider12.owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav:true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider11.on("translated.owl.carousel", function(){
        $(".main_slide .slider_content h1").addClass("animated fadeInRight").css("opacity", "1");
        $(".main_slide .slider_content p, .main_slide .slider_content .btn_group").addClass("animated fadeInRight").css("opacity", "1");
    });

    // Content 27 slide
    $('#content-27-slide, #carousel-7-trigger, #carousel-8-trigger, #testi-2-trigger, #testi-6-trigger, #testi-10-trigger, #testi-15-trigger').owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        dots: false,
        nav:true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
    });

/*=========================================================================
    Carousel 
=========================================================================*/
    var stuffSelector = $('#stuff_carousel, #stuff_carousel_2, #carousel-9-trigger');
    stuffSelector.owlCarousel({
        loop:true,
        margin:10,
        center: true,
        smartSpeed: 500,
        autoWidth: true,
        nav: true,
        autoplay: false,
        navText: ["<i class='fa fa-long-arrow-left'></i>", "<i class='fa fa-long-arrow-right'></i>"],
        dots: false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });     

// App Screen Carousel
    function getSlide() {
        var wW = $(window).width();
        if (wW < 750) {
            return 1;
        }
        return 3;
    }
  
    var mySwiper = $('.screen_carousel').swiper({
        mode:'horizontal',
        loop: true,
        speed: 1000,
        autoplay: 1000,
        effect: 'coverflow',
        slidesPerView: getSlide(),
        grabCursor: true,
        pagination: '.screen-pagination',
        paginationClickable: true,
        nextButton: '.arrow-right',
        prevButton: '.arrow-left',
        keyboardControl: true,
        coverflow: {
            rotate: 0,
            stretch: 90,
            depth: 200,
            modifier: 1,
            slideShadows : true
        }
    });

    // App carousel 2
     $('#app_carousel_2').owlCarousel({
        loop:true,
        margin: 20,
        autoplay: true,
        responsiveClass:true,
        smartSpeed: 500,
        dots: false,
        nav:true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
        
    });

     // Carousel 3
     $('#product-carousel-3').owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        dots: false,
        margin: 10,
        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive : {
            0 : {
                items: 1
            },
            480 : {
                items: 3
            },
            768 : {
                items: 4
            }
        }
    });

     // Carousel 4
     $('#carousel-4-trigger, #carousel-5-trigger, #carousel-10-trigger, #carousel-11-trigger').owlCarousel({
        loop:true,
        margin: 20,
        autoplay: true,
        smartSpeed: 500,
        dots: false,
        nav:true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2,
                margin:10
            },
            1000:{
                items:3
            }
        }
    });

    //  Carousel 6
    $('#carousel-6-trigger').owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav:false
    });

    $("#carousel-6-trigger").on("translate.owl.carousel", function(){
        $(".slide_content .project_info").removeClass("animated zoomIn").css("opacity", "0");
    });
    
    $("#carousel-6-trigger").on("translated.owl.carousel", function(){
        $(".slide_content .project_info").addClass("animated zoomIn").css("opacity", "1");
    });

    //  Client Carousel
    var sponsorCarousel = $('#client-1-trigger');
    sponsorCarousel.owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        smartSpeed: 1000,
        nav: false,
        dots: false,
        responsive: true,
        responsive : {
            0 : {
                items: 3
            },
            480 : {
                items: 3,
            },
            768 : {
                items: 6,
            }
        }
    });

    //  Testimonial Carusel
    var testiSelector = $('#testi-1-trigger, #testi-3-trigger, #testi-4-trigger, #testi-11-trigger, #testi-12-trigger');
    testiSelector.owlCarousel({
        loop: true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav: false
    }); 

    $('#testi-7-trigger').owlCarousel({
        loop:true,
        margin: 20,
        autoplay: true,
        smartSpeed: 500,
        dots: false,
        nav:true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2,
                margin:10
            },
            1000:{
                items:2
            }
        }
        
    });

    //  Testimonial 19
    var testiCarousel = $('#testi-19-trigger');
      testiCarousel.owlCarousel({
            loop: true,
            autoplay: false,
            smartSpeed: 800,
            margin: 20,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    items: 1
                },
                // breakpoint from 480 up
                520 : {
                    items: 1
                },
                // breakpoint from 768 up
                768 : {
                    items: 2
                }
            }
        });

      //  Client 4
      $('#client-4-trigger').owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            smartSpeed: 1000,
            nav: false,
            dots: false,
            responsive: true,
            responsive : {
                0 : {
                    items: 3
                },
                480 : {
                    items: 3,
                },
                768 : {
                    items: 8,
                }
            }
        });

/*=========================================================================
    Subscribe Form
=========================================================================*/
    $('.subs-btn').on('click', function (event) {
        event.preventDefault();
        var name_attr = [];
        var values = [];
        var fs_process = "";
        if($(this).closest("section").attr('id') !== undefined)
        {
            var section_id = $(this).closest("section").attr('id');
        }else{
            var section_id = $(this).closest("footer").attr('id');
        }
        var submit_loader = '<div class="loading text-blue display-inline-block ml-10" id="loading">Loading...</div>';
        $('#' + section_id).find('form').find('button').after(submit_loader);
        $('#' + section_id).find('form input').each(
            function (index) {
                
                if ($(this).is('[data-email="required"]')) {
                    var required_val = $(this).val();
                    if (required_val != '') {
                        name_attr.push($(this).attr('name'));
                        values.push($(this).val());
                        fs_process = true;
                    } else {
                        $('#loading').remove();
                        $(this).addClass('fs-input-error');
                        fs_process = false;
                    }
                }

                if (!$(this).is('[data-email="required"]')) {
                    name_attr.push($(this).attr('name'));
                    values.push($(this).val());
                }

            });
        
        if (fs_process) 
        {
            localStorage.setItem('fs-section',section_id);
            $.post("mail/process.php", {
                data: { input_name: name_attr,values:values,section_id:section_id},
                type: "POST",
            }, function (data) {
                $('#loading').remove();
                var fs_form_output = '';
                if(data) 
                {
                    if(data.type == "fs-message") 
                    {
                       $('#error-msg').remove(); 
                       $('#success-msg').remove();
                       var fs_form_output = '<div id="success-msg" class="padding-15 mt-15 bdrs-3" style="border: 1px solid green; color: green;">'+data.text+'</div>';
                    }else if (data.type == "fs_error") {
                        $('#success-msg').remove();
                        $('#error-msg').remove(); 
                        var fs_form_output = '<div id="error-msg" class="padding-15 mt-15 bdrs-3" style="border: 1px solid red; color: red;">'+data.text+'</div>';
                    }else{
                        var fs_form_output = '';
                    } 
                }

                if(fs_form_output != '')
                {
                    var section_id = localStorage.getItem('fs-section');
                    $('#'+section_id).find('form').after(fs_form_output);
                }
                $('#' + section_id).find('form input').each(function (index) {
                    $(this).val('');
                    $(this).removeClass('fs-input-error');
                });

                setTimeout(function(){
                    $('#success-msg').fadeOut();
                    $('#success-msg').remove();
                    $('#error-msg').fadeOut();
                    $('#error-msg').remove();
                    $(this).submit();
                 },5000);
                localStorage.removeItem('fs_section');
            }, 'json');
        }
        
        $('#' + section_id).find('form input').each(function (index) {
            $(this).keypress(function () {
                $(this).removeClass('fs_input_error');
            });
        });

        $('#' + section_id).find('form input').each(function (index) {
            if ($(this).is(":focus")) {
                $(this).removeClass('fs_input_error');
            }
        });

    });

/*=========================================================================
    Typed
=========================================================================*/ 
    // Typed 1
    $(".typed-1").typed({
        strings: ["Jhon Doe.", "Graphic Designer.", "Web Designer."],
        typeSpeed: 120,
        cursorChar: "|",
        loop: true
    });

    // Typed 2
    $(".typed-2").typed({
        strings: ["People.", "Childrens.", "Womens."],
        typeSpeed: 120,
        cursorChar: "|",
        loop: true
    });

    // Typed 3
    $(".typed-3").typed({
        strings: ["Graphic Designer.", "Web Designer."],
        typeSpeed: 120,
        cursorChar: "|",
        loop: true
    }); 

/*=========================================================================
    Countdown
=========================================================================*/
    $('.fs_countdown').countdown('2018/02/25', function(event) {
      var $this = $(this).html(event.strftime( '<li><div><span>%-D</span> DAY%!D</div></li><li><div><span>%-H</span> HOUR%!H</div></li><li><div><span>%-M</span> MINUTE%!M</div></li><li><div><span>%-S</span> SECOND%!S</div></li>'));
    });

/*=========================================================================
    Counter Up Active
=========================================================================*/
    var counterSelector = $('.counter');
    counterSelector.counterUp({
        delay: 10,
        time: 1000
    });

/*=========================================================================
    Progress Bar Loading Effect
=========================================================================*/
    if ($('.content_section.content-17, .content_section.content-22, .skill_section.tab-7').length) {
        var barsSec = $(".content_section.content-17, .content_section.content-22, .skill_section.tab-7");
        var barsLoaded = false;
        if(barsSec[0]){
            $(window).on("scroll", function(){
                var _offsetTop = $(this).scrollTop() - barsSec.offset().top;
                if(!barsLoaded){
                    if(_offsetTop >= -550){

                        barsSec.find(".progress-bar").each(function(){
                            var _this = $(this);
                            _this.css('width',_this.data('skill-value')+'%');
                        });
                        barsLoaded = true;
                    }
                }
            });
        }
    }

/*=========================================================================
    Flickr Feed
=========================================================================*/ 
    $('#flickr-feed').jflickrfeed({
        limit: 8,
        qstrings: {
            id: '152704974@N02'
        },
        itemTemplate: '<div class="feed-media">'+
                        '<a class="flickr-light" href="{{image}}" title="{{title}}">' +
                            '<img src="{{image_s}}" alt="{{title}}" />' +
                        '</a>' +
                      '</li>'
    }, function(data) {
        $('.flickr-light').venobox({
            numeratio: true,
            infinigall: true
        }); 
    });

/*=========================================================================
    Instagram Feed
=========================================================================*/
    var feed = new Instafeed({
        get: 'user',
        clientId: 'b84a5448343245f88dd43e62ba0cc9a8',
        accessToken: '4793566378.b84a544.7bc3d435c78d43beb7766d0387395ddd',
        userId: '4793566378',
        limit: 6,
        template: '<a href="{{link}}" target="_blank"><img src="{{image}}" /></a>'
    });
    feed.run();

/* ===========================================================
   Twitter Feed
============================================================== */
    function handleTweets(tweets) {
        
        var x = tweets.length,
        n = 0,
        element = document.getElementById('twitter-feed'),
        html = '<div class="twitter-carousel owl-carousel">';
        while (n < x) {
            html += '<div class="tweet-single">' + tweets[n] + '</div>';
            n++;
        }
        html += '</div>';
        
        element.innerHTML = html;
           
        /* Tweets attached to owl-carousel */
        $(".twitter-carousel").owlCarousel({
            loop: true,
            autoplay: true,
            smartSpeed: 1000,
            dots: false,
            items: 1
        });
    }

    if( $('#twitter-feed').length ) 
    {   
        var config_feed = {
        "profile": {"screenName": 'wowthemez'},
          "domId": 'twitter-feed',
          "maxTweets": 3,
          "enableLinks": true,
          "showUser": true,
          "showTime": true,
          "dateFunction": '',
          "showRetweet": false,
          "customCallback": handleTweets,
          "showInteraction": false
        };
        twitterFetcher.fetch(config_feed);
    }

/*=========================================================================
    Isotope Active
=========================================================================*/
    var PortfolioEl = $('.portfolio_items'),
        FilterEl = $('.portfolio_filter li');
    PortfolioEl.imagesLoaded( function() {

         // Add isotope click function
        FilterEl.on( 'click', function(){
            FilterEl.removeClass("active");
            $(this).addClass("active");
     
            var selector = $(this).attr('data-filter');
            PortfolioEl.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });
            return false;
        });

        PortfolioEl.isotope({
            itemSelector: '.single_item',
            layoutMode: 'fitRows',
        });
    });

    var PortfolioElMason = $('.portfolio_items_m'),
        FilterElMason = $('.portfolio_filter li');
    PortfolioElMason.imagesLoaded( function() {

         // Add isotope click function
        FilterElMason.on( 'click', function(){
            FilterElMason.removeClass("active");
            $(this).addClass("active");
     
            var selector = $(this).attr('data-filter');
            PortfolioElMason.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });
            return false;
        });

        PortfolioElMason.isotope({
            itemSelector: '.single_item',
            layoutMode: 'masonry',
        });
    });

/*=========================================================================
    Easy Pie Chert Actice
=========================================================================*/
    $(".chart-1").easyPieChart({
        barColor: "#232323",
        trackColor: "#ddd",
        scaleColor: false,
        lineWidth: 5,
        animate: 2000,
        size: 130,
        onStep: function(from, to, percent) {
            $(this.el).find(".percent span").text(Math.round(percent));
        }
    });

/*=========================================================================
    Tab And Accordion
=========================================================================*/
    if ($('.accordion-box').length) {
        $('.accordion-box .acc-heading').click(function() {
            if ($(this).hasClass('active') !== true) {
                $('.accordion-box .acc-heading').removeClass('active');
            }

            if ($(this).next('.acc-content').is(':visible')) {
                $(this).removeClass('active');
                $(this).next('.acc-content').slideUp(500);
            } else {
                $(this).addClass('active');
                $('.accordion-box .acc-content').slideUp(500);
                $(this).next('.acc-content').slideDown(500);
            }
        });
    }

/*=========================================================================
    Active venobox
=========================================================================*/
    var vbSelector = $('.img_popup');
    vbSelector.venobox({
        numeratio: true,
        infinigall: true
    }); 

/*=========================================================================
    Smooth Scroll
=========================================================================*/  
    smoothScroll.init({
        offset: 60
    });
    
/*=========================================================================
    Active Tooltip
=========================================================================*/
    $('[data-toggle="tooltip"]').tooltip();


})(jQuery);

// Slider Loader Function
function LoadOwlSlider(){

    // Slider 1
    var owlSlider1 = $('#main-slider-1');
    owlSlider1.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: false,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    // Slider animation
    owlSlider1.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('slideInUp animated').hide();
        $('.slider_content p, .slider_content .fs_btn').removeClass('fadeInUp animated').hide();
    });

    owlSlider1.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('slideInUp animated').show();
        $('.owl-item.active .slider_content p, .owl-item.active .slider_content .fs_btn').addClass('fadeInUp animated').show();
    });

    // Slider 2
    var owlSlider2 = $('#main-slider-2');
    owlSlider2.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    // Slider animation
    owlSlider2.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('fadeInUp animated').hide();
        $('.slider_content p').removeClass('fadeInUp animated').hide();
        $('.slider_content .btn_group_left').removeClass('fadeInDown animated').hide();
    });

    owlSlider2.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content p').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content .btn_group_left').addClass('fadeInDown animated').show();
    });

    // Slider 3
    var owlSlider3 = $('#main-slider-3');
    owlSlider3.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    // Slider animation
    owlSlider3.on('translate.owl.carousel', function () {
        $('.slider_content h1, .slider_content p, .slider_content .btn_group').removeClass('fadeInRight animated').hide();
        $('.slider_left').removeClass('fadeInLeft animated').hide();
    });

    owlSlider3.on('translated.owl.carousel', function () {
        $('.slider_content h1, .slider_content p, .slider_content .btn_group').addClass('fadeInRight animated').show();
        $('.owl-item.active .slider_left').addClass('fadeInLeft animated').show();
    });

    // Slider 4
    var owlSlider4 = $('#main-slider-4');
    owlSlider4.owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav:true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });

    owlSlider4.on("translate.owl.carousel", function(){
        $(".main_slide .hero_content").removeClass("animated zoomIn").css("opacity", "0");
    });
    
    owlSlider4.on("translated.owl.carousel", function(){
        $(".main_slide .hero_content").addClass("animated zoomIn").css("opacity", "1");
    });

    // Slider 5
    var owlSlider5 = $('#main-slider-5');
    owlSlider5.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider5.on('translate.owl.carousel', function () {
        $('.slider_content h1, .slider_content p').removeClass('fadeInLeft animated').hide();
        $('.slider_content .btn_group_left').removeClass('fadeInUp animated').hide();
    });

    owlSlider5.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1, .owl-item.active .slider_content p').addClass('fadeInLeft animated').show();
        $('.owl-item.active .slider_content .btn_group_left').addClass('fadeInUp animated').show();
    });

    // Slider 6
    var owlSlider6 = $('#main-slider-6');
    owlSlider6.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider6.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('bounceInDown animated').hide();
        $('.slider_content p').removeClass('fadeInUp animated').hide();
        $('.slider_content .btn_group').removeClass('fadeInDown animated').hide();
    });

    owlSlider6.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('bounceInDown animated').show();
        $('.owl-item.active .slider_content p').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content .btn_group').addClass('fadeInDown animated').show();
    });

    // Slider 7
    var owlSlider7 = $('#main-slider-7');
    owlSlider7.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider7.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('fadeInUp animated').hide();
        $('.slider_content p').removeClass('fadeInUp animated').hide();
        $('.slider_content .btn_group').removeClass('fadeInDown animated').hide();
    });

    owlSlider7.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content p').addClass('fadeInUp animated').show();
        $('.owl-item.active .slider_content .btn_group').addClass('fadeInDown animated').show();
    });

    // Slider 8
    var owlSlider8 = $('#main-slider-8');
    owlSlider8.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider8.on('translate.owl.carousel', function () {
        $('.slider_content h1, .slider_content p, .slider_content a.fs_btn').removeClass('fadeInUp animated').hide();
    });

    owlSlider8.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1, .owl-item.active .slider_content p, .owl-item.active .slider_content a.fs_btn').addClass('fadeInUp animated').show();
    });

    // Slider 9
    var owlSlider9 = $('#main-slider-9');
    owlSlider9.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        mouseDrag: false,
        touchDrag: false,
        autoplay: true,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider9.on('translate.owl.carousel', function () {
        $('.slider_content h1').removeClass('slideInUp animated').hide();
        $('.slider_content p, .slider_content .fs_btn').removeClass('fadeInUp animated').hide();
    });

    owlSlider9.on('translated.owl.carousel', function () {
        $('.owl-item.active .slider_content h1').addClass('slideInUp animated').show();
        $('.owl-item.active .slider_content p, .owl-item.active .slider_content .fs_btn').addClass('fadeInUp animated').show();
    });

    // Slider 10
    var owlSlider10 = $('#main-slider-10');
    owlSlider10.owlCarousel({
        items: 1,
        loop: true,
        smartSpeed: 500,
        autoplayTimeout: 3500,
        autoplay: false,
        nav: true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
     
    owlSlider10.on('translate.owl.carousel', function () {
        $('.slider_content h1, .slider_content .list, .slider_content p, .slider_content a.fs_btn').removeClass('fadeInUp animated').hide();
        $('.slider_item .right_img').removeClass('slideInRight animated').hide();
    });

    owlSlider10.on('translated.owl.carousel', function () {
        $('.slider_content h1, .slider_content .list, .slider_content p, .slider_content a.fs_btn').addClass('fadeInUp animated').show();
        $('.slider_item .right_img').addClass('slideInRight animated').show();
    });

    // Slider 11
    var owlSlider11 = $('#main-slider-11');
    owlSlider11.owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav:true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });

    owlSlider11.on("translate.owl.carousel", function(){
        $(".main_slide .slider_content h1").removeClass("animated fadeInRight").css("opacity", "0");
        $(".main_slide .slider_content p, .main_slide .slider_content .btn_group").removeClass("animated fadeInRight").css("opacity", "0");
    });

    // Slider 11
    var owlSlider12 = $('#main-slider-12');
    owlSlider12.owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav:true,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>']
    });
    
    owlSlider11.on("translated.owl.carousel", function(){
        $(".main_slide .slider_content h1").addClass("animated fadeInRight").css("opacity", "1");
        $(".main_slide .slider_content p, .main_slide .slider_content .btn_group").addClass("animated fadeInRight").css("opacity", "1");
    });

    // Content 27 slide
    $('#content-27-slide, #carousel-7-trigger, #carousel-8-trigger, #testi-2-trigger, #testi-6-trigger, #testi-10-trigger, #testi-15-trigger').owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        dots: false,
        nav:true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
    });

/*=========================================================================
    Carousel 
=========================================================================*/
    var stuffSelector = $('#stuff_carousel, #stuff_carousel_2, #carousel-9-trigger');
    stuffSelector.owlCarousel({
        loop:true,
        margin:10,
        center: true,
        smartSpeed: 500,
        autoWidth: true,
        nav: true,
        autoplay: false,
        navText: ["<i class='fa fa-long-arrow-left'></i>", "<i class='fa fa-long-arrow-right'></i>"],
        dots: false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });     

// App Screen Carousel
    function getSlide() {
        var wW = $(window).width();
        if (wW < 750) {
            return 1;
        }
        return 3;
    }
  
    var mySwiper = $('.screen_carousel').swiper({
        mode:'horizontal',
        loop: true,
        speed: 1000,
        autoplay: 1000,
        effect: 'coverflow',
        slidesPerView: getSlide(),
        grabCursor: true,
        pagination: '.screen-pagination',
        paginationClickable: true,
        nextButton: '.arrow-right',
        prevButton: '.arrow-left',
        keyboardControl: true,
        coverflow: {
            rotate: 0,
            stretch: 90,
            depth: 200,
            modifier: 1,
            slideShadows : true
        }
    });

    // App carousel 2
     $('#app_carousel_2').owlCarousel({
        loop:true,
        margin: 20,
        autoplay: true,
        responsiveClass:true,
        smartSpeed: 500,
        dots: false,
        nav:true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
        
    });

     // Carousel 3
     $('#product-carousel-3').owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        dots: false,
        margin: 10,
        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsive : {
            0 : {
                items: 1
            },
            480 : {
                items: 3
            },
            768 : {
                items: 4
            }
        }
    });

     // Carousel 4
     $('#carousel-4-trigger, #carousel-5-trigger, #carousel-10-trigger, #carousel-11-trigger').owlCarousel({
        loop:true,
        margin: 20,
        autoplay: true,
        smartSpeed: 500,
        dots: false,
        nav:true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2,
                margin:10
            },
            1000:{
                items:3
            }
        }
    });

    //  Carousel 6
    $('#carousel-6-trigger').owlCarousel({
        loop:true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav:false
    });

    $("#carousel-6-trigger").on("translate.owl.carousel", function(){
        $(".slide_content .project_info").removeClass("animated zoomIn").css("opacity", "0");
    });
    
    $("#carousel-6-trigger").on("translated.owl.carousel", function(){
        $(".slide_content .project_info").addClass("animated zoomIn").css("opacity", "1");
    });

    //  Client Carousel
    var sponsorCarousel = $('#client-1-trigger');
    sponsorCarousel.owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        smartSpeed: 1000,
        nav: false,
        dots: false,
        responsive: true,
        responsive : {
            0 : {
                items: 3
            },
            480 : {
                items: 3,
            },
            768 : {
                items: 6,
            }
        }
    });

    //  Testimonial Carusel
    var testiSelector = $('#testi-1-trigger, #testi-3-trigger, #testi-4-trigger, #testi-11-trigger, #testi-12-trigger');
    testiSelector.owlCarousel({
        loop: true,
        autoplay: true,
        smartSpeed: 500,
        items: 1,
        nav: false
    }); 

    $('#testi-7-trigger').owlCarousel({
        loop:true,
        margin: 20,
        autoplay: true,
        smartSpeed: 500,
        dots: false,
        nav:true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2,
                margin:10
            },
            1000:{
                items:2
            }
        }
        
    });

    //  Testimonial 19
    var testiCarousel = $('#testi-19-trigger');
      testiCarousel.owlCarousel({
            loop: true,
            autoplay: false,
            smartSpeed: 800,
            margin: 20,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    items: 1
                },
                // breakpoint from 480 up
                520 : {
                    items: 1
                },
                // breakpoint from 768 up
                768 : {
                    items: 2
                }
            }
        });

      //  Client 4
      $('#client-4-trigger').owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            smartSpeed: 1000,
            nav: false,
            dots: false,
            responsive: true,
            responsive : {
                0 : {
                    items: 3
                },
                480 : {
                    items: 3,
                },
                768 : {
                    items: 8,
                }
            }
        });
}

// Isotope Loader Function
function LoadIsotope(){
    var PortfolioEl = $('.portfolio_items'),
        FilterEl = $('.portfolio_filter li');
    PortfolioEl.imagesLoaded( function() {

         // Add isotope click function
        FilterEl.on( 'click', function(){
            FilterEl.removeClass("active");
            $(this).addClass("active");
     
            var selector = $(this).attr('data-filter');
            PortfolioEl.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });
            return false;
        });

        PortfolioEl.isotope({
            itemSelector: '.single_item',
            layoutMode: 'fitRows',
        });
    });

    var PortfolioElMason = $('.portfolio_items_m'),
        FilterElMason = $('.portfolio_filter li');
    PortfolioElMason.imagesLoaded( function() {

         // Add isotope click function
        FilterElMason.on( 'click', function(){
            FilterElMason.removeClass("active");
            $(this).addClass("active");
     
            var selector = $(this).attr('data-filter');
            PortfolioElMason.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false,
                }
            });
            return false;
        });

        PortfolioElMason.isotope({
            itemSelector: '.single_item',
            layoutMode: 'masonry',
        });
    });
}

// Lightbox Loader Function
function LoadLightboxInit() {

    var vbSelector = $('.img_popup');
    vbSelector.venobox({
        numeratio: true,
        infinigall: true
    }); 
    
}

function LoadCounter(){
    $('.fs_countdown').countdown('2018/02/25', function(event) {
      var $this = $(this).html(event.strftime( '<li><div><span>%-D</span> DAY%!D</div></li><li><div><span>%-H</span> HOUR%!H</div></li><li><div><span>%-M</span> MINUTE%!M</div></li><li><div><span>%-S</span> SECOND%!S</div></li>'));
    });
}
