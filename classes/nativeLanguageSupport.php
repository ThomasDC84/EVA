<?php

namespace EVA;

class nativeLanguageSupport {
	
	private static $language;
	private static $domains;
	
	public static function boot() {
		self::$language = self::detectLanguage();
		self::setLanguage(self::$language);
	}
	
	public static function setLanguage($language) {
		$retval = false;
		if(locale::check($language) != false) {
			self::$language = $language;
		}
		$results = setlocale(LC_ALL, $language . '.' . settings::getCharset(), locale::check($language));
		if (!$results) {
			/*reporter::getReport('NLS Analisys')->addContents(0,
			'setlocale failed with ' . $results . ': locale function is not available on this platform,
			or the given local does not exist in this environment: ' . $language . '.' . settings::getCharset());*/
			
			$results = setlocale(LC_ALL,
				settings::getConf('defaultLanguage') . '.' . settings::getCharset(), locale::check($language));
				
			if (!$results) {
				reporter::getReport('NLS Analisys')->addContents(0,
				'setlocale failed with ' . $results . ': locale function is not available on this platform,
				or the given local does not exist in this environment: ' . 
				settings::getConf('defaultLanguage') . '.' . settings::getCharset());
			}
			
			else {
				$retval = true;
				/*reporter::getReport('NLS Analisys')->addContents(0,
				'current locale is: ' . settings::getConf('defaultLanguage') . '.' . settings::getCharset());*/
			}
		}
		else {
			$retval = true;
		}
		$results = putenv('LC_ALL=' . $language);
		if (!$results) {
			exit ('putenv failed');
		}
		return $retval;
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
			$language = $lngMatches[1];
		}
		elseif(isset($_COOKIE['lng'])) { //detect from cookie
			//reporter::getReport('NLS Analisys')->addContents(0, 'locale from cookie...');
			$language = $_COOKIE['lng'];
		}
		else {
			//reporter::getReport('NLS Analisys')->addContents(0, 'calculating locale with: ' . settings::getConf('preferredLanguage'));
			$language = \conNeg::langBest(); //from db settings settings::getConf('preferredLanguage')
		}
		if(locale::check(self::$language) != false) {
			//reporter::getReport('NLS Analisys')->addContents(0, 'locale from default settings...');
		}
		return $language;
	}

}

?>