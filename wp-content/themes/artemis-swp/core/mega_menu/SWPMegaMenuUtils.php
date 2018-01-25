<?php

if( !class_exists('SWPMegaMenuUtils')) {
	class SWPMegaMenuUtils {
		static $megaMenuItemsArr = array();
		
		public static function UpdateMegaMenuItems($menuItem, $menuItemId) {
			if ($menuItem->isAiSwpMegaMenu) {
				self::$megaMenuItemsArr[] = $menuItemId;
			} else {
				self::$megaMenuItemsArr = array_diff(self::$megaMenuItemsArr, array($menuItemId));
			}
		}
		
		public static function IsMegaMenuDirectChild($parentMenuId) {
			return in_array($parentMenuId, self::$megaMenuItemsArr) ? true : false;
		}
	}
}

?>