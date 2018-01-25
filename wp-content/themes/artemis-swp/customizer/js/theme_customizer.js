/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
(function($) {
	'use strict';

    //region Button Colors
    var useCustomButtonColors = "use_defaults" !== window.artemisSwpCustomizerConfig.lc_use_custom_btn_color;
    var styleEl = document.createElement( 'style' ),
            stylesheet;

    // Append style element to head
    document.head.appendChild( styleEl );
    // Grab style sheet
    stylesheet = styleEl.sheet;

    var rulesIndexes = [];
    var rulesIdIndexes = [];

    function disableContext(context) {
    	var indexesClone = rulesIndexes.slice(0);

        rulesIndexes.forEach(function(value, index) {
			if(value.context === context) {
				var foundIndex = rulesIdIndexes.indexOf( value.ruleId );
				if( foundIndex > -1 ) {
                    stylesheet.deleteRule( foundIndex );
                    rulesIdIndexes.splice( foundIndex, 1 );
                    indexesClone.splice( foundIndex, 1 );
				}
			}
		});
        rulesIndexes = indexesClone;
	}

    function addStylesheet(id, cssText, context) {
        var foundIndex;
        if ( (foundIndex = rulesIdIndexes.indexOf( id )) > -1 ) {
            stylesheet.deleteRule( foundIndex );
            rulesIndexes.splice( foundIndex, 1 );
            rulesIdIndexes.splice( foundIndex, 1 );
        }
        stylesheet.insertRule( cssText, stylesheet.cssRules.length );
        rulesIndexes.push( {
            'context' : context,
            'ruleId'  : id
        } );
        rulesIdIndexes.push( id );
	}

	wp.customize('lc_customize[lc_use_custom_btn_color]', function(value) {
		value.bind(function(newval) {
			if( 'use_defaults' === newval){
            	disableContext('button_colors');
			}
            useCustomButtonColors = "use_defaults" !== newval;
		});
	});
    var buttonSelectors = '.lc_button, input[type="submit"],' +
                          '.woocommerce a.button,' +
                          '.lc_blog_masonry_brick > .post_item_details .lc_button,' +
                          '.woocommerce ul.products li.product > a.button,' +
                          '.woocommerce button.button.alt,' +
                          '.woocommerce a.button.alt,' +
                          '.woocommerce #respond input#submit, input.button, .woocommerce input.button,' +
                          '.white_on_black .woocommerce a.button.alt,' +
                          '.unslider-nav ol li.unslider-active,' +
                          '.woocommerce .widget_price_filter .price_slider_amount .button,' +
                          '.artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button,' +
                          '.button, .wc-forward';

    var buttonHoverSelectors = '.lc_button:hover, input[type="submit"]:hover,' +
                               '.woocommerce a.button:hover,' +
                               '.lc_blog_masonry_brick > .post_item_details .lc_button:hover,' +
                               '.woocommerce ul.products li.product > a.button:hover,' +
                               '.woocommerce button.button.alt:hover,' +
                               '.woocommerce a.button.alt:hover,' +
                               '.woocommerce #respond input#submit:hover, input.button:hover,' +
                               '.woocommerce input.button:hover,' +
                               '.white_on_black .woocommerce a.button.alt:hover,' +
                               '.unslider-nav ol li.unslider-active:hover,' +
                               '.woocommerce .widget_price_filter .price_slider_amount .button:hover,' +
                               '.artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button:hover,' +
                               '.artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button.checkout:hover,' +
                               '.button:hover, .wc-forward:hover ';
	wp.customize('lc_customize[lc_btn_bg_color]', function(value) {
		value.bind(function(newval) {
            if( useCustomButtonColors ) {
                var cssText = buttonSelectors +'{ ' +
                              'background-color: ' + newval +
                              '}';
                var id = 'button_colors-' + value.id;
                addStylesheet.apply( value, [id, cssText, 'button_colors'] );
			}

		});
	});

	wp.customize('lc_customize[lc_btn_bg_color_hover]', function(value) {
		value.bind(function(newval) {
            if( useCustomButtonColors ) {
				var cssText = buttonHoverSelectors +'{ ' +
							  'background-color: ' + newval +
							  '}';
				var id = 'button_colors-' + value.id + '-hover';
                addStylesheet.apply(value, [id,cssText, 'button_colors'] );
			}
		});
	});

	wp.customize('lc_customize[lc_btn_txt_color]', function(value) {
		value.bind(function(newval) {
            if( useCustomButtonColors ) {
                var cssText = buttonSelectors + '{ ' +
                              'color: ' + newval +
                              '}';
                var id = 'button_colors-' + value.id;
                addStylesheet.apply( value, [id, cssText, 'button_colors'] );
			}
		});
	});

	wp.customize('lc_customize[lc_btn_txt_color_hover]', function(value) {
		value.bind(function(newval) {
            if( useCustomButtonColors ) {
                var id = 'button_colors-' + value.id + '-hover';
                var cssText = buttonHoverSelectors + '{ ' +
                              'color: ' + newval +
                              '}';
                addStylesheet.apply( value, [id, cssText, 'button_colors'] );
			}
		});
	});

	wp.customize('lc_customize[lc_btn_border_color]', function(value) {
		value.bind(function(newval) {
            if( useCustomButtonColors ) {
                var cssText = buttonSelectors + '{ ' +
                              'border-color: ' + newval +
                              '}';
                var id = 'button_colors-' + value.id;
                addStylesheet.apply( value, [id, cssText, 'button_colors'] );
			}
		});
	});

    wp.customize( 'lc_customize[lc_btn_border_color_hover]', function( value ) {
        value.bind( function( newval ) {
            if ( useCustomButtonColors ) {
                var cssText = buttonHoverSelectors + '{ ' +
                              'border-color: ' + newval +
                              '}';
                var id = 'button_colors-' + value.id + '-hover';
                addStylesheet.apply( value, [id, cssText, 'button_colors'] );
            }
        } );
    } );
    //endregion

    wp.customize('lc_customize[second_color]', function(value) {
		value.bind(function(newval) {
			/*text color*/
			$('a:hover, .vibrant_hover:hover, .vibrant_hover a:hover, .lc_vibrant_color, #recentcomments a:hover').css('color', newval);
			$('.widget_meta a:hover, .widget_pages a:hover, .widget_categories a:hover, .widget_recent_entries a:hover').css('color', newval);
			$('.widget_archive a:hover, .lc_copy_area a:hover, .lc_swp_content a:hover, .lc_sharing_icons a:hover').css('color', newval);
			$('.lc_post_meta a:hover, .post_item.no_thumbnail .lc_post_meta a:hover, .post_item:hover > .post_item_details a h2, .lc_blog_masonry_brick.has_thumbnail .lc_post_meta a:hover ').css('color', newval);
			$('.artemis_cf_error, .woocommerce ul.products li.product .price').css('color', newval);
			$('.woocommerce div.product p.price, .woocommerce div.product span.price, .single_video_item:hover h3, .goto_next_section').css('color', newval);

			/*background*/
			$('.lc_swp_vibrant_bgc, .cart-contents-count, #recentcomments li:before, .lc_button:hover').css('background-color', newval);
			$('.lc_blog_masonry_brick:hover > .post_item_details .lc_button, .woocommerce span.onsale, .woocommerce button.button.alt:hover ').css('background-color', newval);
			$('.woocommerce #respond input#submit ').css('background-color', newval);

			/*border-color*/
			$('.lc_button:hover, .lc_blog_masonry_brick:hover > .post_item_details .lc_button, .woocommerce button.button.alt:hover').css("border-color", newval);
			$('.artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button.checkout:hover').css("border-color", newval);
		});
	});

	wp.customize('lc_customize[menu_bar_bg_color]', function(value) {
		value.bind(function(newval) {
			$('.header_inner').css('background-color', newval);
		});
	});

	wp.customize('lc_customize[above_the_menu_bar]', function(value) {
		value.bind(function(newval) {
			$('.pre_header').css('background-color', newval);
		});
	});
	
	wp.customize('lc_customize[above_the_menu_msg_color]', function(value) {
		value.bind(function(newval) {
			$('.at_menu_message, nav.at_secondary_menu li a').css('color', newval);
		});
	});	
	//

	wp.customize('lc_customize[menu_sticky_bar_bg_color]', function(value) {
		value.bind(function(newval) {
			$('header.sticky_enabled .header_inner').css('background-color', newval);
		});
	});	

	wp.customize('lc_customize[menu_mobile_bg_color]', function(value) {
		value.bind(function(newval) {
			$('.header_inner.lc_mobile_menu, .mobile_navigation_container').css('background-color', newval);
		});
	});

	wp.customize('lc_customize[menu_mobile_hmb_color]', function(value) {
		value.bind(function(newval) {
			$('.hmb_line.mobile_menu_hmb_line').css('background-color', newval);
			$('.lc_mobile_menu .mobile_menu_icon, .lc_mobile_menu .mobile_menu_icon a').css('color', newval);
		});
	});	

	wp.customize('lc_customize[mobile_border_bottom_color]', function(value) {
		value.bind(function(newval) {
			$('.mobile_navigation ul li').css('border-bottom-color', newval);
		});
	});	

	wp.customize('lc_customize[menu_text_color]', function(value) {
		value.bind(function(newval) {
			$('ul.menu').children().children('a').css('color', newval);
			$('.menu > li.menu-item-swp-megamenu-parent > ul > li > a').css('color', newval);
			$('#logo a, .classic_header_icon, .classic_header_icon a').css('color', newval);
		});
	});

	wp.customize('lc_customize[menu_text_hover_color]', function(value) {
		var oldVal = $('ul.menu').children().children('a').css('color');
		value.bind(function(newval) {
			$('ul.menu').children().children('a').hover(function(){
			    $(this).css("color", newval);
			    }, function(){
			    $(this).css("color", oldVal);
			});
		});
	});

	wp.customize('lc_customize[submenu_text_color]', function(value) {
		value.bind(function(newval) {
			$('ul.sub-menu li.menu-item a').css('color', newval);
			$('.creative_menu ul.sub-menu li.menu-item-has-children::before').css('border-left-color', newval);
		});
	});

	wp.customize('lc_customize[submenu_text_hover_color]', function(value) {
		var oldVal = $("ul.sub-menu li.menu-item a").css('color');
		var oldBeforeEltVal = $('.creative_menu ul.sub-menu li.menu-item-has-children::before').css('border-left-color');

		value.bind(function(newval) {
			$("ul.sub-menu li.menu-item a").hover(function(){
			    $(this).css("color", newval);
			}, function(){
			    $(this).css("color", oldVal);
			});

			$(".creative_menu ul.sub-menu li.menu-item-has-children").hover(function() {
			    $('.creative_menu ul.sub-menu li.menu-item-has-children::before').css('border-left-color', newval);
			}, function(){
				$('.creative_menu ul.sub-menu li.menu-item-has-children::before').css('border-left-color', oldBeforeEltVal);
			});			
		});
	});

	wp.customize('lc_customize[current_menu_item_text_color]', function(value) {
		value.bind(function(newval) {
			$('li.current-menu-item a, li.current-menu-parent a, li.current-menu-ancestor a').css('color', newval);
		});
	});	

	wp.customize('lc_customize[submenu_bg_color]', function(value) {
		value.bind(function(newval) {
			$('ul.sub-menu li, ul.sub-menu.mega_menu_ul').css('background-color', newval);
		});
	});	
	
	wp.customize('lc_customize[creative_menu_overlay_bg]', function(value) {
		value.bind(function(newval) {
			$('.nav_creative_container').css('background-color', newval);
		});
	});

	wp.customize('lc_customize[creative_icons_color]', function(value) {
		var second_color = wp.customize.instance('lc_customize[lc_second_color]').get();

		value.bind(function(newval) {
			$('.creative_header_icon, .creative_header_icon a').css('color', newval);
			$('.hmb_line').css('background-color', newval);

			$(".creative_header_icon.lc_social_icon").hover(function(){
				$(this).css("color", second_color);
			}, function(){
				$(this).css("color", newval);
			});

			$(".creative_header_icon.lc_social_icon a").hover(function(){
				$(this).css("color", second_color);
			}, function(){
				$(this).css("color", newval);
			});			
		});
	});

	wp.customize('lc_customize[lc_blog_brick_bg_color]', function(value) {
		value.bind(function(newval) {
			$('.post_item.lc_blog_masonry_brick.no_thumbnail, .gallery_brick_overlay, .at_related_posts .one_of_three.no_thumbnail').css('background-color', newval);
			$('.lnwidtget_no_featured_img').css('background-color', newval);
		});
	});

	wp.customize('lc_customize[lc_minicart_wishlist_popup_bg_color]', function(value) {
		value.bind(function(newval) {
			$('.at_wishlist .artemis-swp-miniwishlist, .artemis-swp-minicart-icon .artemis-swp-minicart ').css('background-color', newval);
		});
	});

	wp.customize('lc_customize[lc_order_summary_bg_color]', function(value) {
		value.bind(function(newval) {
			$('.artemis-swp-order-thank-you .artemis-swp-order-summary, .woocommerce-checkout-review-order, .cart_totals table').css('background-color', newval);
			$(' .woocommerce .col2-set#customer_login .col-2, .woocommerce-page .col2-set#customer_login .col-2, .woocommerce-checkout #order_review').css('background-color', newval);
		});
	});

	wp.customize('lc_customize[lc_shop_overlay_bg_color]', function(value) {
		value.bind(function(newval) {
			$('.at_product_actions_mask').css('background-color', newval);
		});
	});	


})(jQuery);
