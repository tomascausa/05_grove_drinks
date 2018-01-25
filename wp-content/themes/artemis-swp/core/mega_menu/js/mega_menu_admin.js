jQuery(document).ready(function($){
	"use strict";
	
    var meta_image_frame;

	$('a[id^="menu-item-image-upload-button-"]').click(function(e){
		e.preventDefault();

		var menuItemId = $(this).data('id');
		if (!menuItemId) {
			return;
		}
		
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }

        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: "Choose Custom Menu Image",
            button: { text:  "Use this image as menu image" },
            library: { type: 'image' }
        });
		
        meta_image_frame.on('select', function(){
 
            /* Grabs the attachment selection and creates a JSON representation of the model. */
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
 
			var inputId = getImageInputId(menuItemId);
			var previewId = getPreviewImageId(menuItemId);
			var removeId = getRemoveImageId(menuItemId);
            /* Sends the attachment URL to our custom image input field. */
            $('#' + inputId).val(media_attachment.url);
			$('#' + previewId).attr('src', media_attachment.url);
			$('#' + removeId).show();
        });		
		
        // Opens the media library frame.
        meta_image_frame.open();
		
	});
	
	$('a[id^="remove-menu-item-image-"]').click(function(e){
		e.preventDefault();
		var menuItemId = $(this).data('id');
		if (!menuItemId) {
			return;
		}
		var inputId = getImageInputId(menuItemId);
		var previewId = getPreviewImageId(menuItemId);
		
		$('#' + inputId).val('');
		$('#' + previewId).attr('src', '');
		$(this).hide();
	});
});

function getImageInputId(menuItemId) {
	return "edit-menu-item-image-" + menuItemId;
}

function getPreviewImageId(menuItemId) {
	return "menu-item-img-preview-" + menuItemId;
}

function getRemoveImageId(menuItemId) {
	return "remove-menu-item-image-" + menuItemId;
}