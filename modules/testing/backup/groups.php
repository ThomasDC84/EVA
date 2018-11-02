<?php

$groups = 4294967295;
$groupsBin = decbin($groups);
echo $groups . ' in binary is: ' . $groupsBin . PHP_EOL;

for($i = 0; $i < 32; $i++) {
	echo 'you are';
	if($groupsBin[$i] == 0) {
		echo ' not';
	}
	echo ' in group #' . $i . PHP_EOL;
}

?>