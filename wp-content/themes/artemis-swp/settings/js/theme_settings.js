jQuery(document).ready(function($) {
	'use strict';
	//this variable has no effect, is always undefined
	var meta_image_frame;
	handleUploadLogo($, meta_image_frame);
	handleUploadFavicon($, meta_image_frame);
	handleUploadInnerBgImage($, meta_image_frame);
	handleUploadFooterBgImage($, meta_image_frame);
	handleUpload404BgImage($, meta_image_frame);
    handleUploadLoginPopupBgImage($);
	initializeAlphaColorPicker($);
	handleFontsOptions($);
});

function initializeAlphaColorPicker($) {
	$('input.alpha-color-picker-settings').alphaColorPicker();
}

function handleUploadInnerBgImage($, meta_image_frame) {
    $('#lc_swp_upload_innner_bg_image_button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia(
 			$, 
 			meta_image_frame, 
 			'#lc_swp_innner_bg_image_upload_value', 
 			'#lc_innner_bg_image_preview img', 
 			"Choose Custom Background Image For Inner Pages", 
 			"Use this image as background"
 		);
    });

	$('#lc_swp_remove_innner_bg_image_button').click(function(){
		$('#lc_innner_bg_image_preview img').attr('src', '');
		$('#lc_swp_innner_bg_image_upload_value').val('');
	})	
}

function handleUploadFavicon($, meta_image_frame) {
    $('#lc_swp_upload_favicon_button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, meta_image_frame, '#lc_swp_favicon_upload_value', '#lc_favicon_image_preview img', "Choose Custom Favicon", "Use this image as favicon");
    });

	$('#lc_swp_remove_favicon_button').click(function(){
		$('#lc_favicon_image_preview img').attr('src', '');
		$('#lc_swp_favicon_upload_value').val('');
	})
}

function handleUploadLogo($, meta_image_frame) {
    $('#lc_swp_upload_logo_button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, meta_image_frame, '#lc_swp_logo_upload_value', '#lc_logo_image_preview img', "Choose Custom Logo Image", "Use this image as logo");
    });

	$('#lc_swp_remove_logo_button').click(function(){
		$('#lc_logo_image_preview img').attr('src', '');
		$('#lc_swp_logo_upload_value').val('');
	})  	
}

function handleUploadFooterBgImage($, meta_image_frame) {
	$('#lc_swp_upload_footer_widgets_bg_image_button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia(
 			$, 
 			meta_image_frame, 
 			'#lc_swp_footer_bg_image_upload_value', 
 			'#lc_footer_widgets_bg_image_preview img', 
 			"Choose Custom Footer Background Image", 
 			"Use this image as background");
    });

	$('#lc_swp_remove_footer_widgets_bg_image_button').click(function(){
		$('#lc_footer_widgets_bg_image_preview img').attr('src', '');
		$('#lc_swp_footer_bg_image_upload_value').val('');
	})
}

function handleUpload404BgImage($, meta_image_frame) {
    $('#lc_swp_upload_404_bg_image_button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, meta_image_frame, '#lc_404_bg_image_value', '#lc_404_image_preview img', "Choose Custom 404 Image", "Use this image as 404 background");
    });

	$('#lc_swp_remove_404_bg_image_button').click(function() {
		$('#lc_404_image_preview img').attr('src', '');
		$('#lc_404_bg_image_value').val('');
	})
}

function handleUploadLoginPopupBgImage($) {
    $('#lc_swp_upload_login_popup_bg_image_button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, null, '#lc_login_popup_bg_image_value', '#lc_login_popup_bg_image_preview img', "Choose Custom Login Popup Background Image", "Use this image as Login Popup background");
    });
	$('#lc_swp_remove_login_popup_bg_image_button').click(function() {
		$('#lc_login_popup_bg_image_preview img').attr('src', '');
		$('#lc_login_popup_bg_image_value').val('');
	})
}
function openAndHandleMedia($, meta_image_frame, inputId, pathToImgId, titleText, buttonText) {
	// If the frame already exists, re-open it.
	//is always undefined
	if ( meta_image_frame ) {
		meta_image_frame.open();
		return;
	}

	// Sets up the media library frame
	meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
		title: titleText,
		button: {text:  buttonText},
		library: {type: 'image'}
	});

	// Runs when an image is selected.
	meta_image_frame.on('select', function(){

		// Grabs the attachment selection and creates a JSON representation of the model.
		var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

		// Sends the attachment URL to our custom image input field.
		$(inputId).val(media_attachment.url);
		$(pathToImgId).attr('src', media_attachment.url);
	});

	// Opens the media library frame.
	meta_image_frame.open();
}

function handleFontsOptions($) {
	if ($('#at_fonts_custom_default').length) {
		if ("use_defaults" == $('#at_fonts_custom_default').val()) {
			$('#at_primary_font').parent().parent().hide();
			$('#at_secondary_font').parent().parent().hide();
		}

		$('#at_fonts_custom_default').change(function(){
			if ("use_defaults" == $('#at_fonts_custom_default').val()) {
				$('#at_primary_font').parent().parent().hide();
				$('#at_secondary_font').parent().parent().hide();
			} else {
				$('#at_primary_font').parent().parent().show();
				$('#at_secondary_font').parent().parent().show();				
			}
		});
	}	
}