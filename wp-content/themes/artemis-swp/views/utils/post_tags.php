<?php
if (has_tag()) {
?>
	<div class="lc_post_tags">
		<span class="lc_share_item_text">
			<?php echo esc_html__("Tags:", "artemis-swp"); 	?>
		</span>

		<?php 
		the_tags('', ' ', '');  
		?>
	</div>
<?php 
}
?>