<?php

namespace EVA;

class sidebarManager {
	
	private static $sidebars;
	
	public static function addSidebar($sidebar) {
		self::$sidebars[] = $sidebar;
	}
	
	public static function getSidebars() {
		$retVal = false;
		if(!isset($sidebars)) {
			$retVal = self::$sidebars;
		}
		return $retVal;
	}
	
	public static function removeSidebar($sidebarID) {
		$retVal = false;
		if(isset($sidebars[$sidebarID])) {
			unset($sidebars[$sidebarID]);
			$retVal = true;
		}
		return $retVal;
	}

}

?>