<?php
print_r(parse_ini_file(__PROTEUS_HOME__ . '/modules/testing/module.ini', true));

if(isset($_POST['code'])) {
  echo PHP_EOL . 'contents of $_POST["code"] are :' . PHP_EOL . $_POST['code'];
}
else {
  echo '$_POST["code"] was not set';
}

?>
