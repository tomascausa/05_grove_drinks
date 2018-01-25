jQuery( document ).ready( function( $ ) {
    'use strict';

    handleJSStyling( $ );
    logoInTheMiddle( $ );
    handleBgColor( $ );
    setTransitionForCreativeTopItems( $, 0 );
    handleHmbMenu( $ );
    handleQuotes( $ );
    runMasonryForBlog( $ );
    stickyMenu( $ );
    backToTop( $ );
    clickOnSearchIcon( $ );
    handleMobile( $ );
    handleVideoImageContainer( $ );
    handleAlbumImageContainer( $ );
    justifiedGallery( $ );
    ajaxVcCfResponsive( $ );
    runUnslider( $ );
    handleParallax( $ );
    handleGoToNextSection( $ );
    hanldeJsLinks( $ );
    artemisSwpToggleMiniCart( $ );
    artemisSwpToggleMiniWishlist( $ );
    handleProductAttrShowcase( $ );
    handleVideoSection( $ );
    artemisSwpAddToWishlist( $ );
    artemisSwpRemoveWishlistItem( $ );
    artemisSwpQuantityChanger( $ );
    customAspectRatio( $ );
    makeProdImgCover( $ );
    lookTextOverImage($);
    handleLookBooks($);
    setTimeout( function() {
        setContentHeight( $ );
    }, 600 );
    

    customPageMenuStyle($);
    $( window ).scroll( function() {
        stickyMenu( $ );
        customPageMenuStyle($);
    } );

    handleFooterSidebarsHeight( $ );
    $( window ).on( "debouncedresize", function( event ) {
        handleJSStyling($);
        handleFooterSidebarsHeight( $ );
        runMasonryForBlog( $ );
        handleVideoImageContainer( $ );
        handleAlbumImageContainer( $ );
        ajaxVcCfResponsive( $ );
        customAspectRatio( $ );
        handleType2ProductSliderImgHeight( $ );
        lookTextOverImage($);
        handleLookBooks($);
        setTimeout(function() {
            setContentHeight( $ );
        }, 600);
        artemisSwpHandleProductsMasonry( $ );
        verticalPromoHeight($);
        atSwpSetScrollContainerHeight();
        handleLookbookArrowsOnResize($);
    } );

    imageOverText( $ );
    handlePostRating($);
    artemisSwpSelect2( $ );
    artemisSwpGridListSelector( $ );
    artemisSwpItemsPerRowSelector( $ );
    artemisSwpAddedToCartHandler( $ );
    artemisSwpHandleLoginPopup( $ );
    artemisSwpHandleQuickView( $ );

    handleType2ProductSliderImgHeight( $ );

    artemisSwpHandleType2TemplateVariationChangeImage($);
    artemisSwpHandleProductsMasonry($);
    handleFullScreenSearch();
    productsCategoryFilter();
    verticalPromoHeight($);
});
var artemisSwpStyleElement = document.createElement( 'style' ),
        artemisSwpStylesheet;

// Append style element to head
document.head.appendChild( artemisSwpStyleElement );
// Grab style sheet
artemisSwpStylesheet = artemisSwpStyleElement.sheet;

var artemisSwpRulesIndexes = [];
var artemisSwpRulesIdIndexes = [];

function artemisSwpAddStylesheet ( id, cssText, context ) {
    var foundIndex;
    if ( (foundIndex = artemisSwpRulesIdIndexes.indexOf( id )) > -1 ) {
        artemisSwpStylesheet.deleteRule( foundIndex );
        artemisSwpRulesIndexes.splice( foundIndex, 1 );
        artemisSwpRulesIdIndexes.splice( foundIndex, 1 );
    }
    artemisSwpStylesheet.insertRule( cssText, artemisSwpStylesheet.cssRules.length );
    artemisSwpRulesIndexes.push( {
        'context' : context,
        'ruleId'  : id
    } );
    artemisSwpRulesIdIndexes.push( id );
}


function artemisSwpGuid () {
    function s4 () {
        return Math.floor( (1 + Math.random()) * 0x10000 )
                .toString( 16 )
                .substring( 1 );
    }

    return s4() + '-' + s4() + '-' + s4() + '-' + s4() ;
}

function runMasonryForBlog ( $ ) {
    if ( ! $( '.lc_blog_masonry_container' ).length ) {
        return;
    }

    var $grid = $( '.lc_blog_masonry_container' ).imagesLoaded( function() {
        var gap_width = $grid.data( "gapwidth" );
        var container_width = $grid.width();
        var container_outer_width = $grid.outerWidth();
        var bricks_on_row = $grid.data( "bricksonrow" );


        var bricks_on_row_responsive = getMasonryBricksOnRow( $, bricks_on_row, container_outer_width );
        var brick_width = (container_width - (bricks_on_row_responsive - 1) * gap_width) / bricks_on_row_responsive;

        $( ".lc_blog_masonry_brick" ).css( "width", brick_width );
        $grid.masonry( {
            columnWidth  : brick_width,
            itemSelector : '.lc_blog_masonry_brick',
            gutter       : gap_width
        } );
        $grid.fadeTo( "400", 1 );
    } );
}

function getMasonryBricksOnRow ( $, default_number, container_outer_width, breakpoints ) {
    var breakpoints = $.extend({}, {1: 480, 2: 980, 3: 1680 },breakpoints);
    if ( container_outer_width <= breakpoints[1] ) {
        return 1;
    }
    else if ( container_outer_width <= breakpoints[2] ) {
        return 2;
    }
    else if ( container_outer_width <= breakpoints[3] ) {
        return 3;
    }
    else {
        return default_number;
    }
}

function runMasonryGallery ( $ ) {
    if ( ! $( '.lc_masonry_container' ).length ) {
        return;
    }

    var $grid = $( '.lc_masonry_container' ).imagesLoaded( function() {
        $grid.masonry( {
            itemSelector    : '.lc_masonry_brick',
            percentPosition : true,
            columnWidth     : '.brick-size',
        } );
        $grid.fadeTo( "400", 1 );
    } );
}

function runMasonryBlog ( $ ) {

    if ( ! $( '.lc_blog_masonry_container' ).length ) {
        return;
    }

    var $grid = $( '.lc_blog_masonry_container' ).imagesLoaded( function() {
        var default_width = $( '.blog-brick-size' ).width();
        var default_height = 3 / 4 * default_width;
        var is_grid_layout = false;
        var no_portrait_allowed = false;
        var fixed_content_height_mobile = 1.6;

        if ( $grid.hasClass( "grid_container" ) ) {
            is_grid_layout = true;
        }

        if ( (2 * default_width - $grid.width()) > 1 ) {
            no_portrait_allowed = true;
        }

        $( '.lc_blog_masonry_brick' ).each( function() {

            if ( $( this ).hasClass( 'has_thumbnail' ) ) {

                var $image = $( this ).find( 'img.lc_masonry_thumbnail_image' );
                var img_src = $image.attr( "src" );

                var $cover_div = $( this ).find( ".brick_cover_bg_image" );
                $cover_div.addClass( "lc_cover_bg" );
                $cover_div.css( "background-image", "url(" + img_src + ")" );

                var imageObj = new Image();
                imageObj.src = $image.attr( "src" );

                if ( is_grid_layout || no_portrait_allowed ) {
                    $( this ).css( "width", default_width );
                    $( this ).css( "height", default_height );
                    if ( default_width < 380 ) {
                        $( this ).css( "height", fixed_content_height_mobile * default_height );
                    }
                }
                else {
                    if ( imageObj.naturalWidth / imageObj.naturalHeight >= 1.6 ) {
                        $( this ).addClass( "landscape_brick" );
                        $( this ).css( "width", 2 * default_width );
                        $( this ).css( "height", default_height );
                    }
                    else if ( imageObj.naturalHeight / imageObj.naturalWidth >= 1.5 ) {
                        $( this ).addClass( "portrait_brick" );
                        $( this ).css( "width", default_width );
                        $( this ).css( "height", 2 * default_height );
                    }
                    else {
                        $( this ).css( "width", default_width );
                        $( this ).css( "height", default_height );
                    }
                }
            }
            else {
                $( this ).css( "width", default_width );
                $( this ).css( "height", default_height );
                if ( default_width < 380 ) {
                    $( this ).css( "height", fixed_content_height_mobile * default_height );
                }
            }
        } );


        $grid.masonry( {
            itemSelector    : '.lc_blog_masonry_brick',
            percentPosition : true,
            columnWidth     : '.blog-brick-size',
        } );
        $grid.fadeTo( "400", 1 );
    } );
}

function handleQuotes ( $ ) {
    $( 'blockquote' ).each( function() {
        $( this ).prepend( $( '<i class="fa fa-quote-right" aria-hidden="true"></i>' ) );
    } );
}
function handleJSStyling ( $ ) {
    function setBgImage(size){
        var imgSrc = $( this ).data( "bgimage" );

        $( this ).css( "background-image", "url(" + imgSrc + ")" );
        $( this ).css( "background-position", "center center" );
        $( this ).css( "background-repeat", "no-repeat" );
        $( this ).css( "background-size", size );
    }

    $( ".lc_swp_background_image" ).each( function() {
        setBgImage.apply(this,['cover']);
    } );
    $( ".lc_swp_background_image_fit" ).each( function() {
        setBgImage.apply( this, ['contain'] );
    } );
    $( ".lc_swp_background_image_normal" ).each( function() {
        setBgImage.apply( this, ['initial'] );
    } );

    $( ".lc_swp_cust_bg_color" ).each( function() {
        $(this).css("background-color", $(this).data("bgcolor"));
    } );    

    $( ".at_swp_js_css" ).each( function() {
        var custom_fs = $( this ).data( "atfs" );
        var custom_ls = $( this ).data( "atls" );
        var custom_fw = $( this ).data( "atfw" );
        var custom_height = $( this ).data( "height" );
        var custom_width = $( this ).data( "width" );
        var custom_border_width = $( this ).data( "border-width" );
        var fontWeight = $( this ).data( "font-weight" );

        if ( custom_fs ) {
            $( this ).css( "font-size", custom_fs + "px" );
        }
        if ( custom_ls ) {
            $( this ).css( "letter-spacing", custom_ls + "px" );
            if ($(this).hasClass('text_right')) {
                $(this).css("margin-right", 0 - custom_ls);
            }
        }
        if ( custom_fw ) {
            $( this ).css( "font-weight", custom_fw );
        }
        if ( custom_height ) {
            if ( parseInt( custom_height ) == custom_height ) {
                custom_height += 'px';
            }
            if ($(this).hasClass("look_image_over") 
                && ("100vh" == custom_height)
                && (document.documentElement.clientWidth < 768)) {
                $( this ).css( "height", "50vh");
            } else {
                /*default*/
                $( this ).css( "height", custom_height );
            }
            
        }
        if ( custom_border_width ) {
            $( this ).css( "border-width", custom_border_width + 'px' );
        }
        if ( custom_width ) {
            if ( parseInt( custom_width ) == custom_width ) {
                custom_width += 'px';
            }
            $( this ).css( "width", custom_width );
        }
        if( fontWeight ) {
            $( this ).css( "font-weight", fontWeight );
        }

        var custom_offset_left = $( this ).data( 'offset-left' );
        if ( custom_offset_left ) {
            if ( parseInt( custom_offset_left ) == custom_offset_left ) {
                custom_offset_left += 'px';
            }
            $( this ).css( "margin-left", custom_offset_left );
        }

        var custom_offset_right = $( this ).data( 'offset-right' );
        if ( custom_offset_right ) {
            if ( parseInt( custom_offset_right ) == custom_offset_right ) {
                custom_offset_right += 'px';
            }
            $( this ).css( "margin-right", custom_offset_right );
        }

        var custom_color = $( this ).data( 'color' );
        if ( custom_color ) {
            $( this ).css( 'color', custom_color );
        }
        var custom_zIndex = $( this ).data( 'z_index' );
        if ( custom_zIndex || custom_zIndex == 0 ) {
            $( this ).css( 'z-index', custom_zIndex );
        }

        /*custom colors for link*/
        if ($(this).parent().hasClass("use_custom_link_color")) {
            var cust_col = $(this).data("custcol");
            var cust_hover_col = $(this).data("custhcol");

            $(this).css("color", cust_col);

            if($(this).attr('data-custhcol') && $(this).hasClass('cust_hover_color')) {
                var $current_elt = $(this);
                $(this).parent().hover(
                    function() {
                        $current_elt.css("color", cust_hover_col);
                    }, function() {
                        $current_elt.css("color", cust_col);
                    }
                );
            }

            var elementCustomClass = 'at_swp_'+ artemisSwpGuid();
            $( this ).addClass( elementCustomClass);
            if ($(this).hasClass("at_link_line_before")) {
                /*set bg color for :before to cust_col*/
                var cssText = '.'+elementCustomClass+' { color: ' +cust_col +' !important; }';
                artemisSwpAddStylesheet( elementCustomClass, cssText, 'at_link_line_before');
                cssText = '.'+elementCustomClass+':hover { color: ' + cust_hover_col +' !important; }';
                artemisSwpAddStylesheet( elementCustomClass + '-hover', cssText, 'at_link_line_before');

                cssText = '.'+elementCustomClass+':before { background-color: ' +cust_col +' !important; }';
                artemisSwpAddStylesheet( elementCustomClass + '-before', cssText, 'at_link_line_before');
                cssText = '.'+elementCustomClass+':hover:before { background-color: ' + cust_hover_col +' !important; }';
                artemisSwpAddStylesheet( elementCustomClass+ '-before-hover', cssText, 'at_link_line_before');
            }
        }
    } );

    $( '.lc_custom_button_style' ).each( function() {
        var bg_color = $( this ).data( "bbgc" );
        var bg_color_hover = $( this ).data( "bbgch" );
        var txt_color = $( this ).data( "btc" );
        var txt_color_hover = $( this ).data( "btch" );
        var border_color = $(this).data("borderc");
        var border_color_hover = $(this).data("borderhc");
        var custom_letter_spacing = $(this).data("lsp");
        var button_direction = $(this).data("btndirection");
        var cust_hpadding = $(this).data("custhpadding");


        if (null == button_direction) {
            button_direction = "default";
        }

        if ( "default" != bg_color ) {
            $( this ).css( "background-color", bg_color );
            $( this ).find( 'a' ).css( "background-color", bg_color );
        }
        if ( "default" != bg_color_hover ) {
            var bg_color_before = "default" != bg_color ? bg_color : $( this ).css( 'background-color' );

            $( this ).find( 'a' ).hover(
                    function() {
                        $( this ).css( 'background-color', bg_color_hover );
                    }, function() {
                        $( this ).css( 'background-color', bg_color_before );
                    }
            );
        }

        if ( "default" != txt_color ) {
            $( this ).css( "color", txt_color );
            $( this ).find( 'a' ).css( "color", txt_color );
        }
        if ( "default" != txt_color_hover ) {
            var color_before = "default" != txt_color ? txt_color : $( this ).css( 'color' );

            $( this ).find( 'a' ).hover(
                    function() {
                        $( this ).css( 'color', txt_color_hover );
                    }, function() {
                        $( this ).css( 'color', color_before );
                    }
            );
        }
        if ((null != border_color) && ("default" != border_color)) {
            $(this).find('a').css("border-width", "1px");
            $(this).find('a').css("border-color", border_color);
        }
        if ((null != border_color_hover) && ("default" != border_color_hover)) {
            var border_before = "default" != border_color ? border_color : $(this).css('border-color');
            $(this).find('a').hover(
                    function() {
                        $(this).css('border-color', border_color_hover);
                    }, function() {
                        $(this).css('border-color', border_before);
                    }
            );            
        }
        if ("default" != custom_letter_spacing) {
            $(this).find('a').css("letter-spacing", custom_letter_spacing);
        }
        if ("default" != button_direction) {
            if ($(this).hasClass("button_center")) {
                /*make sure that existing button transition is used*/
                $(this).css("transform", "translateX(-50%) rotate(-90deg)");
            } else {
                $(this).css("transform", "rotate(-90deg)");
            }
        }
        if ("default" != cust_hpadding) {
            $(this).find("a").css("padding-left", cust_hpadding);
            $(this).find("a").css("padding-right", cust_hpadding);
        }

    } );

    var responsiveBreakPoints = {
        'xs' : [0, 576],
        'sm' : [576, 767],
        'md' : [768, 991],
        'lg' : [992, 1200],
        'xl' : [1200, 9999]
    };
    /* responsive font */
    function responsiveFont () {
        var windowWidth = $( window ).innerWidth();
        $( ".at_swp_js_css" ).each( function() {
            var responsiveData = $( this ).data( 'atresponsive' );
            if ( ! responsiveData ) {
                return;
            }
            var fontSize = - 1;
            var letterSpacing = - 1;
            for ( var bp in responsiveBreakPoints ) {
                if ( responsiveBreakPoints.hasOwnProperty( bp ) ) {
                    var lowerBound = responsiveBreakPoints[bp][0];
                    var upperBound = responsiveBreakPoints[bp][1];
                    if ( lowerBound <= windowWidth && windowWidth < upperBound ) {
                        if ( typeof responsiveData.fs[bp] !== "undefined" ) {
                            fontSize = responsiveData.fs[bp];
                        }
                        if ( typeof responsiveData.ls[bp] !== "undefined" ) {
                            letterSpacing = responsiveData.ls[bp];
                        }
                    }
                }
            }
            if ( fontSize != - 1 ) {
                $( this ).css( "font-size", fontSize + "px" );
            }
            if ( letterSpacing != - 1 ) {
                $( this ).css( "letter-spacing", letterSpacing + "px" );
            }

        } );
    }

    responsiveFont();
    $( window ).resize( responsiveFont );
}

function handleBgColor ( $ ) {
    $( ".lc_swp_overlay" ).each( function() {
        var bgColor = $( this ).data( "color" );

        $( this ).parent().css( "position", "relative" );

        $( this ).css( {
            "background-color" : bgColor,
            "position"         : "absolute"
        } );
    } );

    $( ".lc_swp_bg_color" ).each( function() {
        var bgColor = $( this ).data( "color" );
        $( this ).css( "background-color", bgColor )
    } );
}

function handleHmbMenu ( $ ) {
    $( ".hmb_menu,.at_login_popup_close" ).hover(
            function() {
                $( this ).find( '.hmb_line' ).addClass( 'hover' );
            }, function() {
                $( this ).find( '.hmb_line' ).removeClass( 'hover' );
            }
    );

    $( '.hmb_menu' ).click( function() {
        $( this ).find( '.hmb_line' ).toggleClass( 'click' );

        if ( $( this ).hasClass( 'hmb_creative' ) ) {
            $( '.nav_creative_container' ).toggleClass( 'visible_container' );

            var resetValues = $( '.nav_creative_container .creative_menu ul.menu > li' ).hasClass( 'menu_item_visible' ) ? 1 : 0;
            setTransitionForCreativeTopItems( $, resetValues );
            $( '.nav_creative_container .creative_menu ul.menu > li' ).toggleClass( 'menu_item_visible' );
        }

        if ( $( this ).hasClass( 'hmb_mobile' ) ) {
            if ( $( 'header' ).hasClass( 'sticky_enabled' ) ) {
                $( "body" ).animate( {scrollTop : 0}, 400, function() {
                    showMobileMenuContainer( $ );
                } );
            }
            else {
                showMobileMenuContainer( $ );
            }
        }
    } );

    $( '.creative_menu ul li a' ).click( function( event ) {
        var parent = $(this).parent();
        parent.siblings('.menu-item').find('ul').hide(200);
        if( parent.hasClass('menu-item-has-children') ){
            event.preventDefault();
        }
        parent.find( '> ul' ).stop().show( 200 );
    } );
}

var setTransitionForCreativeTopItems = function( $, resetValues ) {
    if ( ! $( ".nav_creative_container" ).length ) {
        return;
    }

    if ( resetValues == 1 ) {
        $( '.nav_creative_container .creative_menu ul.menu > li' ).each( function() {
            $( this ).css( {
                "-webkit-transition-delay" : "0s",
                "-moz-transition-delay"    : "0s",
                "transition-delay"         : "0s"
            } );
        } )

        return;
    }

    var start_delay = 2;
    var elt_duration = "";
    $( '.nav_creative_container .creative_menu ul.menu > li' ).each( function() {
        start_delay += 1;
        if ( start_delay < 10 ) {
            elt_duration = "0." + start_delay + "s";
        }
        else {
            elt_duration = start_delay / 10 + "s";
        }

        $( this ).css( {
            "-webkit-transition-delay" : elt_duration,
            "-moz-transition-delay"    : elt_duration,
            "transition-delay"         : elt_duration
        } );
    } );
}

var showMobileMenuContainer = function( $ ) {
    $( '.mobile_navigation_container' ).toggle();
    $( '.mobile_navigation_container' ).toggleClass( 'mobile_menu_opened' );
}

function setContentHeight ( $ ) {
    if($('#lc_swp_wrapper').height() > $(window).height()){
        if ( $( '.lc_copy_area' ).length ) {
            $( '.lc_copy_area' ).css( "opacity", "1" );
        }        
        return;
    }
    if ( ! $( '#lc_swp_content' ).length ) {
        return;
    }
    if ($('body').hasClass('page-template-template-visual-composer')) {
        return;
    }
    $( '#lc_swp_content' ).css( "min-height", "" );

    var totalHeight = $( window ).height();
    if ( $( '#heading_area' ).length > 0 ) {
        totalHeight -= $( '#heading_area' ).height();
    }
    if ( $( '#footer_sidebars' ).length ) {
        totalHeight -= $( '#footer_sidebars' ).height();
    }

    if ( $( '.lc_copy_area ' ).length ) {
        totalHeight -= $( '.lc_copy_area' ).height();
    }

    var minContentHeight = $( '#lc_swp_content' ).data( "minheight" );
    if ( $( '#lc_swp_content' ).length ) {
        if ( totalHeight > minContentHeight ) {
            $( '#lc_swp_content' ).css( 'min-height', totalHeight -5 );
        }
    }

    if ( $( '.lc_copy_area' ).length ) {
        $( '.lc_copy_area' ).css( "opacity", "1" );
    }
}

function stickyMenu ( $ ) {
    if ( ! $( 'header' ).hasClass( 'lc_sticky_menu' ) ) {
        return;
    }
    if ( $( '.mobile_navigation_container' ).hasClass( 'mobile_menu_opened' ) ) {
        return;
    }

    var triggerSticky = 100;
    if ( $( window ).scrollTop() > triggerSticky ) {
        enableSticky( $ );
    }
    else {
        disableSticky( $ );
    }
}

function customPageMenuStyle($) {
    /*no custom styling on sticky menu*/
    if ($('header#at_page_header').hasClass('sticky_enabled')) {
        if ($('#logo').find('.cust_page_logo').length) {
            $('#logo').find('.cust_page_logo').hide();
            $('#logo').find('.global_logo').show();
        }

        if ($('header#at_page_header').hasClass('cust_page_menu_style')) {
            $('header#at_page_header').removeAttr("style");
            /*creative*/
            $('header#at_page_header').find(".hmb_line").removeAttr("style");
            $('header#at_page_header').find(".at_login_wish > div > a").removeAttr("style");
            $('header#at_page_header').find(".creative_header_icon > a").removeAttr("style");
            $('header#at_page_header').find(".creative_header_icon > .lnr-magnifier").removeAttr("style");

            /*classic*/
            $('header#at_page_header').find(".classic_header_icon > a").removeAttr("style");
            $('header#at_page_header').find(".classic_header_icon > .lnr-magnifier").removeAttr("style");
            $('header#at_page_header').find(".classic_menu > ul > li:not(.current-menu-parent):not(.current-menu-item) > a").removeAttr("style");

            /*centered*/
            $('header#at_page_header').find(".lc_social_profile > a").removeAttr("style");
        }

        return;
    }

    if ($('#logo').find('.cust_page_logo').length) {
        $('#logo').find('.cust_page_logo').css("display", "block");
        $('#logo').find('.global_logo').hide();
    }

    if ($('header#at_page_header').hasClass('cust_page_menu_style')) {
        var menu_bg = $('header#at_page_header').data("menubg");
        var menu_col = $('header#at_page_header').data("menucol");


        if (menu_bg && (menu_bg != "")) {
            $('header#at_page_header').css("background-color", menu_bg);
        }
        if (menu_col && (menu_col != "")) {
            /*creative*/
            $('header#at_page_header').find(".hmb_line").not('.mobile_menu_hmb_line').css("background-color", menu_col);
            $('header#at_page_header').find(".at_login_wish > div > a").css("color", menu_col);
            $('header#at_page_header').find(".creative_header_icon > a").not('.in_mobile_menu').css("color", menu_col);
            $('header#at_page_header').find(".creative_header_icon > .lnr-magnifier").not('.lnr_mobile').css("color", menu_col);

            /*classic*/
            $('header#at_page_header').find(".classic_header_icon > a").css("color", menu_col);
            $('header#at_page_header').find(".classic_header_icon > .lnr-magnifier").not('.lnr_mobile').css("color", menu_col);
            $('header#at_page_header').find(".classic_menu > ul > li:not(.current-menu-parent):not(.current-menu-item) > a").css("color", menu_col);            

            /*centered*/
            $('header#at_page_header').find(".lc_social_profile > a").css("color", menu_col);
        }
    }

    if ($('.pre_header.cust_pre_header_style').length) {
        /*pre header*/
        var pre_bg = $('.pre_header.cust_pre_header_style').data("prebg");
        var pre_col = $('.pre_header.cust_pre_header_style').data("precol");

        if (pre_bg && (pre_bg != "")) {
            $('.pre_header.cust_pre_header_style').css("background-color", pre_bg);
        }
        if (pre_col && (pre_col != "")) {
            $('.pre_header.cust_pre_header_style').find('.at_menu_message').css("color", pre_col);
            $('.pre_header.cust_pre_header_style').find(".classic_header_icon > a").css("color", pre_col);
            $('.pre_header.cust_pre_header_style').find(".classic_header_icon > .lnr-magnifier").not('.lnr_mobile').css("color", pre_col);            
        }
    }

}

var enableSticky = function( $ ) {
    if ( $( 'header' ).hasClass( 'sticky_enabled' ) ) {
        return;
    }

    $( 'header' ).css( "visibility", "hidden" )
    $( 'header' ).addClass( 'sticky_enabled' );
    $( 'header' ).css( "visibility", "visible" );
}

var disableSticky = function( $ ) {
    var element = $( 'header' );
    if ( $( element ).hasClass( 'sticky_enabled' ) ) {
        $( element ).removeClass( 'sticky_enabled' );

        if ( 0 == $( element ).attr( "class" ).length ) {
            $( element ).removeAttr( "class" );
        }
    }
}

var backToTop = function( $ ) {
    if ( ! $( '.lc_back_to_top_btn' ).length ) {
        return;
    }

    var backToTopEl = $( '.lc_back_to_top_btn' );
    $( backToTopEl ).click( function() {
        $( "html, body" ).animate( {scrollTop : 0}, "slow" );
    } );

    $( window ).scroll( function() {
        if ( $( window ).scrollTop() < 200 ) {
            $( backToTopEl ).hide();
        }
        else {
            $( backToTopEl ).show( 'slow' );
        }
    } );
}

function atSwpSetScrollContainerHeight () {
    var $ = jQuery;
    var bodyHeight = $( 'body' ).height();


    if ( $( '#at_swp_search_results_scroll_container' ).length === 0 ) {
        $( '#search_results' ).wrap( '<div id="at_swp_search_results_scroll_container"></div>' );
    }

    var scrollContainer = $( '#at_swp_search_results_scroll_container' );

    var offsetTop = scrollContainer.offset().top;
    scrollContainer.css( 'max-height', bodyHeight - offsetTop - 30);
    if ( scrollContainer.data( 'mCS' ) ) {
        scrollContainer.mCustomScrollbar( 'update' );
    }
    else {
        scrollContainer.mCustomScrollbar();
    }

}

var clickOnSearchIcon = function( $ ) {
    $( '.trigger_global_search' ).click( function() {
        $('body').css('overflow', 'hidden');
        $( '#lc_global_search' ).show();
        $('#search-word').focus();
    } );


    $( '.close_search_form' ).click( function() {
        var $global_search = $( '#lc_global_search' );
        $( 'body' ).css( 'overflow', '' );
        $global_search.hide();
        $( '.lc_global_search_inner' , $global_search).removeClass('active');
        $( '#search-word' , $global_search).val('');
        $( '#search_results' , $global_search).empty();
    } );

    $( document ).keyup( function( e ) {
        /* escape key maps to keycode `27`*/
        if ( e.keyCode == 27 ) {
            $( '.close_search_form' ).trigger('click');
            $( 'body' ).css( 'overflow', '' );
            // $( '#lc_global_search' ).hide();
        }
    } );
}

var handleMobile = function( $ ) {
    $( 'nav.mobile_navigation' ).find( 'ul li.menu-item-has-children > a' ).click( function( event ) {
        event.preventDefault();
        $( this ).parent().find( '> ul' ).stop().toggle( '300' );
    } );
}

var handleVideoImageContainer = function( $ ) {
    if ( ! $( '.video_image_container' ).length ) {
        return;
    }

    $( '.video_image_container' ).each( function() {
        var no_px_width = parseFloat( $( this ).css( 'width' ) );
        $( this ).css( "height", no_px_width * 9 / 16 );
        $( this ).parent().parent().css( "opacity", 1 );
    } );
}

var handleAlbumImageContainer = function( $ ) {
    if ( ! $( '.album_image_container' ).length ) {
        return;
    }

    $( '.album_image_container' ).each( function() {
        var no_px_width = parseFloat( $( this ).css( 'width' ) );
        $( this ).css( "height", no_px_width );
        $( this ).parent().parent().css( "opacity", 1 );
    } );
}

var justifiedGallery = function( $ ) {
    if ( ! $( '.lc_swp_justified_gallery' ).length ) {
        return;
    }

    $( ".lc_swp_justified_gallery" ).each( function() {
        var rowHeight = $( this ).data( "rheight" );
        if ( ! $.isNumeric( rowHeight ) ) {
            rowHeight = 180;
        }

        $( this ).justifiedGallery( {
            rowHeight               : rowHeight,
            lastRow                 : 'justify',
            margins                 : 0,
            captions                : false,
            imagesAnimationDuration : 400
        } );

        $( this ).find( "img" ).fadeTo( "600", 0.6 );
        $( this ).parent().find( '.view_more_justified_gallery' ).fadeTo( "400", 1 );
    } );

    setTimeout( function() {
        $( '.img_box' ).find( "img" ).addClass( "transition4" );
    }, 600 );

}

var ajaxVcCfResponsive = function( $ ) {
    if ( ! $( ".vc_lc_contactform" ).length ) {
        return;
    }

    var containerWidth = $( ".vc_lc_contactform" ).width();
    if ( containerWidth <= 768 ) {
        $( ".vc_lc_contactform" ).find( ".vc_lc_element" ).removeClass( "three_on_row" );
    }
    else {
        $( ".vc_lc_contactform" ).find( ".three_on_row_layout" ).addClass( "three_on_row" );
    }
}

var runUnslider = function( $ ) {
    $( '.lc_reviews_slider:not(.lc_slider_two_rows)' ).unslider( {
        arrows   : {
            prev : '<a class="unslider-arrow prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>',
            next : '<a class="unslider-arrow next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>',
        },
        autoplay : false,
        delay    : 4000,
        speed    : 400
    } );

    var next_value = "next";
    var prev_value = "prev";
    if ( $( '.at_produts_slider_inner' ).length ) {
        if ( $( '.at_produts_slider_inner' ).data( "nextslide" ) ) {
            next_value = $( '.at_produts_slider_inner' ).data( "nextslide" );
        }
        if ( $( '.at_produts_slider_inner' ).data( "prevslide" ) ) {
            prev_value = $( '.at_produts_slider_inner' ).data( "prevslide" );
        }
    }

    var slider_arrows = {
            prev : '<a class="unslider-arrow prev">' + prev_value + '</a>',
            next : '<a class="unslider-arrow next">' + next_value + '</a>',
        };

    $( '.at_produts_slider_inner' ).unslider( {
        arrows   : slider_arrows,
        autoplay : false,
        delay    : 4000,
        speed    : 400,
        nav      : false
    } );

    var gallery = $( '.woocommerce div.images .image_gallery' );

    gallery.on( 'unslider.change', function( event, index, slide ) {
        $( '.artemis_swp_gallery_thumbnails a.artemis_swp_gallery_thumbnail' ).removeClass( 'active' );
        $( '.artemis_swp_gallery_thumbnails a.artemis_swp_gallery_thumbnail:eq(' + index + ')' ).addClass( 'active' );
        var currentSlide = event.target;
        var video,otherVideos, mediaPlayer;
        var otherSlides = slide.siblings('li');

        if ( (otherVideos = otherSlides.find( 'video.wp-video-shortcode' )).length ) {
            otherVideos.each(function(){
                mediaPlayer = $( this ).data( 'mediaelementplayer' );
                if ( mediaPlayer ) {
                    mediaPlayer.pause();
                }
            })
        }

        if ( (video = $( 'video.wp-video-shortcode', slide )).length ) {
            setTimeout( function() {
                mediaPlayer = $( video ).data( 'mediaelementplayer' );
                if ( mediaPlayer ) {
                    /*var isPlaying = mediaPlayer.getCurrentTime() > 0 && mediaPlayer.total.attr( 'aria-valuenow' ) != mediaPlayer.total.attr( 'aria-valuemax' );
                    if ( isPlaying ) {*/
                    // mediaPlayer.isLoaded = true;
                    mediaPlayer.play();
                    // }
                }
            }, 500 );
        }

    } );

    gallery.unslider( {
        arrows   : {
            prev : '<a class="gallery-unslider-arrow prev"><i class="fa fa-angle-left" aria-hidden="true"></i> <span class="at_swp_slider_prev_next_text">' + artemis_swp.sliderPrevText + '</span> </a>',
            next : '<a class="gallery-unslider-arrow next"><i class="fa fa-angle-right" aria-hidden="true"></i><span class="at_swp_slider_prev_next_text">' + artemis_swp.sliderNextText + '</span> </a>',
        },
        autoplay : false,
        delay    : 10000,
        speed    : 400,
        nav      : false
    } );

    $( '.artemis_swp_gallery_thumbnails a' ).click( function( event ) {
        event.preventDefault();
        var index = $( this ).index();
        $( gallery ).unslider( 'animate:' + index );
        return false;
    });


    $('.lc_lookbook_slider').each(function(){
        var prev_val = "";
        var next_val = "";
        var arrow_class = "text_nav";
        if ("nav_text" == $(this).data("navstyle")) {
            prev_val = $(this).data("prevtxt");
            next_val = $(this).data("nexttxt");
        } else {
            prev_val = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
            next_val = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
            arrow_class = "icon_nav";
        }

        var layout_style = $(this).find('.lookbook_single').first().data("layoutstyle");
        var slider_container = $(this);

        slider_container.on('unslider.ready', function() {
            var RESPONSIVE_VIEW_RES_MAX = 600;

            var placeLookbookSliderArrowsTextOverUnderImage = function(slider_container) {
                slider_container.parent().find('.unslider-look-arrow').addClass("rotate_min_90");

                var left_dist = 10;
                var right_dist = 10;
                if (slider_container.find('.lookbook_single_container').width() <= RESPONSIVE_VIEW_RES_MAX) {
                    left_dist = 0 - slider_container.parent().find('.unslider-look-arrow.prev').outerWidth()/2 +  
                                slider_container.parent().find('.unslider-look-arrow.prev').outerHeight() + 15;
                    right_dist = 0 - slider_container.parent().find('.unslider-look-arrow.next').outerWidth()/2 + 
                                slider_container.parent().find('.unslider-look-arrow.next').outerHeight() + 15;
                }

                slider_container.parent().find('.unslider-look-arrow.prev').css("left", left_dist);
                slider_container.parent().find('.unslider-look-arrow.next').css("right", right_dist);
            }

            if (("text_over_image" == layout_style) || 
                ("text_under_image" == layout_style)) {

                placeLookbookSliderArrowsTextOverUnderImage(slider_container);

                if ("text_under_image" == layout_style) {
                    slider_container.parent().find('.unslider-look-arrow').css("top", slider_container.parent().find(".look_image_over").height() /2);
                }
                if ("text_over_image" == layout_style) {
                    slider_container.parent().find('.unslider-look-arrow').css("top", slider_container.find('.lookbook_single').first().height() /2);
                }

                $(window).on( "debouncedresize", function( event ) {
                    placeLookbookSliderArrowsTextOverUnderImage(slider_container);
                });                 
            }

            var placeLookbookSliderArrowsTextAside = function(slider_container) {
                var hdistance = "50px";
                var top_value = slider_container.parent().find(".look_image_aside").height() /2; 

                if (slider_container.find('.lookbook_single_container').width() <= RESPONSIVE_VIEW_RES_MAX) {
                    hdistance = "25px";
                    /*place the slider buttons just after the content*/
                    top_value = slider_container.find('.look_content_aside').first().height() - 320;
                }

                if (slider_container.parent().find(".look_content_aside").hasClass("show_on_left")) {
                    slider_container.parent().find('.unslider-look-arrow').css("right", hdistance);    
                } else {
                    slider_container.parent().find('.unslider-look-arrow').css("left", hdistance);
                }
                
                slider_container.parent().find('.unslider-look-arrow').css("top", top_value);
                slider_container.parent().find('.unslider-look-arrow.prev').css("margin-top", "50px");
            }

            if ("text_aside" == layout_style) {
                placeLookbookSliderArrowsTextAside(slider_container);

                $(window).on( "debouncedresize", function( event ) {
                    placeLookbookSliderArrowsTextAside(slider_container);
                });                
            }

            setTimeout(function(){
                slider_container.parent().find('.unslider-look-arrow').fadeIn("600");
            }, 1000);            
        });

        var look_slider = slider_container.unslider({
            arrows   : {
                prev : '<a class="unslider-look-arrow ' + arrow_class + ' prev">' + prev_val + '</a>',
                next : '<a class="unslider-look-arrow ' + arrow_class + ' next">' + next_val + '</a>',
            },
            autoplay : true,
            delay    : 10000,
            speed    : 400,
            nav      : false,
            selectors: {
                container: '.unslider_parent',
                slides: '.lookbook_single_container'
            }
        });
    });


    //handle two rows reviews slider
    var trrs = $( '.lc_reviews_slider.lc_slider_two_rows' );

    function setReviewImagesMargin ( imagesContainer ) {
        var reviewImages = $( '.lc_reviewer_image', imagesContainer );
        reviewImages.css( {'margin' : '0','height' : '100%'} );
        var imgWidth = reviewImages.length * reviewImages.width();
        if ( imgWidth >= imagesContainer.width() ) {
            reviewImages.css( {'margin' : '0', 'width' : imagesContainer.width() / reviewImages.length} );
        }
        else {
            var reviewImgMargin = ($( imagesContainer ).width() / reviewImages.length - $( reviewImages ).width()) / 2;
            reviewImages.css( {'margin' : '0 ' + reviewImgMargin + 'px'} );
        }
    }
    if ( trrs.length ) {
        trrs.each( function() {
            var imagesContainer = $( '.lc_reviews_slider_top_row .lc_reviews_slider_inner', this );
            var bg_color = $(imagesContainer).parent().css('background-color');

            var numReviews = $( '.lc_reviewer_image', this ).length;
            $( '.lc_reviewer_image', this ).each( function() {
                var reviewContent = $(this).closest('li');
                $( '.lc_reviews_slider_arrow', this ).css( 'border-top-color', bg_color );
                $(this).click(function(){
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');
                    $(reviewContent).siblings().hide();
                    $(reviewContent).show().css('display', 'table-row');
                });
                $( this ).appendTo( imagesContainer ).css('width', (100/numReviews).toFixed(3) + '%');
            } );
            $('.lc_reviewer_image:first-of-type').click();
        } );
    }

};

function handleLookbookArrowsOnResize($) {
    $('.lc_lookbook_slider').each(function(){
        var layout_style = $(this).find('.lookbook_single').first().data("layoutstyle");
        var slider_container = $(this);
        
        if ("text_under_image" == layout_style) {
            slider_container.parent().find('.unslider-look-arrow').css("top", slider_container.parent().find(".look_image_over").height() /2);
        }
        if ("text_over_image" == layout_style) {
            slider_container.parent().find('.unslider-look-arrow').css("top", slider_container.find('.lookbook_single').first().height() /2);
        }
    });
}

var handleParallax = function( $ ) {
    $( ".lc_swp_parallax" ).each( function() {
        if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent ) ) {
            $( this ).addClass( "ai_swp_no_scroll" );
        }
        else {
            $( this ).css( "background-position", "50% 0" );
            var $parallaxObject = $( this );

            $( window ).scroll( function() {
                var yPos = - ($( window ).scrollTop() / $parallaxObject.data( "pspeed" ));
                var newCoord = '50% ' + yPos + 'px';

                $parallaxObject.css( "background-position", newCoord );
            } );
        }
    } );
}

var handleGoToNextSection = function( $ ) {
    if ( ! $( '.goto_next_section' ).length ) {
        return;
    }

    var animateIcon = function( targetElement, speed ) {
        $( targetElement ).css( {'padding-top' : '0px'} );
        $( targetElement ).css( {'opacity' : '1'} );
        $( targetElement ).animate(
                {
                    'padding-top' : "25px",
                    "opacity"     : "0"
                },
                {
                    duration : speed,
                    complete : function() {
                        animateIcon( $( '.goto_next_section i' ), speed );
                    }
                }
        );
    };
    setTimeout( function() {
        animateIcon( $( '.goto_next_section i' ), 2000 );
    }, 3000 );

    $( '.goto_next_section' ).click( function() {
        var $nextRow = $( this ).parents( '.vc_row' ).next();
        if ( $nextRow.length ) {
            $( 'html, body' ).animate( {
                scrollTop : $nextRow.offset().top
            }, 1200 );
        }
    } );

}

var hanldeJsLinks = function( $ ) {
    if ( ! $( '.lc_js_link' ).length ) {
        return;
    }

    $( '.lc_js_link' ).click( function( event ) {

        var clickOnChild = typeof $( this ).data( 'atcot' ) !== "undefined" ? Boolean( $( this ).data( 'atcot' ) ) : true;
        if ( this != event.target && ! clickOnChild ) {
            return;
        }
        event.preventDefault();
        var newLocation = $( this ).data( "href" );
        var newWin = '_self';
        if ( $( this ).data( "target" ) ) {
            newWin = $( this ).data( "target" );
        }
        window.open( newLocation, newWin );
    } );
}

var logoInTheMiddle = function( $ ) {
    if ( ! $( '.centered_menu' ).length ) {
        return;
    }

    var middleMenuPosition = Math.ceil( $( ".header_inner.centered_menu ul.menu > li" ).length / 2 );
    $( ".header_inner.centered_menu ul.menu > li:nth-child(" + middleMenuPosition + ")" ).after( '<li class="logo_menu_item"></li>' );
    $( '#logo' ).detach().appendTo( 'li.logo_menu_item' );
    /*TODO: add margin left on nav.centered_menu.classic_menu equal with left side  - right side*/

    var leftWidth =0;
    var rightWidth =0;
    var logoMenuItem = $( 'nav.centered_menu.classic_menu .logo_menu_item' );
    logoMenuItem.prevAll( '.menu-item' ).each( function() {
        leftWidth += $( this ).width();
    } );
    logoMenuItem.nextAll('.menu-item').each(function(){
        rightWidth += $(this).width();
    });

    $( 'nav.centered_menu.classic_menu').css('margin-left', rightWidth - leftWidth);

    $( '#logo' ).css( "opacity", "1" );
    $( ".header_inner.centered_menu" ).animate( {opacity : 1}, "slow" );
}

var imageOverText = function( $ ) {
    if ( ! $( '.swp_image_over_text' ).length ) {
        return;
    }

    $( '.swp_image_over_text' ).each( function() {
        var databg = $( this ).data( "bgimage" );
        $( this ).css( "background", "url(" + databg + ") center center no-repeat" );
        $( this ).css( "-webkit-background-clip", "text" );
        $( this ).css( "-webkit-text-fill-color", "transparent" );
    } );
}

var artemisSwpToggleMiniCart = function( $ ) {
    var miniCartIcon = $( '.artemis-swp-minicart-icon' );
    miniCartIcon.find( '.artemis-swp-minicart' ).hide();

    miniCartIcon.hover( function() {
        $( this ).find( '.artemis-swp-minicart' ).stop().fadeIn();
        if ($('.pre_header.classic_double_menu').length) {
            $('.at_wishlist.account_option').css("display", "none");
            $('.at_login.account_option').css("display", "none");
        }
    }, function() {
        setTimeout( (function( parent ) {
            return function() {
                if ( ! $( '.artemis-swp-minicart-icon:hover' ).length ) {
                    $( parent ).find( '.artemis-swp-minicart' ).stop().fadeOut(10);
                    $('.at_wishlist.account_option').css("display", "block");
                    $('.at_login.account_option').css("display", "block");                    
                }
            }
        })( this ), 100 );
    } );
};
var artemisSwpToggleMiniWishlist = function( $ ) {
    var miniCartIcon = $( '.at_wishlist' );
    miniCartIcon.find( '.artemis-swp-miniwishlist' ).hide();

    miniCartIcon.find( 'a' ).mouseenter( function() {
            miniCartIcon.find( '.artemis-swp-miniwishlist' ).stop().fadeIn();
    } );
    miniCartIcon.mouseleave( function() {
        setTimeout( (function( parent ) {
            return function() {
                if ( ! $( '.at_wishlist:hover' ).length ) {
                    $( parent ).find( '.artemis-swp-miniwishlist' ).stop().fadeOut(10);
                }
            }
        })( miniCartIcon ), 100 );
    } );
};

var artemisSwpAddToWishlist = function( $ ) {
    $( 'body' ).on( 'click', '.artemis_swp_add_to_wishlist', function( event ) {
        var productId = $( this ).data( 'wishlist-id' );
        var _self = this;
        $.ajax( {
            type     : 'POST',
            url      : artemis_swp_wishlist.ajax_url,
            data     : {
                action     : 'artemis_swp_add_to_wishlist',
                product_id : productId
            },
            dataType : "json",
            success  : function( response ) {
                if ( typeof response.error !== "undefined" ) {
                    alert( response.message )
                }
                else {
                    var btn = '<span class="artemis_swp_already_on_wishlist" title="' + response.message + '"><i class="fa fa-heart"></i> <span>' + response.message + '</span></span>';

                    if ( typeof response.mini_wishlist_item !== "undefined" ) {
                        var $wishlist = $( '.artemis_swp-mini_wishlist' );
                        $wishlist.find( 'li.empty' ).remove();
                        $wishlist.append( response.mini_wishlist_item );
                        $( '.artemis-swp-miniwishlist p.buttons' ).removeClass( 'at_hidden' );
                    }

                    $( _self ).replaceWith( btn );
                }
            },
            error    : function( MLHttpRequest, textStatus, errorThrown ) {
                alert( response.errorThrown );
            }
        } );
        return false;
    } );
};

var artemisSwpRemoveWishlistItem = function( $ ) {
    $( 'body' ).on( 'click', '.artemis-swp-wishlist-remove-item', function( event ) {
        var productId = $( this ).data( 'wishlist-id' );
        var _self = this;
        $.ajax( {
            type     : 'POST',
            url      : artemis_swp_wishlist.ajax_url,
            data     : {
                action     : 'artemis_swp_remove_from_wishlist',
                product_id : productId
            },
            dataType : "json",
            success  : function( response, textStatus, XMLHttpRequest ) {
                if ( typeof response.success !== "undefined" ) {
                    $( '[data-wishlist-item=' + productId + ']' ).fadeOut( 400, function() {
                        $( this ).remove();

                        if ( response.products_in_wishlist == 0 ) {
                            $( '#artemis-swp-empty-wishlist' ).show();
                            $( 'ul.artemis_swp-mini_wishlist' ).append( '<li class="empty">' + artemis_swp_wishlist.emptyText + '</li>' );
                            $( '.artemis-swp-miniwishlist p.buttons' ).addClass( 'at_hidden' );
                        }
                    } );
                }
                else {
                    alert( response.message );
                }
            },
            error    : function( MLHttpRequest, textStatus, errorThrown ) {
                alert( response.errorThrown )
            }
        } );

        return false;
    } );
};

var artemisSwpQuantityChanger = function( $ ) {
    $( document ).on( 'click', '.increment_qty', function() {
        var input = jQuery( this ).parent().parent().find( "input.qty" );
        var oldVal = input.val();
        if ( parseFloat( oldVal ) >= 0 ) {
            var step = parseInt( $( input ).attr( 'step' ) );
            step = step > 0 ? step : 1;
            var newVal = parseFloat( oldVal ) + step;
            input.val( newVal ).trigger( 'change' );
        }
    } );

    $( document ).on( 'click', '.decrement_qty', function() {
        var input = jQuery( this ).parent().parent().find( "input.qty" );
        var oldVal = input.val();
        var step = parseInt( $( input ).attr( 'step' ) );
        step = step > 0 ? step : 1;
        if ( parseFloat( oldVal ) > step ) {
            var newVal = parseFloat( oldVal ) - step;
            input.val( newVal ).trigger( 'change' );
        }
    } );
};

var artemisSwpGridListSelector = function( $ ) {
    $( '.at_product_list_mode' ).on( 'click', function( event ) {
        event.preventDefault();
        $( '#at_product_view_mode' ).val( $( this ).data( 'mode' ) ).closest( 'form' ).submit();
    } );
};

var artemisSwpItemsPerRowSelector = function( $ ) {
    $( '.at_products_per_row_item' ).on( 'click', function( event ) {
        event.preventDefault();
        $( '#at_products_per_row' ).val( $( this ).data( 'per_page' ) ).closest( 'form' ).submit();
    } );
};

var artemisSwpSelect2 = function( $ ) {
    $( 'select' ).filter( function() {
        return ( $( this ).hasClass( 'country_to_state' ) || $( this ).is( ':visible' )) && $( this ).closest( '.variations' ).length < 1;
    } ).select2( {
        'minimumResultsForSearch' : 20
    } );
};

var artemisSwpAddedToCartHandler = function( $ ) {

    function updateCartGeneral(fragments) {
        if ( fragments['div.widget_shopping_cart_content'] ) {
            var $cart_contents = $( fragments['div.widget_shopping_cart_content'] );
            $( '.artemis-swp-minicart' ).html( $cart_contents.html() );
        }
        if ( fragments['at_cart_contents_count'] ) {
            $( '.cart-contents-count' ).html( fragments['at_cart_contents_count'] );
        }
        if ( fragments['at_cart_totals'] ) {
            $('.woocommerce-mini-cart__total', '.artemis-swp-minicart' ).html( fragments['at_cart_totals'] );
        }
        if ( fragments['at_cart_buttons'] ) {
            $('.woocommerce-mini-cart__buttons', '.artemis-swp-minicart' ).html( fragments['at_cart_buttons'] );
        }
    }
    $( document.body ).on( "added_to_cart", function( event, fragments, cart_hash ) {
        updateCartGeneral(fragments);
    } ).on('removed_from_cart', function( event, cartFragments, cart_hash ) {
        var fragments = $.extend({}, cartFragments);
        if ( typeof fragments['at_cart_item_keys'] !== 'undefined' && fragments['at_cart_item_keys'].length !== 0 ) {
            //do not update whole minicart
            if ( fragments['div.widget_shopping_cart_content'] ) {
                var cartBottom = $( fragments['div.widget_shopping_cart_content']);
                var totals = cartBottom.find('.woocommerce-mini-cart__total');
                var buttons = cartBottom.find('.woocommerce-mini-cart__buttons');
                fragments['at_cart_totals'] = totals.html();
                fragments['at_cart_buttons'] = buttons.html();
                delete fragments['div.widget_shopping_cart_content'];
            }

            var cartItemsKeys = fragments['at_cart_item_keys'];
            var $itemsToRemove = $( '.artemis-swp-minicart li[data-cart-item-key]' ).filter( function( index, element ) {
                var currentItemKey = $( element ).data( 'cart-item-key' );
                if ( cartItemsKeys.indexOf( currentItemKey ) === -1 ) {
                    return true;
                }
                return false;
            } );
            $itemsToRemove.remove();
        }

        updateCartGeneral( fragments );
    });
};

var artemisSwpHandleLoginPopup = function( $ ) {
    $( '.at_to_login_popup' ).click( function( event ) {
        event.preventDefault();
        $( '#at_login_popup' ).addClass( 'visible_container' );
        $('body').css('overflow','hidden');
    } );
    $( '.at_login_popup_close' ).click( function( event ) {
        event.preventDefault();
        $( '#at_login_popup' ).removeClass( 'visible_container' );
        $( 'body' ).css('overflow', 'visible');
        $( 'body' ).css('overflow-x', 'hidden');
    } );

    $( '#at_login_form_container' ).on( 'click', '#at_to_register', function( event ) {
        event.preventDefault();
        $( '#at_login_popup_messages' ).removeClass( 'active' ).html( '' );
        $( '#at_login_form_container' ).removeClass( 'active' );
        $( '#at_register_form_container' ).addClass( 'active' );
        $( '#at_login_title' ).removeClass( 'active' );
        $( '#at_register_title' ).addClass( 'active' );
    } );
    $( '#at_register_form_container' ).on( 'click', '#at_to_login', function( event ) {
        event.preventDefault();
        $( '#at_login_popup_messages' ).removeClass( 'active' ).html( '' );
        $( '#at_login_form_container' ).addClass( 'active' );
        $( '#at_register_form_container' ).removeClass( 'active' );
        $( '#at_login_title' ).addClass( 'active' );
        $( '#at_register_title' ).removeClass( 'active' );
    } );

    $( '#at_login_btn' ).on( 'click', function( event ) {
        event.preventDefault();
        var formData = $( '#at_loginform' ).serializeArray();

        formData.push( {name : 'action', value : 'artemis_swp_ajax_login'} );
        formData.push( {name : this.name, value : this.value} );

        $.ajax( {
            url        : artemis_swp_login_popup.ajax_url,
            method     : 'POST',
            data       : formData,
            beforeSend : function() {
                $( '#at_login_popup_messages' ).removeClass( 'active' ).html( '' );
                $( '#at_loading_overlay' ).addClass( 'active' );
            },
            success    : function( response ) {
                try {
                    response = JSON.parse( response );
                }
                catch ( e ) {
                    response = {};
                }
                if ( typeof response.success !== "undefined" && response.success ) {
                    window.location.reload();
                }
                else {
                    var msg = artemis_swp_login_popup.general_error_text;
                    if ( typeof response.message !== "undefined" ) {
                        msg = response.message;
                    }
                    $( '#at_login_popup_messages' ).html( msg ).addClass( 'active' );
                }
            },
            error      : function( a, b, c ) {
                $( '#at_login_popup_messages' ).html( artemis_swp_login_popup.general_error_text ).addClass( 'active' );
            },
            complete   : function() {
                $( '#at_login_popup_messages' ).removeClass( 'active' );
                $( '#at_loading_overlay' ).removeClass( 'active' );
            }
        } )
    } );


    var b = {
        init                  : function() {
            $( document.body ).on( "keyup change", "form.at_register #reg_password", this.strengthMeter ),
                    $( "form.at_register" ).change()
        },
        strengthMeter         : function() {
            var c = $( "form.at_register" )
                    , d = $( 'input[type="submit"]', c )
                    , e = $( "#reg_password, #account_password, #password_1", c )
                    , f = 1;
            b.includeMeter( c, e ),
                    f = b.checkPasswordStrength( c, e ),
                    f < artemis_swp_password_string_meter.min_password_strength && ! c.is( "form.checkout" ) ? d.attr( "disabled", "disabled" ).addClass( "disabled" ) : d.removeAttr( "disabled", "disabled" ).removeClass( "disabled" )
        },
        includeMeter          : function( b, c ) {
            var d = b.find( ".woocommerce-password-strength" );
            "" === c.val() ? (d.remove(),
                    $( document.body ).trigger( "wc-password-strength-removed" )) : 0 === d.length && (c.after( '<div class="woocommerce-password-strength" aria-live="polite"></div>' ),
                                   $( document.body ).trigger( "wc-password-strength-added" ))
        },
        checkPasswordStrength : function( a, b ) {
            var c = a.find( ".woocommerce-password-strength" )
                    , d = a.find( ".woocommerce-password-hint" )
                    ,
                    e = '<small class="woocommerce-password-hint">' + artemis_swp_password_string_meter.i18n_password_hint + "</small>"
                    , f = wp.passwordStrength.meter( b.val(), wp.passwordStrength.userInputBlacklist() )
                    , g = "";
            switch ( c.removeClass( "short bad good strong" ),
                    d.remove(),
            f < artemis_swp_password_string_meter.min_password_strength && (g = " - " + artemis_swp_password_string_meter.i18n_password_error),
                    f ) {
                case 0:
                    c.addClass( "short" ).html( pwsL10n.short + g ),
                            c.after( e );
                    break;
                case 1:
                    c.addClass( "bad" ).html( pwsL10n.bad + g ),
                            c.after( e );
                    break;
                case 2:
                    c.addClass( "bad" ).html( pwsL10n.bad + g ),
                            c.after( e );
                    break;
                case 3:
                    c.addClass( "good" ).html( pwsL10n.good + g );
                    break;
                case 4:
                    c.addClass( "strong" ).html( pwsL10n.strong + g );
                    break;
                case 5:
                    c.addClass( "short" ).html( pwsL10n.mismatch )
            }
            return f
        }
    };
    b.init();
};

var handleProductAttrShowcase = function( $ ) {
    $( '.lc_prod_attr_showcase' ).each( function() {
        var $tabs = $( '<div class="tab_attr"></div>' );
        $( this ).find( ".lc_prod_attr_showcase_inner" ).prepend( $tabs );

        $( this ).find( '.prod_show_attr' ).each( function() {
            $tabs.append( $( this ).detach() );
        } )

        var $active_attr = $( this ).find( '.prod_show_attr' ).first().addClass( "active_attr" );
        var rightId = $active_attr.data( "prodimg" );
        $( this ).find( '#' + rightId ).addClass( "active_prodimg" );

        $( '.prod_show_attr' ).click( function() {
            $( this ).parent().find( '.active_attr' ).removeClass( "active_attr" );
            $( this ).addClass( "active_attr" );

            rightId = $( this ).data( "prodimg" );
            $( this ).parent().parent().find( '.active_prodimg' ).removeClass( "active_prodimg" );
            $( this ).parent().parent().find( '#' + rightId ).addClass( "active_prodimg" );
        } );
    } );
}

var handleVideoSection = function( $ ) {
    $( '.at_video_section_play' ).click( function() {
        var video_source = $( this ).parent().data( "vsource" );
        var video_id = $( this ).parent().data( "vid" );

        var video_frame = '';
        if ( "youtube" == video_source ) {
            video_frame = '<iframe class="at_video_frame" src="' + location.protocol + '//www.youtube.com/embed/' + video_id + '?autoplay=1&amp;showinfo=0&amp;rel=0&amp;byline=0&amp;title=0&amp;portrait=0"></iframe>';
        }
        else if ( "vimeo" == video_source ) {
            video_frame = '<iframe class="at_video_frame" src="' + location.protocol + '//player.vimeo.com/video/' + video_id + '?autoplay=1&amp;byline=0&amp;title=0&amp;portrait=0"></iframe>';
        }

        $( this ).fadeOut();
        $( this ).parent().find( '.at_video_title' ).fadeOut();
        $( this ).parent().find( 'iframe' ).show();

        $( this ).parent().append( video_frame );
    } );
}

var artemisSwpHandleQuickView = function( $ ) {

    $( '.artemis_swp_quickview_button a' ).fancybox( {
        baseClass         : 'at_fancybox woocommerce',
        type              : 'ajax',
        closeClickOutside : true,
        infobar           : true,
        buttons           : true,
        slideShow         : true,
        fullScreen        : true,
        closeBtn          : true,
        thumbs            : {
            showOnStart   : true, // Display thumbnails on opening
            hideOnClosing : true   // Hide thumbnail grid when closing animation starts
        }
    } );
};

var artemisSwpConfirmBox = function( opts ) {

    var defaults = {
        title            : '',
        message          : '',
        cancelButtonText : artemis_swp.confirmCancel,
        okButtonText     : artemis_swp.confirmOk,
        callback         : null
    };

    var options = jQuery.extend( {}, defaults, opts );

    jQuery.fancybox.open(
            '<div class="at_swp_popup_dialog at_confirm">' +
            '<h3 class="at_popup_dialog_title">' + options.title + '</h3>' +
            '<p class="at_popup_dialog_text">' + options.message + '</p>' +
            '<p class="at_popup_dialog_buttons">' +
            '<a data-value="0" data-fancybox-close class="button alt alignright">' + options.cancelButtonText + '</a>' +
            '<a data-value="1" data-fancybox-close class="button alignright">' + options.okButtonText + '</a>' +
            '</p>' +
            '</div>', {
                smallBtn          : false,
                buttons           : false,
                keyboard          : false,
                closeClickOutside : false,
                baseClass         : 'at_swp_popup',
                slideClass        : 'atSlideFromTop',
                afterClose        : function( instance, e ) {
                    var button = e ? e.target || e.currentTarget : null;
                    var value = button ? jQuery( button ).data( 'value' ) : 0;
                    if ( options.callback && jQuery.isFunction( options.callback ) ) {
                        options.callback( value );
                    }
                }
            }
    );
};

var artemisSwpAlertBox = function( opts ) {

    var defaults = {
        title        : '',
        message      : '',
        okButtonText : artemis_swp.alertOk,
        callback     : null
    };

    var options = jQuery.extend( {}, defaults, opts );

    jQuery.fancybox.open(
            '<div class="at_swp_popup_dialog at_alert">' +
            '<h3 class="at_popup_dialog_title">' + options.title + '</h3>' +
            '<p class="at_popup_dialog_text">' + options.message + '</p>' +
            '<p class="at_popup_dialog_buttons">' +
            '<a data-fancybox-close class="button alignright">' + options.okButtonText + '</a>' +
            '</p>' +
            '</div>', {
                smallBtn          : false,
                buttons           : false,
                closeClickOutside : false,
                baseClass         : 'at_swp_popup',
                slideClass        : 'atSlideFromTop',
                keyboard          : false,
                afterClose        : function() {
                    if ( options.callback && jQuery.isFunction( options.callback ) ) {
                        options.callback();
                    }
                }
            }
    );
};

(function( proxied ) {
    window.alert = function( message ) {
        // do something here
        return artemisSwpAlertBox( {'message' : message} );
    };
})( window.alert );

var customAspectRatio = function( $ ) {
    $( '.at_swp_custom_ar' ).each( function() {
        if ( $( this ).hasClass( "ar_square" ) ) {
            $( this ).css( "height", $( this ).width() );
        }
        if ( $( this ).hasClass( "ar_43" ) ) {
            $( this ).css( "height", $( this ).width() / 4 * 3 );
        }
        if ( $( this ).hasClass( "ar_169" ) ) {
            $( this ).css( "height", $( this ).width() / 16 * 9 );
        }
    } );
}

var makeProdImgCover = function( $ ) {
    if ( ! $( '.at_sp_cover_img_slider' ).length ) {
        return;
    }

    var PORTRAIT_AR = 0.7;

    $( '.at_sp_cover_img_slider' ).each( function() {
        $( this ).find( 'li a > img' ).each( function() {
            var imageObj = new Image();
            var _self = this;

            imageObj.onload = function(){

                if ( imageObj.naturalHeight / imageObj.naturalWidth >= PORTRAIT_AR ) {
                    /*portrait image*/
                    $( _self ).parent().parent().addClass( "portrait_prod_img" );
                }
                else {
                    $( _self ).parent().parent().addClass( "make_it_cover" );
                    $( _self ).parent().parent().css( "background-image", "url(" + $( this ).attr( "src" ) + ")" );
                }
            };
            imageObj.src = $( this ).attr( "src" );

        } );
    });
};

var handleType2ProductSliderImgHeight = function( $ ) {
    var container = $( '.artemis_swp_template-type_2.woocommerce div.images' );
    if ( container.length ) {
        var topOffset = container.offset().top;
        $( '.unslider img', container ).css( 'max-height', $( window ).height() - topOffset );
    }
};

var handlePostRating = function($) {
    $('#comments .comment-form-rating #rating').each( function() {
        $( this ).hide().before( '<p class="stars"><span><a class="star-1" href="#">1</a><a class="star-2" href="#">2</a><a class="star-3" href="#">3</a><a class="star-4" href="#">4</a><a class="star-5" href="#">5</a></span></p>' );
    } );
    $('body').on( 'click', '#comments .comment-form-rating p.stars a', function() {
        var $star = $( this ),
                $rating = $( this ).closest( '#respond' ).find( '#rating' ),
                $container = $( this ).closest( '.stars' );

        $rating.val( $star.text() );
        $star.siblings( 'a' ).removeClass( 'active' );
        $star.addClass( 'active' );
        $container.addClass( 'selected' );

        return false;
    } )
};

function handleFooterSidebarsHeight($) {
    var container = $('#footer_sidebars_inner');
    var firstSidebar = container.find('.lc_footer_sidebar:first-of-type');

    var sidebarWidthPercentage = parseInt(100 * firstSidebar.outerWidth(true) / container.width());

    var minHeight12 = 0;
    var minHeight34 = 0;
    var sidebars = container.find( '.lc_footer_sidebar' );
    switch(  sidebarWidthPercentage ) {
        case 25:
            sidebars.each(function(){
                var sHeight = $( this ).outerHeight(true);
               if(  sHeight> minHeight12 ){
                   minHeight12 = sHeight;
                   minHeight34 = sHeight;
               }
            });
            break;
        case 50:
            sidebars.each(function(index, element) {
                var sHeight = $( element ).outerHeight( true );
                if( index < 2 ) {
                    if( sHeight > minHeight12  ){
                        minHeight12 = sHeight;
                    }
                }
                else {
                    if ( sHeight > minHeight34 ) {
                        minHeight34 = sHeight;
                    }
                }
            });
            break;
    }

    $('#footer_sidebar1,#footer_sidebar2').css('min-height', minHeight12);
    $('#footer_sidebar3,#footer_sidebar4').css('min-height', minHeight34);
}

function lookTextOverImage($) {
    if (!$('.lookbook_single.text_aside').length) {
        return;
    }

    $('.lookbook_single.text_aside').each(function(){
        var containerRes = $(this).width();
        var RESPONSIVE_VIEW_RES_MAX = 600;
        if (containerRes < RESPONSIVE_VIEW_RES_MAX) {
            $(this).addClass("responsive_view");
            $(this).find('.look_content_aside').addClass('lc_swp_full');
        } else {
            $(this).removeClass("responsive_view");
            $(this).find('.look_content_aside').removeClass('lc_swp_full');
        }
    })
}

function handleLookBooks($) {
    if (!$('.lc_lookbook_slider_container').length) {
        return;
    }

    /*only for mobile*/
    if($('.lc_mobile_menu').css('display') == 'none') {
        if ($('.lc_lookbook_slider_container').hasClass("margin_top_mobile")) {
            $('.lc_lookbook_slider_container').css("margin-top", "0");    
        }
        return;
    }

    if ($('.lc_lookbook_slider_container').find('.lookbook_single').first().hasClass('lookbook_single')) {
        var menu_size = $('.lc_mobile_menu').height();
        if($('.lc_lookbook_slider_container').offset().top < menu_size) {
            $('.lc_lookbook_slider_container').css("margin-top", menu_size);
            $('.lc_lookbook_slider_container').addClass("margin_top_mobile");
        }
    }

}

function artemisSwpHandleType2TemplateVariationChangeImage($) {
    $('.artemis_swp_template-type_2 .variations_form').on('wc_variation_form', function(event){
        $(this).bind('found_variation reset_image', function(event, variation){

            var $form = $(this),
                    $product = $form.closest( '.product' ),
                    $product_gallery = $( '.artemis_swp_template-type_2' ).find( '.woocommerce-product-gallery' ),
                    $gallery_img = $product.find( '.flex-control-nav li:eq(0) img' ),
                    $product_img_wrap = $product_gallery.find( '.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder' ).eq( 0 ),
                    $product_img = $product_img_wrap.find( '.wp-post-image' ),
                    $product_thumb_img = $( '.artemis_swp_template-type_2' ).find('.artemis_swp_gallery_thumbnails').find( '.wp-post-thumb-image' ),
                    $product_link = $product_img_wrap.find( 'a' ).eq( 0 );

            if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
                $product_img.wc_set_variation_attr( 'src', variation.image.src );
                $product_img.wc_set_variation_attr( 'height', variation.image.src_h );
                $product_img.wc_set_variation_attr( 'width', variation.image.src_w );
                $product_img.wc_set_variation_attr( 'srcset', variation.image.srcset );
                $product_img.wc_set_variation_attr( 'sizes', variation.image.sizes );
                $product_img.wc_set_variation_attr( 'title', variation.image.title );
                $product_img.wc_set_variation_attr( 'alt', variation.image.alt );
                $product_img.wc_set_variation_attr( 'data-src', variation.image.full_src );
                $product_img.wc_set_variation_attr( 'data-large_image', variation.image.full_src );
                $product_img.wc_set_variation_attr( 'data-large_image_width', variation.image.full_src_w );
                $product_img.wc_set_variation_attr( 'data-large_image_height', variation.image.full_src_h );

                $product_thumb_img.wc_set_variation_attr( 'src', variation.image.src );
                $product_thumb_img.wc_set_variation_attr( 'height', variation.image.src_h );
                $product_thumb_img.wc_set_variation_attr( 'width', variation.image.src_w );
                $product_thumb_img.wc_set_variation_attr( 'srcset', variation.image.srcset );
                $product_thumb_img.wc_set_variation_attr( 'sizes', variation.image.sizes );
                $product_thumb_img.wc_set_variation_attr( 'title', variation.image.title );
                $product_thumb_img.wc_set_variation_attr( 'alt', variation.image.alt );
                $product_thumb_img.wc_set_variation_attr( 'data-src', variation.image.full_src );
                $product_thumb_img.wc_set_variation_attr( 'data-large_image', variation.image.full_src );
                $product_thumb_img.wc_set_variation_attr( 'data-large_image_width', variation.image.full_src_w );
                $product_thumb_img.wc_set_variation_attr( 'data-large_image_height', variation.image.full_src_h );
                $product_thumb_img.wc_set_variation_attr( 'src', variation.image.src );

                $product_img_wrap.wc_set_variation_attr( 'data-thumb', variation.image.src );
                $product_link.wc_set_variation_attr( 'href', variation.image.full_src );
            }
            else {
                $product_img.wc_reset_variation_attr( 'src' );
                $product_img.wc_reset_variation_attr( 'width' );
                $product_img.wc_reset_variation_attr( 'height' );
                $product_img.wc_reset_variation_attr( 'srcset' );
                $product_img.wc_reset_variation_attr( 'sizes' );
                $product_img.wc_reset_variation_attr( 'title' );
                $product_img.wc_reset_variation_attr( 'alt' );
                $product_img.wc_reset_variation_attr( 'data-src' );
                $product_img.wc_reset_variation_attr( 'data-large_image' );
                $product_img.wc_reset_variation_attr( 'data-large_image_width' );
                $product_img.wc_reset_variation_attr( 'data-large_image_height' );

                $product_thumb_img.wc_reset_variation_attr( 'src' );
                $product_thumb_img.wc_reset_variation_attr( 'width' );
                $product_thumb_img.wc_reset_variation_attr( 'height' );
                $product_thumb_img.wc_reset_variation_attr( 'srcset' );
                $product_thumb_img.wc_reset_variation_attr( 'sizes' );
                $product_thumb_img.wc_reset_variation_attr( 'title' );
                $product_thumb_img.wc_reset_variation_attr( 'alt' );
                $product_thumb_img.wc_reset_variation_attr( 'data-src' );
                $product_thumb_img.wc_reset_variation_attr( 'data-large_image' );
                $product_thumb_img.wc_reset_variation_attr( 'data-large_image_width' );
                $product_thumb_img.wc_reset_variation_attr( 'data-large_image_height' );

                $product_img_wrap.wc_reset_variation_attr( 'data-thumb' );
                $gallery_img.wc_reset_variation_attr( 'src' );
                $product_link.wc_reset_variation_attr( 'href' );
            }

            window.setTimeout( function() {
                $product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
                $form.wc_maybe_trigger_slide_position_reset( variation );
                $( window ).trigger( 'resize' );
            }, 10 );
        })
    })
}

function artemisSwpHandleProductsMasonry($) {

    var grids = $( '.lc_swp_prods_grid_container' );
    if ( !grids.length ) {
        return;
    }

    var  RATIO = 0.8;
    var  RATIO_1X = 2;
    grids.imagesLoaded(function() {
        $.each(grids, function(){
            var $grid = $( this );
            $grid.css("width", "100%");

            var gap_width = $grid.data( "gapwidth" );
            var container_width = $grid.width();
            var bricks_on_row = $grid.data( "bricksonrow" );

            var container_outer_width = $grid.outerWidth();
            var bricks_on_row_responsive = 1;
            if (4 == bricks_on_row) {
                bricks_on_row_responsive = getMasonryBricksOnRow( $, bricks_on_row, container_outer_width, {1 : 480, 2 : 979} ); 
            } else {
                bricks_on_row_responsive = getMasonryBricksOnRow( $, bricks_on_row, container_outer_width, {1 : 480, 2 : 768, 3 : 979} ); 
            }
            var brick_width;
            var brick_2x_width;
            var brick_2x_height;

            var user_ratio = $grid.data("ar");
            if ("ar16_9" == user_ratio) {
                RATIO = 0.5625;
            }
            if ("ar_custom" == user_ratio) {
                if ($grid.data("userar")) {
                    RATIO = parseFloat($grid.data("userar"));
                    if (0 != RATIO) {
                        RATIO = parseFloat(1/RATIO);
                    }
                }
            }

            if( bricks_on_row_responsive === 1 ){
                RATIO = 1;
                brick_width = container_width;
                brick_2x_width = brick_width;
                brick_3x_width = brick_width;
            }
            else {
                brick_width = Math.round((container_width - ((bricks_on_row_responsive - 1) * gap_width)) / bricks_on_row_responsive);
                brick_2x_width = Math.round(2 * brick_width + gap_width);
                brick_3x_width = Math.round(3 * brick_width + 2 * gap_width);
            }

            if (bricks_on_row_responsive * brick_width > container_width) {
                $grid.css("width", bricks_on_row_responsive * brick_width);
            }

            var brick_height = Math.round(brick_width * RATIO); 
            brick_2x_height = Math.round(brick_2x_width * RATIO);
            brick_3x_height = Math.round(brick_3x_width * RATIO);

            $( '.at_swp_single_grid_prod', $grid ).each( function() {
                if (bricks_on_row_responsive === 1) {
                    $(this).addClass("bricks_responsive1");
                } else {
                    $(this).removeClass("bricks_responsive1");
                }

                if ( ((bricks_on_row_responsive === 2) || (bricks_on_row_responsive === 3)) 
                    && container_outer_width < 1200)  {
                    $(this).addClass("bricks_responsive2_3");
                } else {
                    $(this).removeClass("bricks_responsive2_3");
                }

                if ($(this).hasClass('width_brick_3x')) {
                    $(this).css('width', brick_3x_width);
                } else {
                    if ($(this).hasClass('width_brick_2x')) {
                        $(this).css('width', brick_2x_width);
                    } else {
                        $(this).css('width', brick_width);
                    }
                }

                if ($(this).hasClass('height_brick_3x')) {
                    $(this).css('height', brick_3x_height);
                } else {
                    if ($(this).hasClass('height_brick_2x')) {
                        $(this).css('height', brick_2x_height);
                    }
                    else {
                        $(this).css('height', brick_height);
                    }
                }

                $(this).css('margin-bottom', gap_width);
            });

            $grid.masonry( {
                columnWidth  : brick_width,
                itemSelector : '.at_swp_single_grid_prod',
                gutter       : gap_width
            } );
            $grid.fadeTo( "400", 1 );
        });
    });
}

function handleFullScreenSearch () {
    var $ = jQuery;
    var searching = false;
    var $container = $( '#lc_global_search' );
    var $triggerSearch = $( '#search-submit', $container );
    $( '#search-word', $container ).on('focus click', function(){
        $('.lc_global_search_inner', $container).addClass('active');
    });

    function doSearch ( searchTerm ) {
        var ajax_url = $( '#search-form', $container ).data( 'ajaxAction' );
        if ( !ajax_url ) {
            return true;
        }
        $.ajax( {
            'url'        : ajax_url,
            'type'       : 'POST',
            'data'       : {
                'action'      : 'artemis_swp_ajax_search',
                'search_term' : searchTerm
            },
            'beforeSend' : function() {
                searching = true;
                $container.addClass('loading');
                $( '.search_results', $container ).empty();
            },
            'success'    : function( response ) {
                //make sure display right results
                if ( searchTerm == $( '#search-word', $container ).val().trim() ) {
                    searching = false;
                    response = JSON.parse( response );
                    if ( typeof response.posts !== "undefined" ) {
                        $( '.search_results', $container ).html( response.posts );
                        $( '#at_swp_search_results_scroll_container' ).mCustomScrollbar('update');
                    }
                }
            },
            'complete'   : function() {
                if ( searchTerm == $( '#search-word', $container ).val().trim() ) {
                    $container.find( '.search_dropdown' ).removeClass( 'loading' );
                    searching = false;
                    $container.removeClass( 'loading' );
                    atSwpSetScrollContainerHeight();
                }
            },
            'error'      : function( jqXHR, textStatus, errorThrown ) {
                $( '.search_results', $container ).html( errorThrown );
                if ( searchTerm == $( '#search-word', $container ).val().trim() ) {
                    $container.find( '.search_dropdown' ).removeClass( 'loading' );
                    searching = false;
                }
            }
        } );
    }

    $( '#search-form', $container ).on( 'submit', function( event ) {
        var ajax_url = $( this ).data( 'ajaxAction' );
        if ( !ajax_url ) {
            return true;
        }
        event.preventDefault();
        var searchTerm = $( this ).find( '#search-word' ).val().trim();
        if ( !searchTerm ) {
            alert( 'Please enter a search term' );
            return false;
        }
        doSearch( searchTerm );
        return false;
    } );
    $( '#search-word', $container ).on( 'keyup', function( event ) {
        event.preventDefault();
        var searchTerm = $( this ).val().trim();
        if ( searchTerm.length >= 3 ) {
            doSearch( searchTerm.trim() );
        }
        else {
            $( '.search_results', $container ).empty();
        }

    } );
}

function productsCategoryFilter() {
    var $ = jQuery;

    $( '.products_category_filter' ).each( function() {
        var productsGrid = $( this ).next( '.products' );
        productsGrid.append( '<li class="at_swp_grid_gutter"></li>' )
                .append( '<li class="product at_swp_grid_sizer"></li>' );
        $( '.product', productsGrid ).css('clear', 'none');
        var filters = $(this).find('.at_swp_category_filter');
        filters.on('click', function(event) {
            event.preventDefault();
            var filter = $(this).data('filter');

            filters.removeClass('at_swp_cat_filter_active');
            $(this).addClass('at_swp_cat_filter_active');
            if( '*' == filter ) {
                $('.product',productsGrid).show();
            }
            else {
                $( '.product', productsGrid).not('.product_cat-' + filter).not('.at_swp_grid_sizer').hide();
                $( '.product_cat-' + filter, productsGrid).show();
            }
            productsGrid.masonry( 'layout' );
        });

        productsGrid.imagesLoaded( function() {
            productsGrid.masonry( {
                'itemSelector'    : '.product:not(.at_swp_grid_sizer)',
                'percentPosition' : true,
                'gutter'          : '.at_swp_grid_gutter',
                'columnWidth'     : '.at_swp_grid_sizer',
                'horizontalOrder' : true,
            } );
        } )
    } );
}


function verticalPromoHeight($) {
    $('.swp_vertical_shop_promo').each(function(){
        if ($(this).attr('data-ar')) {
            var ar = parseFloat($(this).data('ar'));
            var calc_height = $(this).width() / ar;

            if ($(this).attr('data-maxheight')) {
                if (calc_height > $(this).data('maxheight')) {
                    calc_height = $(this).data('maxheight');
                }
            }
            $(this).height(calc_height);
        }
    });
}
