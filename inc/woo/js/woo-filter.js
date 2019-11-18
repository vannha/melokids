jQuery(document).ready(function($){
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
});
// filter page
jQuery(document).ready(function ($) {
    "use strict";
    var $window   = $( window );
    addActiveClassforColSwitcher();

    $(document).on('click', '.zk-filters-grid a', function (e) {
        e.preventDefault();

        var $this         = $( this ),
            windowWidth   = $window.width(),
            col           = $this.attr( 'data-cols' ),
            removeClasses = '',
            addClasses    = '';

        // save cookie
        Cookies.set( 'melokids_shop_col', col, {
            expires: 1,
            path   : '/'
        } );

        $(document).find( '.zk-filters-grid' ).find( 'a' ).removeClass( 'active' );
        $this.addClass( 'active' );
        
        removeClasses = 'columns-3 columns-4 columns-5';
        addClasses = 'columns-'+col;

        $(document).find('.products').removeClass( removeClasses ).addClass( addClasses );
        $(document).find( '.products' ).on( 'arrangeComplete', function() { 
            addActiveClassforColSwitcher();
        } );
    } );

    if ( Cookies.get( 'melokids_shop_col' ) ) { 
        $(document).find( '.zk-filters-grid a[data-cols="' + Cookies.get( 'melokids_shop_col' ) + '"]' ).trigger( 'click' );
    }

    function addActiveClassforColSwitcher(){  

        if ( ! $(document).find( '.zk-filters-grid' ).length ) {
            return;
        }

        var width  = $(document).find( '.products' ).width(),
            pWidth = $(document).find( '.products>.product' ).outerWidth();

        if(Cookies.get( 'melokids_shop_col' )){
            var col    = Cookies.get( 'melokids_shop_col' );

        } else {
            var col    = Math.round( width / pWidth );
        }
        $(document).find( '.zk-filters-grid' ).find( 'a' ).removeClass( 'active' );
        $(document).find( '.zk-filters-grid' ).find( 'a[data-cols="' + col + '"]' ).addClass( 'active' );
    }
    /**
     * Filter Area
	 * Open / Close filter area
	*/
    filtersArea();
    function filtersArea(){ 
        var _filters = document.querySelector( '.zk-filters-content' );

        if ( _filters ) {
            $( _filters ).removeClass( 'filters-opened' ).stop().hide();
        }

        $( '.open-filter' ).unbind( 'click' ).on( 'click', function( e ) {
            e.preventDefault();

            var _filters = document.querySelector( '.zk-filters-content' );

            if ( _filters.classList.contains( 'filters-opened' ) ) {
                closeFilters();
            } else {
                openFilters();
            }
        } );
        $('.open-filter').on('click', function(e){
            e.preventDefault();
            var _filters = document.querySelector( '.zk-filters-content' );
            if ( _filters.classList.contains( 'filters-opened' ) ) {
                closeFilters();
            }
        });
        var openFilters = function() {

            var _filters   = document.querySelector( '.zk-filters-content' ),
                _btnFilter = document.querySelector( '.open-filter' );

            _filters.classList.add( 'filters-opened' );
            $( _filters ).stop().slideDown( 300 );
            _btnFilter.classList.add( 'opened' );
        };

        var closeFilters = function() {

            var _filters   = document.querySelector( '.zk-filters-content' ),
                _btnFilter = document.querySelector( '.open-filter' );

            _filters.classList.remove( 'filters-opened' );
            $( _filters ).stop().slideUp( 300 );
            _btnFilter.classList.remove( 'opened' );
        };
    };
    /* Ajax Complete */
    jQuery(document).ajaxComplete(function(event, xhr, settings){
        filtersArea();
    });
});