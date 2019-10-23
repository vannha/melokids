/**
 * Custom OWL in theme
 */
(function ($) {
    "use strict";
    $(window).on('load',function () {
        /* add first/last/center class */
        function melokids_owl_flc(e) {
            var idx = $(e.target).find('.owl-item');
            idx.removeClass('first last'), 
            idx.eq(e.item.index).addClass('first'), 
            idx.eq(e.item.index + e.page.size - 1).addClass('last')
        }
        $(".zk-carousel").each(function () {
            var $this = $(this),
                slide_id = $this.attr('id'),
                slider_settings = zkcarousel[slide_id];
            $this.on("initialized.owl.vccarousel", function(e) {
               melokids_owl_flc(e);
            }),
            $this.vcOwlCarousel(slider_settings),
            $this.on("changed.owl.vccarousel", function(e) {
                melokids_owl_flc(e)
            })
        });
        $('.related.products .products').each(function(){
            var $this = $(this),
                rtl = $('body').hasClass('rtl');
            $this.addClass('owl-carousel');
            $this.vcOwlCarousel({
                rtl: rtl,
                items: 4,
                loop: true,
                autoplay: true,
                autoplayTimeout: 2000,
                slideBy: 'page',
                responsive : {
                    480 : {
                        items : 1,
                    },
                    768 : {
                        items : 2,
                    },
                    991 : {
                        items : 3,
                    },
                    1200 : {
                        items : 4,
                    }
                }
            });
        });
    });
})(jQuery)