<?php

/**

    This file is part of EVA PHP Web Engine.

    EVA PHP Web Engine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    EVA PHP Web Engine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with EVA PHP Web Engine.  If not, see <http://www.gnu.org/licenses/>.
    
**/

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