/*jQuery(document).ready(function($){
    "use strict";
    $('.zk-main').each(function(){
        var $this = $(this),
            $id = $(this).attr('id'),
            $loading_class = 'loading';
        $this.find('.wc-layered-nav-term > a').live('click',function(){
            $this.fadeTo('slow',0.3).addClass($loading_class);
            var $link = $(this).attr('href');
            window.history.pushState({url: "" + $link + ""}, "", $link);
            jQuery.get($link,function(data){
                $this.html($(data).find('#'+$id).html());
                $this.fadeTo('slow',1).removeClass($loading_class);
            });
            //jQuery('audio,video').mediaelementplayer();
            return false;
        });
    })
});*/
// filter page
