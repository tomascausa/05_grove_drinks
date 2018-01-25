jQuery(document).ready(function($) {
	'use strict';

	setTimeout(function() {
    	artemis_product_cat_dependency($);
    }, 2000); 
	
});

function artemis_product_cat_dependency($) {
	/*fix dependency not working in vc for cust elements*/
	if (!$('.wpb_at_swp_artemis_grid_product').length) {
		return;
	}

	$('.wpb_at_swp_artemis_grid_product a.vc_control-btn-edit').click(function(){
		setTimeout( function() {
    		if ("product_cat" != $("select[name='brick_shows']").val()) {
    			$('.vc_wrapper-param-type-artemis_product_cat').addClass('vc_dependent-hidden');
    		}

    		$("select[name='brick_shows']").on('change', function() {
  				if ("product_cat" == this.value) {
  					$('.vc_wrapper-param-type-artemis_product_cat').removeClass('vc_dependent-hidden');
  				} else {
  					$('.vc_wrapper-param-type-artemis_product_cat').addClass('vc_dependent-hidden');
  				}
			});
    	}, 1000 ); 
		
	});
}