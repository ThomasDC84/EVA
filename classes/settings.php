<?php

namespace EVA;

final class settings {
	
	protected static $charset;
	protected static $encoding;
	protected static $config;
	protected static $db;
	
	public static function boot() {
		self::$db = dbFactory::buildDefaultDB();
		self::$config = array();
		if(false !== self::$db->query('SELECT * FROM `settings`') and
			self::$db->getNumberOfRows() != 0) {
			while($r = self::$db->fetchResults()) {
				self::$config[$r['name']] = $r['value'];
			}
		}
		self::$charset = \conNeg::charBest(self::$config['preferredCharset']);
		if(self::$charset == NULL) {
			self::$charset = 'utf-8';
		}
		self::$encoding = \conNeg::encBest(self::$config['preferredEncoding']);
	}
	
	public static function getConf($parameter) {
		$cfg = false;
		if(isset(self::$config[$parameter])) {
			$cfg = self::$config[$parameter];
		}
		return $cfg;
	}
	
	public static function setConf($value, $parameter, $subparam = null) {
		if($subparam == null) {
			self::$config[$parameter] = $value;
		}
		else {
			self::$config[$parameter][$subparam] = $value;
		}
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
	
	public static function setCookie($cookieName, $value = "", $expire = 0,
		$path = "", $domain = "", $secure = false, $httponly = false) {
		return setCookie($cookieName, $value, $expire, $path, $domain, $secure,
		$httponly);
	}
}

?>