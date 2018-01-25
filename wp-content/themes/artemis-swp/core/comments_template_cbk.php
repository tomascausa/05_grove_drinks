<?php

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own ARTEMIS_SWP_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if (!function_exists('ARTEMIS_SWP_comment')) {
	function ARTEMIS_SWP_comment($comment, $args, $depth)
	{
	    $GLOBALS['comment'] = $comment;

	    switch ($comment->comment_type) :
	        case '' :
	    ?>
	    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	        <div id="comment-<?php comment_ID(); ?>">
	            <div class="comment-author vcard">
	                <?php echo get_avatar($comment, 70); ?>
	                <span class="comment_author_details text_uppercase">
	                	<?php
		                	$allowed_tags = array(
								'span' => array(
									'class'	=> array()
								)
							);
	                		printf(
	                			wp_kses(__('%s <span class="says">&#32;</span>', 'artemis-swp'), $allowed_tags),
	                			sprintf('<cite class="fn">%s</cite>', get_comment_author_link())
	                		); 
	                	?>
						<span class="comment-meta commentmetadata">
							<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
		                		<?php
		                    	/* translators: 1: date, 2: time */
		                    	printf(esc_html__('%1$s at %2$s', 'artemis-swp'), get_comment_date(),  get_comment_time()); 
		                    	?>
	                    	</a>
	                    	<?php edit_comment_link(esc_html__('(Edit)', 'artemis-swp'), ' ');
	                		?>
	            		</span><!-- .comment-meta .commentmetadata -->
	                </span>
	            </div><!-- .comment-author .vcard -->
	            <?php if ($comment->comment_approved == '0') : ?>
	                <em class="comment-awaiting-moderation"><?php echo esc_html__('Your comment is awaiting moderation.', 'artemis-swp'); ?></em>
	                <br />
	            <?php endif; ?>

	            <div class="comment-body"><?php comment_text(); ?></div>

	            <div class="reply">
	                <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
	            </div><!-- .reply -->
	        </div><!-- #comment-##  -->

	    <?php
	            break;
	        case 'pingback'  :
	        case 'trackback' :
	    ?>
	    <li class="post pingback">
	        <p><?php esc_html__('Pingback:', 'artemis-swp'); ?> <?php comment_author_link(); ?><?php edit_comment_link(esc_html__('(Edit)', 'artemis-swp'), ' '); ?></p>
	    <?php
	            break;
	    endswitch;
	}
}

function ARTEMIS_SWP_comment_fields($arg)
{
	$arg['comment_notes_before'] = "";
	$arg['comment_notes_after'] = "";
	
	
	return $arg;
}
add_filter('comment_form_defaults', 'ARTEMIS_SWP_comment_fields');


/*
	Customize comment form fields and textarea
*/
function ARTEMIS_SWP_change_comment_form_default_fields($fields) 
{
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$aria_req = ($req ? " aria-required='true'" : '');

	$fields['author'] = '<p class="comment-form-author"><label for="author"></label>
    <input id="author" name="author" placeholder="'.esc_html__('Your name', 'artemis-swp').($req ? ' *' : '').'" type="text" value="' . esc_attr($commenter['comment_author']) .
    '" size="30"' . $aria_req . ' /></p>';

    $fields['email'] = '<p class="comment-form-email"><label for="email"></label> 
    <input id="email" name="email" placeholder="'.esc_html__('E-mail address', 'artemis-swp').($req ? ' *' : '').'" type="text" value="' . esc_attr($commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' /></p>';

    $fields['url'] = '<p class="comment-form-url"><label for="url"></label>' .
    '<input id="url" name="url" placeholder="'.esc_html__('Website', 'artemis-swp').'" type="text" value="' . esc_attr($commenter['comment_author_url'] ) .
    '" size="30" /></p>';

    return $fields;
}
add_filter('comment_form_default_fields', 'ARTEMIS_SWP_change_comment_form_default_fields');

function ARTEMIS_SWP_change_comment_field_textarea( $comment_field ) {
    $comment_field = '';
    if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
        $comment_field .= '<p class="comment-form-rating">
                    <label for="rating">' . esc_html__( 'Your Rating', 'artemis-swp' ) . '</label>
                    <select name="rating" id="rating" aria-required="true" required>
                        <option value="">' . esc_html__( 'Rate&hellip;', 'artemis-swp' ) . '</option>
                        <option value="5">' . esc_html__( 'Perfect', 'artemis-swp' ) . '</option>
                        <option value="4">' . esc_html__( 'Good', 'artemis-swp' ) . '</option>
                        <option value="3">' . esc_html__( 'Average', 'artemis-swp' ) . '</option>
                        <option value="2">' . esc_html__( 'Not that bad', 'artemis-swp' ) . '</option>
                        <option value="1">' . esc_html__( 'Very Poor', 'artemis-swp' ) . '</option>
                    </select></p>';
    }
    $comment_field .=
        '<p class="comment-form-comment">
        <label for="comment"></label>
        <textarea placeholder="' . esc_html__( 'Message', 'artemis-swp' ) . '" id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea>
    </p>';

    return $comment_field;
}
add_filter('comment_form_field_comment', 'ARTEMIS_SWP_change_comment_field_textarea');

/*
	Move textarea to bottom
*/
function ARTEMIS_SWP_move_textarea_bottom($fields) {
	$comment_field = $fields['comment'];
	unset($fields['comment']);
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter('comment_form_fields', 'ARTEMIS_SWP_move_textarea_bottom');

/*
	Add a wrapper to keep the input fields (name, email and website)
*/
function ARTEMIS_SWP_before_comment_fields() 
{
	echo '<div class="before_comment_input clearfix">';
}

function ARTEMIS_SWP_after_comment_fields()
{
	echo '</div>';
}
add_action('comment_form_before_fields', 'ARTEMIS_SWP_before_comment_fields');
add_action('comment_form_after_fields', 'ARTEMIS_SWP_after_comment_fields');

?>
