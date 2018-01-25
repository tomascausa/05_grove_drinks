<?php

require_once ABSPATH."/wp-admin/includes/nav-menu.php";	
require_once get_template_directory()."/core/mega_menu/SWPMegaMenuUtils.php";

if (! class_exists('SWPMegaMenu')) {	
	class SWPMegaMenu {
		private $inputNames = array (
				'menu_item_ismegamenu',
				'menu_item_image'
				);
		
		function __construct() {
			/*load needed scripts*/
			add_action('admin_enqueue_scripts', array($this, 'load_admin_scripts'));
			add_action('wp_enqueue_scripts', array($this, 'load_front_scripts'));
			/*register custom fields*/
			add_filter('wp_setup_nav_menu_item', array($this, 'register_custom_menu_fields'));
			/*store custom fields value*/
			add_action('wp_update_nav_menu_item', array($this, 'save_custom_menu_fields'), 10, 3);
			/*Class to extend Walker_Nav_Menu*/
			add_filter('wp_edit_nav_menu_walker', array($this, 'extend_walker_nav_menu'));
		}
		
		function load_admin_scripts() {
			wp_register_script('artemis_swp_mega_menu_admin',  get_template_directory_uri().'/core/mega_menu/js/mega_menu_admin.js', array('jquery'), '', true);
			wp_enqueue_script('artemis_swp_mega_menu_admin');
			
			wp_enqueue_media();
			
			wp_register_style('artemis_swp_mega_menu_admin_style', get_template_directory_uri().'/core/mega_menu/css/mega_menu_admin_style.css');
			wp_enqueue_style('artemis_swp_mega_menu_admin_style');
		}

		function load_front_scripts() {
			wp_register_script(
				'artemis_swp_mega_menu_front',  
				get_template_directory_uri().'/core/mega_menu/js/mega_menu_front.js', 
				array('jquery', 'jquery-ui-tooltip'),
				'', 
				true);
			wp_enqueue_script('artemis_swp_mega_menu_front');

			wp_register_style('artemis_swp_mega_menu_front_style', get_template_directory_uri().'/core/mega_menu/css/mega_menu_front_style.css');
			wp_enqueue_style('artemis_swp_mega_menu_front_style');
		}
		
		function register_custom_menu_fields($menu_item) {
			$menu_item->isAiSwpMegaMenu = get_post_meta($menu_item->ID, '_menu_item_ismegamenu', true);
			$menu_item->customImageUrl = get_post_meta($menu_item->ID, '_menu_item_image', true);

			return $menu_item;
		}
		
		function save_custom_menu_fields($menu_id, $menu_item_db_id, $args) {
			foreach($this->inputNames as $name) {
				if (!isset($_REQUEST[$name][$menu_item_db_id])) {
					$_REQUEST[$name][$menu_item_db_id] = '';
				}
				$value = $_REQUEST[$name][$menu_item_db_id];
				update_post_meta($menu_item_db_id, '_' . $name, $value);
			}
		}
		
		function extend_walker_nav_menu() {
			return 'SWPWalkerNavMenu';
		}
	}
}

add_action('wp_nav_menu_item_custom_fields', 'ai_swp_add_custom_menu_fields', 20, 4);
function ai_swp_add_custom_menu_fields($item_id, $item, $depth, $args) {
	/*Make mega menu available only for top level items*/

	if (0 == $depth) {
		?>
		<p class="ai_swp_is_megamenu description">
			<label for="edit-menu-item-ismegamenu-<?php echo esc_attr($item_id); ?>">
				<input type="checkbox" id="edit-menu-item-ismegamenu-<?php echo esc_attr($item_id); ?>" value="enabled" name="menu_item_ismegamenu[<?php echo esc_attr($item_id); ?>]"<?php checked($item->isAiSwpMegaMenu, 'enabled'); ?>>
				<?php echo esc_html__('Make This Item Mega Menu', 'artemis-swp'); ?>
			</label>
		</p>

		<p>
			<a href="#" id="menu-item-image-upload-button-<?php echo esc_attr($item_id); ?>" data-id="<?php echo esc_attr($item_id); ?>" class="menu-item-upload-image button button-primary">
				<?php echo esc_html__("Use Custom Image", "artemis-swp"); ?>
			</a>
			<p class="ai_swp_menu_item_image description">
				<label for="edit-menu-item-image-<?php echo esc_attr($item_id); ?>">
						<input type="hidden" id="edit-menu-item-image-<?php echo esc_attr($item_id); ?>" name="menu_item_image[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->customImageUrl); ?>" />
						<img src="<?php echo esc_attr($item->customImageUrl); ?>" id="menu-item-img-preview-<?php echo esc_attr($item_id); ?>" class="menu-item-image-preview" />
						<a href="#" id="remove-menu-item-image-<?php echo esc_attr($item_id); ?>" data-id="<?php echo esc_attr($item_id); ?>" class="remove-menu-item-image" style="<?php echo (trim($item->customImageUrl)) ? 'display: inline;' : 'display: none';?>">
							<?php echo esc_html__("Remove Image", "artemis-swp"); ?>
						</a>
				</label>
			</p>			
		</p>

		<?php
	}
	
	/*has parent and is third level*/
	if (($item->menu_item_parent) && (2 == $depth)) {
		$grand_parent_id = get_post_meta($item->menu_item_parent, '_menu_item_menu_item_parent', true);

		if ($grand_parent_id &&
			SWPMegaMenuUtils::IsMegaMenuDirectChild($grand_parent_id)) {
			?>
			<a href="#" id="menu-item-image-upload-button-<?php echo esc_attr($item_id); ?>" data-id="<?php echo esc_attr($item_id); ?>" class="menu-item-upload-image button button-primary">
				<?php echo esc_html__("Use Custom Image", "artemis-swp"); ?>
			</a>
			<p class="ai_swp_menu_item_image description">
				<label for="edit-menu-item-image-<?php echo esc_attr($item_id); ?>">
						<input type="hidden" id="edit-menu-item-image-<?php echo esc_attr($item_id); ?>" name="menu_item_image[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->customImageUrl); ?>" />
						<img src="<?php echo esc_attr($item->customImageUrl); ?>" id="menu-item-img-preview-<?php echo esc_attr($item_id); ?>" class="menu-item-image-preview" />
						<a href="#" id="remove-menu-item-image-<?php echo esc_attr($item_id); ?>" data-id="<?php echo esc_attr($item_id); ?>" class="remove-menu-item-image" style="<?php echo (trim($item->customImageUrl)) ? 'display: inline;' : 'display: none';?>">
							<?php echo esc_html__("Remove Image", "artemis-swp"); ?>
						</a>
				</label>
			</p>
			<?php			
		}
	}
}

if(!class_exists('SWPWalkerNavMenu') && class_exists('Walker_Nav_Menu_Edit')) {
	class SWPWalkerNavMenu extends Walker_Nav_Menu_Edit {
		public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			$item_id = esc_attr($item->ID);

			SWPMegaMenuUtils::UpdateMegaMenuItems($item, $item_id);
			
			parent::start_el($output, $item, $depth, $args, $id);
			
			ob_start();
			do_action('wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args);
			$inject = '<div class="wp-clearfix"></div>' . ob_get_clean();
			
			$placeholder = '<div class="menu-item-actions description-wide submitbox">';
			$replace = '<div class="swp_replaced menu-item-actions description-wide submitbox">';
			$output = str_replace($placeholder, $inject . $replace, $output);
		}
	}
}
?>
