<?php

namespace EVA;

final class settings {
	
	protected static $_language;
	protected static $_charset;
	protected static $_encoding;
	
	public static function boot() {
		
		// $config = parse_ini_file('../config.ini'); 
		
		self::$_language = \conNeg::langBest('it,en;q=0.7');
		self::$_charset = \conNeg::charBest('UTF-8,iso-8859-1;q=0.9,UTF-16;q=0.5');
		if(self::$_charset == NULL) {
			self::$_charset = 'utf-8';
		}
		self::$_encoding = \conNeg::encBest('gzip, deflate;q=0.6');
	}
	
	private static function _detectEncoding() {
		self::$_encoding = explode(',', $_SERVER['HTTP_ACCEPT_ENCODING']);
	}
	
	public static function getLanguage() {
		return self::$_language;
	}
	
	public static function getCharset() {
		return self::$_charset;		
	}
	
	public static function getEncoding() {
		return self::$_encoding;
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