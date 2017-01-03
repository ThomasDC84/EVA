<?php

define('HOOK_FIRST', 1);
define('HOOK_CONTENTS', 2);
define('HOOK_OUTPUT', 3);
define('HOOK_LAST', 4);

function evaAutoCall($className) {
	$className = str_ireplace('EVA\\', '', $className);
	if(file_exists(__EVA_HOME__ . '/classes/' . $className . '.php')) {
		include_once __EVA_HOME__ . '/classes/' . $className . '.php';
	}
	elseif(file_exists(__EVA_HOME__ . '/modules/' . $className . '/module.php')) {
		include_once __EVA_HOME__ . '/modules/' . $className . '/module.php';
	}
	elseif(file_exists(__EVA_HOME__ . '/plugins/' . $className . '/plugin.php')) {
		include_once __EVA_HOME__ . '/plugins/' . $className . '/plugin.php';
	}
	else {
		spl_autoload_unregister('evaAutoCall');
		spl_autoload_call($className);
		spl_autoload_register('evaAutoCall');
	}
}

spl_autoload_register('evaAutoCall');

function errorReport($errorMessage, $errorLevel) {
	
	if(!(ctype_digit($errorLevel) and ($errorLevel < 4))) {
		$errorLevel = 0; //Unknown error level
	}
	
	$filename = __EVA_HOME__ . '/errors.log';
	
	if (is_writable($filename)) {
		if (!$handle = fopen($filename, 'a')) {
			echo "Cannot open file ($filename)";
			exit;
		}
		if (fwrite($handle, $errorLevel . ' - ' . $errorMessage) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
		fclose($handle);
	}
	else {
		echo "The file $filename is not writable";
	}
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

?>