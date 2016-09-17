<?php

namespace EVA;

class sidebarManager {
	
	private static $numberOfSidebars = 0;
	
	private static $sidebars;
	
	public static function addSidebar($sidebar) {
		self::$numberOfSidebars++;
		self::$sidebars[] = $sidebar;
	}
	
	public static function getSidebars() {
		$result = false;
		if(!isset($sidebars)) {
			$result = self::$sidebars;
		}
		return $result;
	}
	
	public static function getNumberOfSidebars() {
		return self::$numberOfSidebars;
	}
	
	public static function removeSidebar($sidebarID) {
		$retVal = false;
		if(isset($sidebars[$sidebarID])) {
			unset($sidebars[$sidebarID]);
			self::$numberOfSidebars--;
			$retVal = true;
		}
		return $retVal;
	}

}

?>