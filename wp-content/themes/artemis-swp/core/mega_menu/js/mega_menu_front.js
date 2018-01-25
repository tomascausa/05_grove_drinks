jQuery(document).ready(function($) {
	artemisMegaMenu($);
	$(window).on("debouncedresize", function(event) {
		artemisMegaMenu($);
	});
});

function artemisMegaMenu($) {

    var images = {};
    $('ul.menu > li.menu-item-swp-megamenu-parent').each(function() {

        var first_padding = parseInt($(this).parent().find('a').first().css("padding-left")); 
        var mega_offset = $(this).parent().find('a').first().offset().left + first_padding;
        var left_pos = first_padding;
        var $mega_ul = $(this).find('> ul');


        $mega_ul.css("left", left_pos);
        $mega_ul.css("padding-left", 50 - first_padding);
        $mega_ul.addClass("mega_menu_ul");


        if ($(this).hasClass('swp-megamenu-parent-has-img')) {
            $mega_ul.addClass('has-bg-img');
            $mega_ul.css("background-image", "url("+$(this).data("menuitemimg")+")");
        }

        var liElems = $mega_ul.find( 'li.swp-menu-item-with-image' );
        $.each(liElems, function(){
            var img_src = $(this).data( 'menuitemimg' );
            if ( img_src ) {
                var cachedImage = new Image();
                cachedImage.src = img_src;
                cachedImage.alt = $( this ).find( 'a' ).text();
                images[$( this ).attr( 'id' )] = cachedImage;
            }
        });

        var max_height = $mega_ul.height();
        $mega_ul.find(" > li").each(function() {
            var local_height = 0;
            local_height = $(this).height() + $(this).find(" > ul").height();
            if (local_height > max_height) {
                max_height = local_height;
            }

        });

        $mega_ul.css("height", max_height);
        $mega_ul.css("padding-bottom", "0px");

        $header_tag = $(this).closest('header');
        if ($header_tag.hasClass("classic_double_menu_logo_center") ||
            $header_tag.hasClass("header_centered_menu")) {
            var menu_w = $(this).parent().width();
            var mega_w = $mega_ul.outerWidth();

            var left_mega_offset = (menu_w - mega_w)/2;
            $mega_ul.css("left", left_mega_offset);
        }        

        var $preview_li_elt = $mega_ul.find(".swp_preview_item_img");
        if (!$preview_li_elt) {
            $mega_ul.append('<li class="swp_preview_item_img"></li>');
        }

        var $preview_li_img = $mega_ul.find(".swp_preview_item_img img");
        if (!$preview_li_img) {
            return;
        }
        
        /*check if it gets our of the screen*/
        var mega_width = parseInt($mega_ul.outerWidth());
        if ((mega_width + mega_offset) > $(window).width()) {
            var mega_off_diff = mega_width + mega_offset - $(window).width();
            $mega_ul.css("left", 0 - mega_off_diff + left_pos);
        }

        $mega_ul.find('li.swp-menu-item-with-image').each(function(){
            $(this).append('<span class="swp-menu-img-tooltip"><img src="'+ $(this).data("menuitemimg") + '" ></span>');

            var $tooltip = $(this).find('>.swp-menu-img-tooltip');
            
            $(this).find("> a").mouseover(function() {
                $tooltip.show().fadeTo("slow", 1);
            })
            .mouseout(function() {
                $tooltip.css("opacity", 0);
                $tooltip.hide();
            });
            
            $(this).mousemove(function(e) {
                var x = e.clientX ; 
                var y = e.clientY;

                $tooltip.css("top", parseInt(y + 10));
                $tooltip.css("left", parseInt(x + 25));
            });
        });
    });


}
