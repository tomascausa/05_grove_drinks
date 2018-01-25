	<?php if (ARTEMIS_SWP_need_sidebar_on_woo()) { ?>
		</div> <!--.lc_content_full lc_swp_boxed lc_basic_content_padding-->
	<?php } ?>

	</div> <!--#lc_swp_content-->
	<?php get_sidebar('footer'); ?>
	<?php get_template_part('views/canvas_image'); ?>
	<?php get_template_part('views/utils/back_to_top'); ?>
	<?php get_template_part('views/utils/search_form_global'); ?>
	</div> <!--#lc_swp_wrapper-->
	<?php wp_footer(); ?>
</body>
</html> 