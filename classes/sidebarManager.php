<?php

namespace EVA;

class sidebarManager {
	
	private static $sidebars;
	
	public static function addSidebar($sidebarID) {
		$sidebars[$sidebarID] = new sidebar();
	}
	
	public static function getSidebar($sidebarID) {
		$retVal = false;
		if(isset($sidebars[$sidebarID])) {
			$retVal = $sidebars[$sidebarID]
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