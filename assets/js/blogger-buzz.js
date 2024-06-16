jQuery(document).ready(function ($){

    var brtl;
    if ($("body").hasClass('rtl')) {
        brtl = true;
    }else{
        brtl = false;
    }

    /**
      * Banner Slider
    */
    var owl = $('.banner-slider');
    owl.owlCarousel({
        items: blogger_buzz_script.home_banner_slider_column || 3,
        loop: true,
        margin: 10,
        dots:false,
        autoplay: true,
        smartSpeed: 3000,
        autoplayTimeout:7300,
        nav: true,
        rtl: brtl,
        responsive: {
            0: {
                mouseDrag: false,
                touchDrag: false,
                items: 1
            },
            600: {
                mouseDrag: false,
                touchDrag: false,
                items: 2

            },
            1000: {
                mouseDrag: true,
                touchDrag: true,
                items: blogger_buzz_script.home_banner_slider_column || 3

            }
        }
    });

    /**
     * Scrole Back to top
    */
    $('.back-to-top').click(function () {      // When arrow is clicked
        $('body,html').animate({
            scrollTop: 0                       // Scroll to top of body
        }, 3000);
    });


    /**
     * Responsive Menu
    */
    $('.main-menu-toggle').click(function () {
        $('.main-navigation').slideToggle('1000');
    });

    /**
     * Sub Menu
    */
    $('nav .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-plus"></i> </span>');
    $('nav .page_item_has_children').append('<span class="sub-toggle-children"> <i class="fa fa-plus"></i> </span>');

    $('nav .sub-toggle').click(function () {
        $(this).parent('.menu-item-has-children').children('ul.sub-menu').slideToggle('1000');
        $(this).children('.fa-plus').first().toggleClass('fa-minus');
    });

    $('.navbar .sub-toggle-children').click(function () {
        $(this).parent('.page_item_has_children').children('ul.sub-menu').slideToggle('1000');
        $(this).children('.fa-plus').first().toggleClass('fa-minus');
    });


    /**
     * Popup Sidebar Widget Area
    */
    $('.side-bar-toggler').on('click', function () {
        $('body').addClass('side-menu-open');
    });

    $('.close-side-menu').on('click', function () {
        $('body').removeClass('side-menu-open');

    });

    $('.side-overlay').on('click', function () {
        $('body').removeClass('side-menu-open');
        $('body').removeClass('responsive-menu-open');
    });



    /**
     * Search Popup
    */
    $('.search_main_menu ').click(function () {
        $('.search-content').addClass('search-content-act');
    });
    $('.search-close').click(function () {
        $('.search-content').removeClass('search-content-act');
    });



    /**
     * Theia sticky slider
    */
    var sticky_sidebar = blogger_buzz_script.sticky_sidebar;
    if( sticky_sidebar == 'enable' ){
        try{
            $('.content-area').theiaStickySidebar({
                additionalMarginTop: 30
            });

            $('.sidebar').theiaStickySidebar({
                additionalMarginTop: 30
            });
        }
        catch(e){
            //console.log( e );
        }
    }
    

    /**
     * Pre Loader
    */
    $(window).load(function() {
       $('.preloader').delay(300).fadeOut('slow');
    });


    /**
     * Light slider
     */
    $('.postgallery-carousel').lightSlider({
        item:1,
        loop:true,
        trl:true,
        pause:5000,
        auto:true,
        enableDrag:false,
        speed:2000,
        pager:false,
        rtl: brtl,
        prevHtml:'<i class="fa fa-angle-left"></i>',
        nextHtml:'<i class="fa fa-angle-right"></i>',
        onSliderLoad: function() {
            $('.postgallery-carousel').removeClass('cS-hidden');
        },
    });

    /**
     * sticky js
    */
    $(".sticky-nav").sticky({topSpacing:0,zIndex:99999999});

});
