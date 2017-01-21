<?php

namespace EVA;

class nativeLanguageSupport {
	
	private static $language;
	private static $domains;
	
	public static function boot() {
		self::$language = self::detectLanguage();
	}
	
	public static function setLanguage($language) {
		if(locale::check($language) != false) {
			self::$language = $language;
		}
		$results = putenv('LC_ALL=' . $language);
		if (!$results) {
			exit ('putenv failed');
		}
		
		$results = setlocale(LC_ALL, $language, locale::check($language));
		
		if (!$results) {
			exit ('setlocale failed: locale function is not available on this platform, or the given local does not exist in this environment');
		}
		return $results;
	}
	
	public static function addTranslation($domain, $directory = __EVA_HOME__ . '/locale') {
		bindtextdomain($domain, $directory);
		self::$domains[] = $domain;
	}
	
	public static function getTranslation($domain) {
		$result =false;
		if(in_array($domain, self::$domains)) {
			textdomain($domain);
			$result =true;
		}
		return $result;
	}
	
	public static function getLanguage() {
		return self::$language;
	}
	
	public static function detectLanguage() {
		if(isset($_GET['locale']) and locale::check($_GET['locale'])) { //detect from "?locale=" in URL
			$language = $_GET['locale'];
		}
		elseif(preg_match('/^\/([a-z]{2,3}[\_]?[a-zA-Z]{0,3})\//', $_SERVER['REQUEST_URI'], $lngMatches) == 1) { //detect from domain.url/it_IT/ (URL Path)
			$language = lngMatches[1];
		}
		elseif(isset($_COOKIE['lng'])) { //detect from cookie
			$language = $_COOKIE['lng'];
		}
		else {
			$language = \conNeg::langBest(settings::getConf('preferredLanguage')); //from db settings
		}
		if(locale::check(self::$language) != false) {
			$language = settings::getConf('defaultLanguage'); //from db settings
		}
		return $language;
	}

}

?>