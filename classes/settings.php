<?php

namespace EVA;

final class settings {
	
	private static $_language;
	private static $_charset;
	private static $_encoding;
	
	public static function start() {
		self::$_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		self::_detectEncoding();
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
		// return $this;
	}
    /**
     * 
     * 
     * @param <string> $cookieName 
     * @param <string> $value  
     * @param <int> $expire  
     * @param <string> $path  
     * @param <string> $domain  
     * @param <bool> $secure  
     * @param <bool> $httponly  
     * 
     * @return <bool>
     */
	
	public static function setCookie($cookieName, $value = "", $expire = 0, $path = "", $domain = "", $secure = false, $httponly = false) {
		return setCookie($cookieName, $value, $expire, $path, $domain, $secure, $httponly);
	}
}

?>