<?php
echo E_ERROR . '                   ' . decbin(E_ERROR) . PHP_EOL;
echo E_WARNING . '                  ' . decbin(E_WARNING) . PHP_EOL;
echo E_PARSE . '                 ' . decbin(E_PARSE) . PHP_EOL;
echo E_NOTICE . '                ' . decbin(E_NOTICE) . PHP_EOL;
echo E_CORE_ERROR . '              ' . decbin(E_CORE_ERROR) . PHP_EOL;
echo E_CORE_WARNING . '             ' . decbin(E_CORE_WARNING) . PHP_EOL;
echo E_COMPILE_ERROR . '            ' . decbin(E_COMPILE_ERROR) . PHP_EOL;
echo E_COMPILE_WARNING . '          ' . decbin(E_COMPILE_WARNING) . PHP_EOL;
echo E_USER_ERROR . '         ' . decbin(E_USER_ERROR) . PHP_EOL;
echo E_USER_WARNING . '        ' . decbin(E_USER_WARNING) . PHP_EOL;
echo E_USER_NOTICE . '      ' . decbin(E_USER_NOTICE) . PHP_EOL;
echo E_DEPRECATED . '   ' . decbin(E_DEPRECATED) . PHP_EOL;
echo E_ALL . ' ' . decbin(E_ALL) . PHP_EOL;
//              0123456789ABCDE
$test = '010000010000001';
echo 'sum =  ' . $test . PHP_EOL;

echo 'E_ALL is '; if(isset($test[0]) and $test[0] != 1) {
	echo 'not enabled' . PHP_EOL;
	echo 'E_DEPRECATED is '; if(isset($test[1]) and $test[1] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_USER_NOTICE is '; if(isset($test[4]) and $test[4] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_USER_WARNING is '; if(isset($test[5]) and $test[5] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_USER_ERROR is '; if(isset($test[6]) and $test[6] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_COMPILE_WARNING is '; if(isset($test[7]) and $test[7] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_COMPILE_ERROR is '; if(isset($test[8]) and $test[8] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_CORE_WARNING is '; if(isset($test[9]) and $test[9] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_CORE_ERROR is '; if(isset($test[10]) and $test[10] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_NOTICE is '; if(isset($test[11]) and $test[11] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_PARSE is '; if(isset($test[12]) and $test[12] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_WARNING is '; if(isset($test[13]) and $test[13] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
	echo 'E_ERROR is '; if(isset($test[14]) and $test[14] != 1) echo 'not '; echo 'enabled' . PHP_EOL;
}
else {
	echo 'enabled' . PHP_EOL .
		'E_DEPRECATED is enabled' . PHP_EOL .
		'E_USER_NOTICE is enabled' . PHP_EOL .
		'E_USER_WARNING is enabled' . PHP_EOL .
		'E_USER_ERROR is enabled' . PHP_EOL .
		'E_COMPILE_WARNING is enabled' . PHP_EOL .
		'E_COMPILE_ERROR is enabled' . PHP_EOL .
		'E_CORE_WARNING is enabled' . PHP_EOL .
		'E_CORE_ERROR is enabled' . PHP_EOL .
		'E_NOTICE is enabled' . PHP_EOL .
		'E_PARSE is enabled' . PHP_EOL .
		'E_WARNING is enabled' . PHP_EOL .
		'E_ERROR is enabled' . PHP_EOL;
}
?>