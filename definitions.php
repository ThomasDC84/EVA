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

if(!defined('__PROTEUS_HOME__')) {
	define('__PROTEUS_HOME__', getcwd());
}

if(!defined('__PROTEUS_URL__')) {
	$host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	define('__PROTEUS_URL__', $host.'/proteus/');
}

if(!defined('__PROTEUS_ERROR_REPORTING__')) {
	define('__PROTEUS_ERROR_REPORTING__', E_ALL);
}

if(!defined('__PROTEUS_DISPLAY_ERRORS__')) {
	define('__PROTEUS_DISPLAY_ERRORS__', 1);
}

define('__PROTEUS_DEFAULT_DATABASE_FORMAT__', true);

?>