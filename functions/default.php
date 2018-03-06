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

define('__PROTEUS_DEFAULT_DATABASE_FORMAT__', true);
define('HOOK_FIRST', 1);
define('HOOK_CONTENTS', 2);
define('HOOK_OUTPUT', 3);
define('HOOK_LAST', 4);

function proteusAutoCall($className) {
	$className = str_ireplace('PROTEUS\\', '', $className);
	if(file_exists(__PROTEUS_HOME__ . '/classes/' . $className . '.php')) {
		require_once __PROTEUS_HOME__ . '/classes/' . $className . '.php';
	}
	elseif(file_exists(__PROTEUS_HOME__ . '/modules/' . $className . '/' . $className . '.php')) {
		require_once __PROTEUS_HOME__ . '/modules/' . $className . '/' . $className . '.php';
	}
	elseif(file_exists(__PROTEUS_HOME__ . '/modules/' . str_ireplace('Admin', '', $className) . '/' . $className . '.php')) {
		require_once __PROTEUS_HOME__ . '/modules/' . str_ireplace('Admin', '', $className) . '/' . $className . '.php';
	}
	elseif(file_exists(__PROTEUS_HOME__ . '/plugins/' . $className . '/' . $className . '.php')) {
		require_once __PROTEUS_HOME__ . '/plugins/' . $className . '/' . $className . '.php';
	}
}

spl_autoload_register('proteusAutoCall');

function callSubModule($subModuleName = null) {
	if($subModuleName == null) {
		$subModuleName = PROTEUS\urlParser::getPath(1);
	}
	$result = false;
	$classFile = __PROTEUS_HOME__ . '/modules/' . str_ireplace('PROTEUS\\', '', PROTEUS\core::getModuleName()) . '/subModules/' . $subModuleName . '.php';
	if(file_exists($classFile)) {
		require_once $classFile;
		if(class_exists($subModuleName)) {
			$result = new $subModuleName(PROTEUS\core::getModule());
		}
		elseif(class_exists('PROTEUS\\' . $subModuleName)) {
			$subModuleName = 'PROTEUS\\' . $subModuleName;
			$result = new $subModuleName(PROTEUS\core::getModule());
		}
	}
	return $result;
}

function url_origin( $s, $use_forwarded_host = false )
{
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

function full_url( $s, $use_forwarded_host = false )
{
    return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
}

function get_template($tag, $html) {
	if(is_file($html)) {
		$html = file_get_contents($html);
	}
	$startsAt = strpos($html, '<!--'.$tag.'-->') + strlen('<!--'.$tag.'-->');
	$endsAt = strpos($html, '<!--/'.$tag.'-->', $startsAt);
	$result = substr($html, $startsAt, $endsAt - $startsAt);
	return $result;
}

function parse_template($tags, $replacements, $template = '')
{
	$tagsLength = count($tags);
	for($i=0; $i<$tagsLength; $i++) {
		$tags[$i] = '%{'.$tags[$i].'}%';
	}
	if(is_file($template)) {
		$template = file_get_contents($template);
	}
	$template = str_ireplace($tags, $replacements, $template);
	return $template;
}
function parse_array2template($values, $template = '')
{
	if(is_file($template)) {
		$template = file_get_contents($template);
	}
	foreach($values as $tag => $value) {
		$template = str_ireplace('%{'. $tag .'}%', $value, $template);
	}
	
	return $template;
}

function escapeString($string) {
	$search = array("\\"      ,  "\_",   "\%", "\x00",   "\b",  "\n",  "\t",   "\r",  "'",  '"', "\x1a");
	$replace = array("\\\\", "\\_", "\\%",    "\\0", "\\b","\\n", "\\t", "\\r", "\'", '\"', "\\Z");

	$string = str_replace($search, $replace, $string);

	$string = htmlentities($string);

	return $string;
}

function report ($id, $contents, $errorLevel = 0) {
	PROTEUS\reporter::getReport($id)->addContents($contents, $errorLevel);
}

?>