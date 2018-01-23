<?php

/**

    This file is part of PROTEUS PHP Web Engine.

    PROTEUS PHP Web Engine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    PROTEUS PHP Web Engine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with PROTEUS PHP Web Engine.  If not, see <http://www.gnu.org/licenses/>.
    
**/

namespace PROTEUS;

class urlParser {

	private static $path;
	private static $scriptName;
	private static $parameters;
	private static $breadCrumbs;
	private static $breadCrumbsLength;
	
	public static function __Init() {
		self::$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		self::$breadCrumbs = explode('/', self::$path);
		      array_shift(self::$breadCrumbs);
		self::$breadCrumbsLength = count(self::$breadCrumbs);
		
	}

	public static function getPath($index = null) {
		$result = false;
		if($index === null) {
			$result = self::$path;
		}
		elseif($index < self::$breadCrumbsLength) {
			$result = self::$breadCrumbs[$index];
		}
		return $result;
	}
	
	public static function getUrlParameter($parameterName) {
		$retval = null;
		if(isset($_GET[$parameterName])) {
			$retval = escapeString($_GET[$parameterName]);
		}
		return $retval;
	}
}

?>
