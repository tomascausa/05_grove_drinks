<?php
	
	$links = array();
	/*alignment can be overwritten by individual templates*/
	$alignment = "text_center" == ARTEMIS_SWP_get_titles_alignment_class() ? "text_center"	: "text_right";
	$self_url = $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	$single_link['URL'] = esc_url(home_url('/'));
	$single_link['name'] = esc_html__('Home', 'artemis-swp');
	$links[] = $single_link;

	/*single post*/
	if (is_singular('post')) {
		$alignment = " text_right";

		/*get URL for Blog page*/
		$blog_url = "";
		if ('page' == get_option('show_on_front')) {
	        if (get_option('page_for_posts')) {
	            $blog_url = esc_url(get_permalink(get_option('page_for_posts')));
	        } else {
	            $blog_url = esc_url(home_url('/?post_type=post'));
	        }
	    } else {
	        $blog_url = esc_url(home_url('/'));
	    }

	    $single_link['URL'] = esc_url($blog_url);
		$single_link['name'] = esc_html__("Blog", "artemis-swp");
		$links[] = $single_link;

		/*now show the category for the post*/
		$post_id = get_the_ID();
		$cats = get_the_category($post_id); 
		foreach($cats as $single_cat) {
			$single_link['URL'] = esc_url(get_category_link($single_cat->term_id));
			$single_link['name'] = $single_cat->name;
			$links[] = $single_link;
			/*show only the 1st category as breadcrumb*/
			break;
		}
	} elseif (is_page()) {
		if (is_page_template("page.php")) {
			$alignment = " text_right";	
		}

		$single_link['URL'] = $self_url;
		$single_link['name'] = get_the_title();
		$links[] = $single_link;
	} if (is_author()) {
		/*posts by author*/
		$single_link['URL'] = $self_url;
		$single_link['name'] = get_the_author();
		$links[] = $single_link;
		
	} elseif (is_category()) {
        /*
            posts by category -
        */
        $ancestors = get_ancestors( $cat, 'category' );
        $ancestors = array_reverse($ancestors);
        foreach ( $ancestors as $ancestor ) {
            $cat = get_the_category_by_ID( $ancestor );
            if ( ! is_wp_error( $cat ) ) {
                $links[] = array(
                    'name' => $cat,
                    'URL'  => get_category_link( $ancestor )
                );
            }
        }
		$single_link['URL'] = $self_url;
		$single_link['name'] = single_cat_title("", FALSE);
		$links[] = $single_link;

	} elseif (is_archive()) {
		if (is_tax()) {
			/*
				custom taxonomy - category for custom post types
				catch product category here
				
			*/
			if (function_exists('is_product_category')) {
				if (is_product_category()) {
					/*
					TODO: get parent taxonomy here
					example: HOME > SHOP > MEN > WATCHES
					MEN is the missing category
					*/
					$shop_url = $shop_page_url = get_permalink(wc_get_page_id('shop'));
					$single_link['URL'] = $shop_url;
					$single_link['name'] = esc_html__("Shop", "artemis-swp");
					$links[] = $single_link;
					$ancestors = get_ancestors( $wp_query->get_queried_object_id(), 'product_cat' );
					$ancestors = array_reverse( $ancestors );
					foreach ( $ancestors as $ancestor ) {
						$cat  = get_term( $ancestor, 'product_cat', ARRAY_A );
						$link = get_term_link( $ancestor, 'product_cat' );
						if ( ! is_wp_error( $cat ) || ! is_wp_error( $link ) ) {
							$links[] = array(
								'name' => $cat['name'],
								'URL'  => $link
							);
						}
					}
				}
			}
			$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			$single_link['URL'] = $self_url;
			$single_link['name'] = $term->name;
			$links[] = $single_link;
		}
		elseif(ARTEMIS_SWP_is_woocommerce_active() && is_shop()){
            $shop_url            = $shop_page_url = get_permalink(wc_get_page_id('shop'));
            $single_link['URL']  = $shop_url;
            $single_link['name'] = esc_html__("Shop", "artemis-swp");
            $links[]             = $single_link;
        }else {
			/*posts by time-date*/
			$single_link['URL'] = $self_url;
			$single_link['name'] = get_the_time(get_option('date_format'));
			$links[] = $single_link;
			
		}
	} elseif (is_home()) {
		/*home page based on index.php showing latest posts*/
		$single_link['URL'] = $self_url;
		$single_link['name'] = esc_html__("Blog", "artemis-swp");
		$links[] = $single_link;
	} elseif (is_search()) {
		/*page showing search results*/
		$single_link['URL'] = $self_url;
		$single_link['name'] = get_search_query();
		$links[] = $single_link;
	} elseif ( ARTEMIS_SWP_is_woocommerce_active() && is_product()) {
		/*single product here*/
		/*TODO- add cateogry for product here
		example: HOME - SHOP - MEN
		*/
		$shop_url = $shop_page_url = get_permalink(wc_get_page_id('shop'));
		$single_link['URL'] = $shop_url;
		$single_link['name'] = esc_html__("Shop", "artemis-swp");
		$links[] = $single_link;

	    $categories = wp_get_post_terms( get_the_ID(), 'product_cat' );
	    if( !is_wp_error($categories) && count($categories) ){
	        $category = $categories[0];
		    $ancestors = get_ancestors( $category->term_id, 'product_cat' );
            if (count($ancestors)) {
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $ancestor) {
                    $cat  = get_term($ancestor, 'product_cat', ARRAY_A);
                    $link = get_term_link($ancestor, 'product_cat');
                    if (!is_wp_error($cat) || !is_wp_error($link)) {
                        $links[] = array(
                            'name' => $cat['name'],
                            'URL'  => $link
                        );
                    }
                }
            }
            else {
                $links[] = array(
                    'name' => $category->name,
                    'URL'  => get_term_link($category->term_id, 'product_cat')
                );
            }
        }
	}

	/*decide to show breadcrumbs*/
	$show_them = true;
	if (is_singular('post') || is_page_template("default")) {
		$show_them = false;
	}
	/*for some reason, is_singlar('post') returns true for single product page*/
	if (is_singular('product')) {
		$show_them = true;
	}
?>


<?php if ($show_them) { ?>
<div class="breadcrumbs_nav <?php echo esc_attr($alignment); ?>">
	<?php
	$first = true;
	$link_separator = "&#62;";

	foreach ($links as $single_link) {
		$additional_class = "";
		if ($first) {
			$first = false;
		} else {
			echo esc_html($link_separator);
		}

		if ($single_link == end($links)) {
			$additional_class = " last_elt";
		}
		?>

		<a href="<?php echo esc_attr($single_link['URL']); ?>" class="breadcrumbs_nav_link<?php echo esc_attr($additional_class); ?>">
			<?php echo esc_html($single_link['name']); ?>
		</a>

		<?php
		}
	?>
</div>
<?php } ?>

