jQuery(document).ready(function($) {
	'use strict';

	handleMCSubscription($);
});

function handleMCSubscription($) {
	$('.at_mc_subscr_form_container').each(function(){
		var $container = $(this);
		var $button = $(this).find('.at_news_button_entry');

		$(this).find('form.at_mc_subscr_form').submit(function(event) {
			event.preventDefault();
			$button.val($button.data('loadingmsg'));
			$container.find('.at_mc_subscr_form_error').empty();
			$container.find('.at_mc_subscr_form_success').hide();

			var data = {
				action: 'artemisnewsform_action',
				data: $(this).find(":input").serialize()
			};

			$.post(DATAVALUES.ajaxurl, data, function(response) {
				var obj;
				
				try {
					obj = $.parseJSON(response);
				}
				catch(e) {
					$container.find('.at_mc_subscr_form_error').append(DATAVALUES.generalErrorText);
					$button.val($button.data('btnval'));
					return;
				}

				if(obj.success === true) {
					$container.find('.at_mc_subscr_form_success').show('slow');
					$container.find('input').each(function(){
						$(this).val('');
					})
				} else {
					$container.find('.at_mc_subscr_form_error').append(obj.error);
					$container.find('.at_mc_subscr_form_error').show('slow');
					
				}
				$button.val($button.data('btnval'));
			});			

		});
	});
}