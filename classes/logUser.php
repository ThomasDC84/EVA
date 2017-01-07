<?php

//User Factory

namespace EVA;

class logUser {
	
	private static $db;
	private static $dbType;
	private static $cet; //cookie expiration time
 
	public static function login() {
		if(!isset(self::$cet)) {
			$cet = 604800; // one week
		}
		self::$dbType = settings::getConf('General', 'defaultDB');
		self::$db = dbFactory::buildDefaultDB();
		if(!($user = self::getUserFromCookie())) {
			if(isset($_POST["userName"]) and isset($_POST["password"])) {
				$user = self::getUserFromPOST();
			}
		}
		return $user;
	}
	
	public static function logout() {
		setcookie('userName', '', time() - 3600, '/');
		setcookie('password', '',  time() - 3600, '/');
	}
	
	public static function getUser($userName, $password, $cookieAccess = false) {
		$user = false;
		$userName = escapeString($userName);
		if(!$cookieAccess) {
			$password = md5($password);
		}
		$query = "SELECT * FROM users WHERE userName = '$userName' AND password = '$password'"; 
		if(self::$db->query($query) and
			self::$db->getNumberOfRows() != 0) {
			$r = self::$db->fetchResults();
			$user = new user($r['userName'], $r['email']);
			setcookie('userName', $userName, time()+86400, '/');
			setcookie('password', $password, time()+86400, '/');
		}
		return $user;
	}
	
	public static function getUserFromPOST() {
		if(isset($_POST['userName']) and isset($_POST['password'])) {
			$userName = $_POST['userName'];
			$password = $_POST['password'];
		}
		return self::getUser($userName, $password);
	}
	
	public static function getUserFromCookie() {
		$user = false;
		if(isset($_COOKIE["userName"]) and isset($_COOKIE["password"])) {
			$userName = $_COOKIE["userName"];
			$password = $_COOKIE["password"];
			$user = self::getUser($userName, $password, true);
		}
		return $user;
	}
	
	public static function setCET($time) {
		self::$cet = $time;
	}

}

?>