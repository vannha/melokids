/**
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
*/
jQuery(document).ready(function($) {
    "use strict";
    /* window */
    var window_width, window_height, scroll_top;
    var zk_responsiveRefreshRate = 200;
    /* admin bar */
    var adminbar = $('#wpadminbar'),
        adminbar_height = 0;
    /* Loading */
    var loading_page = $('#zk-loading'),
        loading_page_h = 0;
    /* rev before header */
    var rev_before_header = $('.zk-header-rev-slider'),
        rev_before_header_h = 0;
    /* header top */
    var  header_top = $('#zk-header-top'),
         header_top_height = 0;
    /* header menu */
    var header = $('#zk-header'),
        header_height;
    /* Header v2 */
    var header_inner = $('#zk-header .zk-header-inner'),
        zk_logo = $('#zk-header-logo'),
        zk_navigation_left = $('#zk-navigation-left'), 
        zk_navigation_right = $('#zk-navigation-right'),
        zk_navigation_attr = $('#zk-header .zk-nav-extra'),
        center_menu = $('#zk-navigation.pull-center .zk-main-navigation > ul'),
        header_inner_w,
        zk_logo_w, 
        zk_navigation_left_width, 
        zk_navigation_right_width, 
        zk_navigation_attr_width,
        center_menu_w;
    /* Boxed */
    var body = $('body'),
        body_padding_left,
        body_padding_right,
        boxed = $('body.zk-boxed'),
        boxed_w,
        boxed_row = boxed.find('.vc_row[data-vc-stretch-content]'),
        boxed_row_padding;
    /* scroll status */
    var scroll_status = '';

    if(typeof $.magnificPopup != 'undefined'){
        $('.mfp-search').magnificPopup({
            type:'inline',
            focus: '.search-field',
            closeBtnInside: false,
            removalDelay: 400,
            mainClass: 'zk-mfp-popup zk-mfp-search slideInDown animated',
            callbacks: {
                beforeClose: function() {
                    $('.zk-mfp-popup').addClass('slideOutDown').removeClass('slideInDown');
                },
            }
        });

        $('.mfp-html').magnificPopup({
            type:'inline',
            alignTop: true,
            closeBtnInside: false,
            removalDelay: 400,
            mainClass: 'zk-mfp-popup zoomIn animated',
            callbacks: {
                beforeClose: function() {
                    $('.zk-mfp-popup').addClass('zoomOut').removeClass('zoomIn');
                },
            }
        });

        $('.mfp-inline').magnificPopup({
            type:'inline',
            closeBtnInside: false,
            removalDelay: 400,
            mainClass: 'zk-mfp-popup slideInDown animated',
            callbacks: {
                open: function(){
                    $('.product_list_widget li').each(function(){
                        var img_h = $(this).find('img').innerHeight(),
                            padding_top = parseInt($(this).css('padding-top')),
                            padding_bottom = parseInt($(this).css('padding-bottom'));
                        $(this).css('min-height',img_h + padding_top + padding_bottom);
                    });
                },
                beforeClose: function() {
                    $('.zk-mfp-popup').addClass('slideOutDown').removeClass('slideInDown');
                },
            }
        });
        
        $('.entry-media').each(function() {
            $(this).magnificPopup({
                delegate: 'a.prettyphoto', 
                type: 'image',
                closeBtnInside: false,
                gallery:{
                    enabled:true
                },
                removalDelay: 400,
                mainClass: 'zk-mfp-popup zk-mfp-gallery zoomIn animated',
                callbacks: {
                    beforeClose: function() {
                        $('.zk-mfp-popup').addClass('zoomOut').removeClass('zoomIn');
                    },
                }
            });
        });
    }
    /**
     * window load event.
     * 
     * Bind an event handler to the "load" JavaScript event.
     * @author Chinh Duong Manh
     */
    $(window).on('load', function() {
        /** current scroll */
        scroll_top = $(window).scrollTop();

        /** current window width */
        window_width = window.innerWidth;

        /** current window height */
        window_height = window.innerHeight;

        /* get admin bar height */
        adminbar_height = adminbar.length > 0 ? adminbar.outerHeight(true) : 0 ;
        /* get loading height */
        loading_page_h = loading_page.length > 0 ? loading_page.outerHeight(true) : 0 ;
        /* rev before header */
        rev_before_header_h = rev_before_header.length > 0 ? rev_before_header.outerHeight() : 0;
        /* Header Top */
        header_top_height = header_top.length   > 0 ?  header_top.outerHeight() : 0;
        /* Header */
        header_height = header.length   > 0 ?  header.outerHeight() : 0;
        /* Header V2 */
        header_inner_w = header_inner.length > 0 ? header_inner.innerWidth() : 0;
        zk_logo_w = zk_logo.length > 0 ? zk_logo.outerWidth() : 0;
        zk_navigation_left_width = zk_navigation_left.length > 0 ? zk_navigation_left.outerWidth() : 0;
        zk_navigation_right_width = zk_navigation_right.length > 0 ? zk_navigation_right.outerWidth() : 0;
        zk_navigation_attr_width = zk_navigation_attr.length > 0 ? zk_navigation_attr.outerWidth() : 0;
        center_menu_w = center_menu.length > 0 ? center_menu.innerWidth() : 0;
        /* Custom VC row */
        body_padding_left = parseInt(body.css('padding-left'));
        body_padding_right = parseInt(body.css('padding-right'));
        boxed_w = boxed.outerWidth();
        boxed_row_padding = parseInt(boxed_row.css('left'));

        /* Page Loading */
        zk_page_loading();

        /* Header OnTop */
        zk_header_ontop();
        zk_header_ontop_next();
        /* Header Sticky */
        zk_header_sticky();
        /* Mobile Menu */
        zk_mobile_menu();
        zk_join_mobile_menu();

        zk_animation();
        zk_overlay();
        zk_hoverbox();
        zk_link_color();
        /* Masonry */
        zk_masonry();
        /* Media embed */
        zk_auto_video_width();

        zk_input_checkbox_radio();

        /* Close vc row */
        zk_vc_row_close();
    });

    /**
     * reload event.
     * 
     * Bind an event handler to the "navigate".
     */
    window.onbeforeunload = function(){
        zk_page_loading(1);
    };
    
    /**
     * resize event.
     * 
     * Bind an event handler to the "resize" JavaScript event, or trigger that event on an element.
     * @author Chinh Duong Manh
     */
    var zk_resize_menu_event ;
    $(window).on('resize', function(event, ui) {
        clearTimeout(zk_resize_menu_event);
        zk_resize_menu_event = setTimeout(function () {
            /** current window width */
            window_width = $(event.target).width();

            /** current window height */
            window_height = $(window).height();
            /* get admin bar height */
            adminbar_height = adminbar.length > 0 ? adminbar.outerHeight(true) : 0 ;
            /* get loading height */
            loading_page_h = loading_page.length > 0 ? loading_page.outerHeight(true) : 0 ;
            /* rev before header */
            rev_before_header_h = rev_before_header.length > 0 ? rev_before_header.outerHeight() : 0;
            /* Header Top */
            header_top_height = header_top.length   > 0 ?  header_top.outerHeight() : 0;

            /* Header */
            header_height = header.length   > 0 ?  header.outerHeight() : 0;
            /* Header V2 */
            header_inner_w = header_inner.length > 0 ? header_inner.innerWidth() : 0;
            zk_logo_w = zk_logo.length > 0 ? zk_logo.outerWidth() : 0;
            zk_navigation_left_width = zk_navigation_left.length > 0 ? zk_navigation_left.outerWidth() : 0;
            zk_navigation_right_width = zk_navigation_right.length > 0 ? zk_navigation_right.outerWidth() : 0;
            zk_navigation_attr_width = zk_navigation_attr.length > 0 ? zk_navigation_attr.outerWidth() : 0;
            center_menu_w = center_menu.length > 0 ? center_menu.innerWidth() : 0;
            /** current scroll */
            scroll_top = $(window).scrollTop();
            /* Custom VC row */
            body_padding_left = parseInt(body.css('padding-left'));
            body_padding_right = parseInt(body.css('padding-right'));
            boxed_w = boxed.outerWidth();
            boxed_row_padding = parseInt(boxed_row.css('left'));

            /* Header OnTop */
            zk_header_ontop();
            /* Header Sticky */
            zk_header_sticky();
            /* Mobile Menu */
            zk_mobile_menu();
            zk_join_mobile_menu();
            /* Masonry */
            zk_masonry();
            /* Media embed */
            zk_auto_video_width();

        },zk_responsiveRefreshRate);
    });
    
    /**
     * scroll event.
     * 
     * Bind an event handler to the "scroll" JavaScript event, or trigger that event on an element.
     * @author Chinh Duong Manh
     */
    $(window).on('scroll', function() {
        /** current scroll */
        scroll_top = $(window).scrollTop();

        /* check sticky menu. */
        zk_header_sticky();

        /* Back to top */
        zk_back_to_top();
    });
    /**
     * Page Loading.
     */
    function zk_page_loading($load) {
        switch ($load) {
            case 1:
                //$('#zk-loading').css('{"height":"100vh"}');
                $('#zk-page').css({"visibility":"hidden"}).addClass('zk-page-loading').removeClass('zk-page-loaded');
                break;
            default:
                $('#zk-loading').css({"height":"0","visibility":"hidden"}).removeClass('zk-page-loading').addClass('zk-page-loaded');
                $('#zk-page').css({"visibility":"visible"});
                break;
        }
    }
    
    /* Custom a tag regular/hover/active color
     * This function just applied for a tag
     * @author Chinh Duong Manh
     * @since 1.0.0
    */
    function zk_link_color(){
        "use strict";
        $('body').find('a').each(function(){
            var $this = $(this),
                $filter = $('.zk-filter-category');
            if($this.attr('data-color')){
                var regular_color   = $(this).data('color'),
                    hover_color     = $(this).data('color-hover'),
                    active_color    = hover_color;
                $(this).css('color',regular_color);
                $this.on('mouseenter',function(e){
                    e.preventDefault();
                    $(this).css('color',hover_color);
                });
                $this.on('mouseleave',function(e){
                    e.preventDefault();
                    $(this).not('.active').css('color',regular_color);
                });
                if($this.hasClass('active')){
                    $(this).css('color', active_color);
                };
                $this.on('click',function(){
                   $filter.find('a').css('color',regular_color);
                   $(this).css('color', active_color);
                });
            }
        });
    }

    /** Header On Top
     * add TOP position for header on top
     * @author Chinh Duong Manh
     * @since 1.0.0
    */
    
    function zk_header_ontop(){
        var header_ontop = $('.header-ontop'),
            header_ontop_next = $('#zk-page-title-wrapper'),
            header_ontop_next_padding_top = parseInt(header_ontop_next.css('padding-top'));
        header_ontop.css('top', adminbar_height + header_top_height); 
    }
    function zk_header_ontop_next(){
        var header_ontop = $('.header-ontop'),
            header_ontop_next = header_ontop.next('#zk-page-title-wrapper'),
            header_ontop_next_padding_top = parseInt(header_ontop_next.css('padding-top'));
        header_ontop_next.css('padding-top', adminbar_height + header_ontop_next_padding_top); /* Add padding for next section */
    }

    /** Sticky menu
     * Show or hide sticky menu.
     * @author Chinh Duong Manh
     * @since 1.0.0
     */
    function zk_header_sticky() {
        var header_sticky = $('.header-sticky'),
            header_ontop  = $('.header-ontop'), 
            header_slider = $('.zk-header-rev-slider').outerHeight();

        if (header.hasClass('sticky-on') && (header_height + header_slider  < scroll_top) && window_width >= 1200) {
            header.addClass('header-sticky');
            header_sticky.css('top',adminbar_height);
            if(header.hasClass('header-sticky-only')){
                header.removeClass('header-default');
            } else if(header.hasClass('header-ontop-sticky')){
                header.removeClass('header-ontop');
            }
        } else {
            header.removeClass('header-sticky');
            header_sticky.css('top','');
            if(header.hasClass('header-sticky-only')){
                header.addClass('header-default');
            } else if(header.hasClass('header-ontop-sticky')){
                header.addClass('header-ontop');
            }
        }    
    }
    /* check mobile screen. */
    function zk_mobile_menu() {
        if (window_width < 1200) {
            $('ul.zk-main-nav').addClass('mobile-nav').removeClass('desktop-nav');
            /* Open Menu */
            $('#zk-menu-mobile').not(".binded").addClass("binded").on('click',function(){
                $(this).toggleClass('active');
                $('#zk-navigation').slideToggle(500);
                $('#zk-header-custom-mobile-content').slideToggle(500);
            });
        } else {
            $('#zk-menu-mobile').removeClass('active');
            $('ul.zk-main-nav').removeClass('mobile-nav').addClass('desktop-nav');
            $('#zk-navigation').css({'display':''});
        }
    }
    
    /**
     * Header 2 menu
    */
    function zk_join_mobile_menu() {
        var menu = $('#zk-navigation');

        if (window_width < 1200) {
            /* Add mobile menu for Header V2 */
            var $mainmenu_left = $('#zk-navigation-left .zk-menu-left');
            var $mainmenu_right = $('#zk-navigation-right .zk-menu-right');
            var $mobilemenu_1 = $mainmenu_left.clone();
            var $mobilemenu_2 = $mainmenu_right.clone();
                $mobilemenu_1.appendTo('#zk-navigation .zk-main-navigation');
                $mobilemenu_2.appendTo('#zk-navigation .zk-main-navigation');
            $('#zk-navigation-left').addClass('d-none');
            $('#zk-navigation-right').addClass('d-none');
            $('#zk-navigation-left ul.zk-menu-left').remove();
            $('#zk-navigation-right ul.zk-menu-right').remove();
        } else {
            /* Callback Menu Left */
            var $mainmenu_left = $('#zk-navigation .zk-menu-left');
            var $mobilemenu_1 = $mainmenu_left.clone();
            $mobilemenu_1.appendTo('#zk-navigation-left div.zk-main-navigation');
            $('#zk-navigation-left').removeClass('d-none');
            /* Callback Menu Right */
            var $mainmenu_right = $('#zk-navigation .zk-menu-right');
            var $mobilemenu_2 = $mainmenu_right.clone();
            $('#zk-navigation-right').removeClass('d-none');
            $mobilemenu_2.appendTo('#zk-navigation-right div.zk-main-navigation');
            /* Remove joined Left/Right Menu */
            $('.join-menu .zk-main-navigation').empty();
        }
    }
    /**
     * Scroll page 
     * @author Chinh Duong Manh
    */
    /*$('body').on('click', '.zk-scroll, .woocommerce-review-link, .is-one-page', function () {
        "use strict";
        var target = $(this.hash),
            offset = $('.header-sticky').innerHeight();
            target = target.length ? target : '';
        if (target.length) {
            $('html,body').animate({scrollTop: target.offset().top - offset - adminbar_height}, 750);
            return false;
        }
    });*/
    
    /* Show or hide Back to TOP  */
    function zk_back_to_top(){
        "use strict";
        if (scroll_top < window_height) {
            $('.zk-backtotop').removeClass('on');
        } else {
            $('.zk-backtotop').addClass('on');
        }
    }
    /* Add Animation 
     * add class animated to use animate.css
    */
    function zk_animation(){
        "use strict";
        $(".animated-wrap").each(function(){
            var $this = $(this);
            var animation_in = $this.find('.animated').data('animation-in'),
                animation_out = $this.find('.animated').data('animation-out');
            $this.on('mouseenter',function(e){
                e.preventDefault();
                $this.find('.animated').addClass(animation_in);
            });
            $this.on('mouseleave',function(e){
                e.preventDefault();
                $this.find('.animated').removeClass(animation_in);
            });
        });
    }
    /* Add overlay effect
     * add class animated to use animate.css
    */
    function zk_overlay(){
        "use strict";
        $(".overlay-wrap").each(function(){
            var $this = $(this);
            var animation_in = $this.find('.overlay').data('animation-in'),
                animation_out = $this.find('.overlay').data('animation-out');
            $this.on('mouseenter',function(e){
                e.preventDefault();
                $this.find('.overlay').addClass(animation_in).removeClass(animation_out);
            });
            $this.on('mouseleave',function(e){
                e.preventDefault();
                $this.find('.overlay').removeClass(animation_in).addClass(animation_out);
            });
        });
    }

    /* Add hoverbox effect
     * add class animated to use animate.css
    */
    function zk_hoverbox(){
        "use strict";
        $(".hoverbox-wrap").each(function(){
            var $this = $(this);
            var animation_in = $this.find('.static').data('static-in'),
                animation_out = $this.find('.static').data('static-out'),
                hover_in = $this.find('.hover').data('hover-in'),
                hover_out = $this.find('.hover').data('hover-out');
            $this.on('mouseenter',function(e){
                e.preventDefault();
                $this.find('.static').addClass(animation_in).removeClass(animation_out);
                $this.find('.hover').addClass(hover_in).removeClass(hover_out);
            });
            $this.on('mouseleave',function(e){
                e.preventDefault();
                $this.find('.static').removeClass(animation_in).addClass(animation_out);
                $this.find('.hover').removeClass(hover_in).addClass(hover_out);
            });
        });
    }
    /* Add Hover Direction
     * @source https://tympanus.net/codrops/2012/04/09/direction-aware-hover-effect-with-css3-and-jquery/
    */
    function zk_hoverdir(){
        "use strict";
        $('.zk-hoverdir').each(function() { 
            $(this).hoverdir({
                speed: 300, // Times in ms
                easing: 'ease',
                hoverDelay: 0, // Times in ms
                inverse: false,
                hoverElem: '.hoverdir'
            });
        });
    }
    /* Masonry */
    function zk_masonry(){
        "use strict";
        if(typeof $.fn.masonry != 'undefined'){
            var columnWidth = $('.zk-masonry').find('.masonry-size').width();
            if(columnWidth > 0){
                var masonry_size = '.masonry-size';
            } else {
                var masonry_size = '';
            }

            $('.zk-masonry').masonry({
                itemSelector: '.zk-masonry-item',
                columnWidth: masonry_size,
                percentPosition: true
            });
        }
    }
    /**
     * Media Embed dimensions
     * 
     * Youtube, Vimeo, Iframe, Video, Audio.
     * @author Chinh Duong Manh
     */
    function zk_auto_video_width() {
        "use strict";
        $('.entry-media iframe , .entry-media  video, .entry-media .wp-video-shortcode').each(function(){
            var v_width = $(this).parent().width();
            var v_height = Math.floor(v_width / (16/9));
            $(this).attr('width',v_width).css('width',v_width);
            $(this).attr('height',v_height).css('height',v_height);
        });
    }
    /**
     * Custom VC row stretch content 
     * Fix row stretch on Boxed layout
     * Fix row stretch on Header Left Side
     * Fix RTL language for VC row full width
     * @author Chinh Duong Manh
     * @since 1.0.0
     */
    function zk_custom_vc_row_stretch_content() {
        "use strict";
        var rtl = $('body').hasClass('rtl'),
            header4 = $('#zk-page.header-4'),
            header4_w,
            header4_content_width = $('#zk-page').innerWidth();
            if(window_width >= 1200){
                header4_w = $('#zk-header.zk-header-4').innerWidth();
            } else {
                header4_w = 0;
            }
        /* Boxed */
        boxed_row.css({'padding-left': parseInt(boxed_row_padding) * -1, 'padding-right': parseInt(boxed_row_padding) * -1});

        /* RevSlider Boxed */

        /* RevSlide Header 4 */
        header4.find('.rev_slider_wrapper').css({'width': header4_content_width, 'margin-left': header4_w});

        /* RTL Language */
        if (true == rtl) {
            /* Header 4 */
            header4.find('.vc_row[data-vc-stretch-content="true"]').css({
                'padding-right' : header4_w
            });

        } else {
            /* Header 4 */
            header4.find('.vc_row[data-vc-stretch-content="true"]').css({
                'padding-left' : header4_w
            });
        }
    }

    /**
     * Custom VC Row
     * Close vc row
    */
    function zk_vc_row_close(){
        "use strict";
        $('.close-row').each(function(){
            $(this).on('click', function(event){
                event.preventDefault();
                $(this).parent().addClass('removed-row').one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(e) {
                    $(this).remove();
                });
            }); 
        });
    }

    /**
     * Custom html input type checkbox / radio
     * 
    */
    function zk_input_checkbox_radio(){
        "use strict";
    }

    /* Ajax Complete */
    jQuery(document).ajaxComplete(function(event, xhr, settings){
        zk_animation();
        zk_overlay();
        zk_hoverbox();
    });

    /* Fix Scroll top when click pagination on VC Grid / VC Media Grid / VC Masonry / VC Media Masonry */
    var handle_custom_click_type = 0,clear_custom_click_handle;
    $(document).on('mousedown','.vc_grid-pagination .vc_grid-page, .vc_grid-owl-dots .vc_grid-owl-dot',function () {
        handle_custom_click_type = this;
        clearTimeout(clear_custom_click_handle);
        clear_custom_click_handle = setTimeout(function () {
            handle_custom_click_type = 0;
        },1000);
    });
    $(document).on('mouseup','.vc_grid-pagination .vc_grid-page, .vc_grid-owl-dots .vc_grid-owl-dot',function () {
        if(handle_custom_click_type == this)
        {
            var target_scroll = $(handle_custom_click_type).closest('.vc_grid-container-wrapper');
            if(!target_scroll.is('.vc_grid-container-wrapper'))
                target_scroll = $(handle_custom_click_type).closest('.vc_grid-container');
            if(target_scroll.prev().is('[class*="heading"]'))
                target_scroll = target_scroll.prev();
            $('html, body').animate({
                scrollTop: target_scroll.offset().top - 50
            }, 'slow');
        }
        else
            handle_custom_click_type = 0;
    });

    /* Custom animation */
    $('.zk-grid').each(function(){
        var vctime = 0;
        var vc_inner = $(this).children().length;
        var _vci = vc_inner - 1;
        $(this).find('.wpb_animate_when_almost_visible').each(function (index,obj) {
            $(this).css('animation-delay', vctime + 'ms');
            if(_vci === index){
                vctime = 0;
                _vci = _vci + vc_inner;
            }else{
                vctime = vctime + 100;
            }
        })
    });

    /**
     * Custom WP Pagination
     * add leading zero to number < 10
    */
    $.fn.pagination_leading_zero = function(){
        "use strict";
        this.each(function(){
            $(this).find('.screen-reader-text').remove();
            $(this).find('.page-numbers').each(function(){
                var content = parseInt( $(this).html() ),
                    num_length = content.toString().length;
                if($.isNumeric(content) && content <= 9 && num_length == 1){
                    $(this).prepend('0');
                }
            })
        });
    }
    $('.pagination').pagination_leading_zero();

    /* VC Element Pagination */
    $('.zk-posts').each(function(){
        "use strict";
        var $this = $(this),
            $id = $(this).attr('id');
        $this.find('a.page-numbers').live('click',function(){
            $this.fadeTo('slow',0.3);
            var $link = $(this).attr('href');
            jQuery.get($link,function(data){
                $this.html($(data).find('#'+$id).html());
                $this.fadeTo('slow',1);
                $('.hoverdir-wrap').ZKHoverDir();
                $('.hoverdir-wrap').parent().addClass('wpb_start_animation animated');
                zk_masonry();
                $this.find('.pagination').pagination_leading_zero();
            });
            $('html,body').animate({scrollTop: $this.offset().top - 100}, 750);
            return false;
        });
    });
});

/* Menu */
(function ($) {
    "use strict";
    $(document).ready(function(){
        $(window).on('load', function () {
            "use strict";
            zk_menu_touched_side();
            zk_make_menu_toggle();
        });
        $(window).on('resize', function (event, ui) {
            "use strict";
            zk_menu_touched_side();
        });
        function zk_menu_touched_side(){
            "use strict";
            var $menu = $('.zk-main-nav');
            if($(window).width() > 1200 ){
                $menu.find('li').each(function(){
                    var $submenu = $(this).find('> .sub-menu');
                    if($submenu.length > 0){
                        if($submenu.offset().left + $submenu.outerWidth() > $(window).innerWidth()){
                            $submenu.addClass('back');
                        } else if($submenu.offset().left < 0){
                            $submenu.addClass('back');
                        }
                        /* remove css style display from mobile to desktop menu */
                        $submenu.css('display','');
                    }            
                });
            }
        }
        function zk_make_menu_toggle(){
            "use strict";
            var $menu = $('ul');
            $menu.find('li').each(function(){
                var $submenu = $(this).find('> ul'),
                    $megamenu = $(this).find('> .sub-megamenu');
                if($submenu.length > 0){
                    $(this).not('.parent').addClass('parent');
                    $(this).find('>a').after('<span class="zk-toggle" onclick=""><span class="zk-toggle-inner"></span></span>');

                    $(this).on('click','>.zk-toggle', function(e){
                        e.preventDefault();
                        $(this).toggleClass('active');
                        var element = $(this).parent('li');
                        
                            element.children('ul').slideToggle();
                            element.children('.sub-megamenu').slideToggle();
                           
                    });
                }
                if($megamenu.length > 0){
                    $(this).not('.parent').addClass('parent');
                    $(this).find('>a').after('<span class="zk-toggle" onclick=""><span class="zk-toggle-inner"></span></span>');

                    $(this).on('click','>.zk-toggle', function(e){
                        e.preventDefault();
                        $(this).toggleClass('active');
                        var element = $(this).parent('li');
                        
                            element.children('.sub-megamenu').slideToggle();
                            element.children('ul').slideToggle();
                           
                    });
                }
            });
        }
    });

})(jQuery);

/* Hover Effect */
(function ($) { 
    "use strict";
    function ZKHoverDirection(ev, obj) {
        var w = $(obj).width(),
            h = $(obj).height(),
            x = (ev.pageX - $(obj).offset().left - (w / 2)) * (w > h ? (h / w) : 1),
            y = (ev.pageY - $(obj).offset().top - (h / 2)) * (h > w ? (w / h) : 1),
            d = Math.round( Math.atan2(y, x) / 1.57079633 + 5 ) % 4;
        return d;
    }
    function ZKHoverDirClass( ev, obj, state,current_class ) {
        "use strict";
        var direction = ZKHoverDirection( ev, obj ),
            class_suffix = null;
        
        switch ( direction ) {
            case 0 : class_suffix = '-top';    break;
            case 1 : class_suffix = '-right';  break;
            case 2 : class_suffix = '-bottom'; break;
            case 3 : class_suffix = '-left';   break;
        }
        $(obj).attr('class',current_class+ ' '+ state + class_suffix );
    }
    $.fn.ZKHoverDir = function () {
        "use strict";
        this.each(function () {
            var gl_class = '';
            $(this).hover(function(ev){
                gl_class = gl_class === '' ? $(this).attr('class') : gl_class;
                ZKHoverDirClass( ev, this, 'in',gl_class );
            },function(ev){
                gl_class = gl_class === '' ? $(this).attr('class') : gl_class;
                ZKHoverDirClass( ev, this, 'out',gl_class );
            })
        })
    }
    $('.hoverdir-wrap').ZKHoverDir();
 })(jQuery);


/* Slect 2 */
jQuery(document).ready(function($) {
    "use strict";
    if(typeof $.select2 != 'undefined'){
        $('select').select2({
            theme: 'theme'
        });
    }
});


/**
 * Woo Smart Wishlist
 * update wishlist count on header 
*/
jQuery( document ).ready( function( jQuery ) {
    // add
    jQuery( 'body' ).on( 'click','.woosw-btn', function(e) {
        "use strict";
        var _this = jQuery( this );
        var product_id = _this.attr( 'data-id' );
        var data = {
            action: 'wishlist_add',
            product_id: product_id
        };
        jQuery.post( woosw_vars.ajax_url, data, function( response ) {
            response = JSON.parse( response );
            jQuery('.wswl-count').attr('data-count',response['count']);
            jQuery('.wswl-count').html(response['count']);
        });
    } );
    // remove
    jQuery( 'body' ).on( 'click', '.woosw-content-item--remove span', function( e ) {
        var _this_item = jQuery( this ).closest( '.woosw-content-item' );
        var product_id = _this_item.attr( 'data-id' );
        var data = {
            action: 'wishlist_remove',
            product_id: product_id
        };
        jQuery.post( woosw_vars.ajax_url, data, function( response ) {
            response = JSON.parse( response );
            jQuery('.wswl-count').attr('data-count',response['count']);
            jQuery('.wswl-count').html(response['count']);
        } );
    } );
});


/**
 * Custom Inline Css
 *
*/
jQuery(document).ready(function ($) {
    var _inline_css = '<style data-type="zk-custom-css">';
    $(document).find('.zk-custom-css[data-css]').each(function(){
        var _this = $(this);
        _inline_css += _this.attr('data-css');
    });
    _inline_css += "</style>";
    $('head').append(_inline_css);
});
