<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
	<?php get_template_part('views/favicon'); ?>

	<?php wp_head(); ?>
</head>

<body  <?php body_class(); ?>>
	<div id="lc_swp_wrapper">
		<?php 
            get_template_part( 'views/login-popup' );
			/*main menu*/
			if (!is_page_template("template-visual-composer-no-menu.php")) {
				$menu_style = ARTEMIS_SWP_get_menu_style();
				get_template_part('views/menu/'.$menu_style);
			}

			/*heading area*/
			if (!is_page_template("template-visual-composer.php") &&
			!is_page_template("template-visual-composer-no-menu.php")) {
				get_template_part('views/heading_area');	
			}
            /**
             * @hooked woocommerce_show_product_images 20
             */
			do_action('artemis_swp_before_content');

            $color_scheme = ARTEMIS_SWP_get_specific_color_scheme();
		?>
		<div id="lc_swp_content" data-minheight="200" class="<?php echo esc_attr($color_scheme); ?>">
			<?php if (ARTEMIS_SWP_need_sidebar_on_woo()) { ?>
				<?php
					$boxed_class = "lc_swp_boxed";
					if (is_shop() || is_product_category()) {
						$boxed_class = ARTEMIS_SWP_get_shop_width_class() . " sidebar_for_full_width";
					}
				?>
				<div class="lc_content_full <?php echo esc_attr($boxed_class); ?> lc_big_content_padding">
			<?php } ?>
		
