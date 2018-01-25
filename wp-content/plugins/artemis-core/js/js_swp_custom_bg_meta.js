jQuery(document).ready(function($){
	"use strict";
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
 
    // Runs when the image button is clicked.
    $('#js_swp_meta_bg_image-button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, meta_image_frame, '#js_swp_meta_bg_image', '#custom_bg_meta_preview img');
    });
	
	$('#js_swp_meta_bg_image-buttondelete').click(function(){
		$('#custom_bg_meta_preview img').attr('src', '');
		$('#js_swp_meta_bg_image').val('');
	});
	
	$('#lc_swp_meta_head_bg_image-button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, meta_image_frame, '#lc_swp_meta_heading_bg_image', '#custom_head_bg_meta_preview img');
    });

	$('#lc_swp_meta_head_bg_image-buttondelete').click(function(){
		$('#custom_head_bg_meta_preview img').attr('src', '');
		$('#lc_swp_meta_heading_bg_image').val('');
	});

	$('#lc_swp_meta_page_logo_image-button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, meta_image_frame, '#lc_swp_meta_page_logo', '#custom_head_page_logo_meta_preview img');
    });

	$('#lc_swp_meta_page_logo-buttondelete').click(function(){
		$('#custom_head_page_logo_meta_preview img').attr('src', '');
		$('#lc_swp_meta_page_logo').val('');
	});

    var video_frame;
    $( '#lc_swp_meta_custom_video-button' ).click( function(event) {
    	event.preventDefault();
        if ( video_frame ) {
            video_frame.open();
            return;
        }

        video_frame = wp.media( {
            'title'    : 'Choose product video',
            'button'   : {
                'text' : 'Use this video'
            },
            'library'  : {
                'type' : 'video'
            },
            'multiple' : false,
        } );

        video_frame.on( 'select', function() {
            var video = video_frame.state().get( 'selection' ).first().toJSON();
			$('#lc_swp_meta_custom_video').val(video.id);
			$('#at_swp_video_details_container').removeClass('no_video');
			$('#at_swp_video_details_container').addClass('has_video');

            var img = $( '<img/>', {'src' : video.thumb.src, 'alt' : video.title} );

            $('#at_swp_video_poster_container').html(img);
            $('#at_swp_video_title').html(video.title);
        } );

        video_frame.open();
    } );

    $('#lc_swp_meta_custom_video-buttondelete').click(function( event ) {
        event.preventDefault();
        $( '#lc_swp_meta_custom_video' ).val('');

        $( '#at_swp_video_poster_container' ).html( '' );
        $( '#at_swp_video_title' ).html('' );

		$('#at_swp_video_details_container').removeClass('has_video');
		$('#at_swp_video_details_container').addClass('no_video');       
	});
	
	/*alpha color picker*/
	$('input.alpha-color-picker').alphaColorPicker();
});

function openAndHandleMedia($, meta_image_frame, inputId, pathToImgId) {
	// If the frame already exists, re-open it.
	if ( meta_image_frame ) {
		meta_image_frame.open();
		//return;
	}

	// Sets up the media library frame
	meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
		title: "Choose Custom Background Image",
		button: { text:  "Use this image as background" },
		library: { type: 'image' }
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