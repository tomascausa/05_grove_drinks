<?php

function ARTEMIS_SWP_widgets_init() 
{
	if (function_exists('register_sidebar')) {
		register_sidebar(
			array(
				'name' => esc_html__('Main Sidebar', 'artemis-swp'),
				'id' => 'main-sidebar',
				'description' => esc_html__('Right Sidebar', 'artemis-swp'),
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			)
		);

		/*footer sidebars*/
		register_sidebar(
			array(
				'name' => esc_html__('Footer Sidebar 1', 'artemis-swp'),
				'id' => 'footer-sidebar-1',
				'description' => esc_html__('Appears in the footer area', 'artemis-swp'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="footer-widget-title">',
				'after_title' => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name' => esc_html__('Footer Sidebar 2', 'artemis-swp'),
				'id' => 'footer-sidebar-2',
				'description' => esc_html__('Appears in the footer area', 'artemis-swp'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="footer-widget-title">',
				'after_title' => '</h3>',
		));

		register_sidebar(
			array(
				'name' => esc_html__('Footer Sidebar 3', 'artemis-swp'),
				'id' => 'footer-sidebar-3',
				'description' => esc_html__('Appears in the footer area', 'artemis-swp'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="footer-widget-title">',
				'after_title' => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name' => esc_html__('Footer Sidebar 4', 'artemis-swp'),
				'id' => 'footer-sidebar-4',
				'description' => esc_html__('Appears in the footer area', 'artemis-swp'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="footer-widget-title">',
				'after_title' => '</h3>',
			)
		);
	}
}
add_action('widgets_init','ARTEMIS_SWP_widgets_init');



?>