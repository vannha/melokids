jQuery(document).ready(function(){
    "use strict";
    ocms_settings.afterRender = function(){

    }
    multiscrollInitial();
    function multiscrollInitial() {
        $('.oc-multiscroll').each(function(){
            $(this).multiscroll(ocms_settings);
        });
    }

    var main = $('.oc-multiscroll'),
        leftSideInside = main.find('.ocms-left .ocms-section'),
        rightSideInside = main.find('.ocms-right .ocms-section'),
        leftSide = main.find('.ocms-left'),
        rightSide = main.find('.ocms-right'),
        changed = false;

    var firstLeftSide = [];
    leftSideInside.each(function () {
        firstLeftSide.push($(this).clone())
    });

    var firstRightSide  = [];
    rightSideInside.each(function () {
        $(this).addClass('spot-right-side');
        firstRightSide.push($(this).clone())
    });

    var storageStyleObject = [], storageStyle = [];

    var initHandleSpliter = {
        init: function () {
            this.savingStyleAttributes();
            this.resizeEvent(this);
        },
        handleOrderBigScreen: function ( ) {
            if(changed === true) {

                $(document).find('.ocms-left .spot-right-side').remove();
                rightSideInside.each(function () {
                    $(this).css('height', '100%');
                });
                rightSide.show();

                $('html, body').css({'height':'100%','overflow':'hidden'});
                $('#multiscroll-nav').css('display', 'block');
                $.fn.multiscroll.build();
                $.fn.multiscroll.moveTo(1);
                this.turnBackStyleAttributes();
            }
        },
        handleOrderSmallScreen: function () {
            if(changed === true) {
                var reverse = firstRightSide;
                reverse = reverse.reverse();


                $('.ocms-left, .ocms-right, .spot-right-side, .ocms-section, .ms-tableCell, html, body').each( function() {
                    $(this).attr('style','');
                    $('#multiscroll-nav').css('display','none');
                });
            }
            var count = 0;
            leftSideInside.each(function () {
                $(this).after(reverse[count]);
                count+=1;
            });

            $.fn.multiscroll.destroy();
            rightSide.hide();
            $.fn.multiscroll.moveTo(1);

        },
        savingStyleAttributes: function() {
            var first_child = leftSide.find(">:first-child");
            var first_child_class = leftSide.find(">:first-child").attr('class');
            var second_child_class = first_child.find(">:first-child").attr('class');
            leftSide.find('[style]').each(function () {
                var this_class = $(this).attr('class');
                if (this_class == leftSide || this_class == first_child_class || this_class == second_child_class) {
                    var cLass = $(this).attr('class'),
                        reClassString = '';
                    cLass = cLass.split(' ');


                    for(var key in cLass) {
                        reClassString += '.' + cLass[key] + ' ';
                    }

                    storageStyleObject.push(reClassString);
                    storageStyle.push($(this).attr('style'));
                }
            });
        },
        turnBackStyleAttributes : function () {
            for(var key in storageStyleObject) {
                $(storageStyleObject[key]).attr('style', storageStyle[key] );
            }
        },
        resizeEvent: function ( ) {
            var $this = this;
            $this.resizeHandler();
            $(window).resize(function () {
                $this.resizeHandler();
            });
        },
        resizeHandler: function ( ) {
            if ($(window).width() < 992) {
                changed = true;
                this.handleOrderSmallScreen();
            } else {
                this.handleOrderBigScreen() ;
            }
        }
    };
    initHandleSpliter.init();

});

// Open footer
jQuery(document).ready(function(){
    "use strict";
    jQuery('#open-footer').on('click',function(){
        jQuery(this).toggleClass('active');
        jQuery(this).parent().find('#zk-footer').slideToggle();
    });
});