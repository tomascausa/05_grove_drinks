<div id="lc_global_search" class="lc_swp_full">
	<div class="lc_global_search_content">
		<div class="lc_global_search_inner transition4">
			<h2 id="search_global_title"> <?php echo esc_html__('Search', 'artemis-swp'); ?> </h2>		
			<?php get_search_form(); ?>
			<div class="top_keywords">
                <?php
                $tags = ARTEMIS_SWP_get_tags();
                if( count($tags) ) { ?>
                    <span class="text_before_keywords">
                        <?php
                        echo esc_html__('Top keywords:', 'artemis-swp');
                        ?>
                    </span>
				    <?php foreach ($tags as $tag) { ?>
                        <a href="<?php echo esc_html(get_term_link($tag->term_id, $tag->taxonomy)) ?>"><?php echo esc_html($tag->name) ?></a>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="artemis_swp_search_loading">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <div class="search_results" id="search_results">

            </div>
        </div>
		<div class="close_search_form">
			<div class="hmb_close c_left"></div>
			<div class="hmb_close c_right"></div>
		</div>
	</div>
</div>
