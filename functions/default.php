<?php

define('HOOK_FIRST', 1);
define('HOOK_CONTENTS', 2);
define('HOOK_LAST', 3);

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
	
	$filename = 'errors.log';
	
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

?>