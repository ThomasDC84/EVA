<?php

namespace EVA;

final class settings {
	
	protected static $language;
	protected static $charset;
	protected static $encoding;
	protected static $config;
	
	public static function boot() {
		
		self::$config = parse_ini_file(__EVA_HOME__ . '/conf/default.ini'); 
		
		self::$language = \conNeg::langBest('it,en;q=0.7');
		self::$charset = \conNeg::charBest('UTF-8,iso-8859-1;q=0.9,UTF-16;q=0.5');
		if(self::$charset == NULL) {
			self::$charset = 'utf-8';
		}
		self::$encoding = \conNeg::encBest('gzip, deflate;q=0.6');
	}
	
	public static function getConf($parameter) {
		$cfg = false;
		if(isset(self::$config[$parameter])) {
			$cfg = self::$config[$parameter];
		}
		return $cfg;
	}
		
	public static function getLanguage() {
		return self::$language;
	}
	
	public static function getCharset() {
		return self::$charset;		
	}
	
	public static function getEncoding() {
		return self::$encoding;
	}
	
	public static function getCookie($cookieName) {
		$cookieVal = false;
		if(isset($_COOKIE[$cookieName])) {
			$cookieVal = $_COOKIE[$cookieName];
		}
		return $cookieVal;
			
	}
	
	public static function setCookie($cookieName, $value = "", $expire = 0, $path = "", $domain = "", $secure = false, $httponly = false) {
		return setCookie($cookieName, $value, $expire, $path, $domain, $secure, $httponly);
	}
}

?>