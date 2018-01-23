<?php

/**

    This file is part of PROTEUS PHP Web Engine.

    PROTEUS PHP Web Engine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    PROTEUS PHP Web Engine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with PROTEUS PHP Web Engine.  If not, see <http://www.gnu.org/licenses/>.
    
**/

namespace PROTEUS;

class nativeLanguageSupport {
	
	private $language;
	private $domains;
	private $settings;
	
	public function __construct($module) {
		$this->settings = $module->getSettingsManager();
		
		$this->language = $this->detectLanguage();
		$this->setLanguage($this->language);
		
		bindtextdomain($module->getLanguageDomain(), $module->getTextDomain());
		textdomain($module->getLanguageDomain());
		
	}
	
	public function detectLanguage() {
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
		if(locale::check($this->language) != false) {
			//reporter::getReport('NLS Analisys')->addContents(0, 'locale from default settings...');
		}
		return $language;
	}
	
	public function setLanguage($language) {
		//improve this method
		$retval = false;
		
		if(locale::check($language) != false) {
			$this->language = $language;
		}
		else {
			$this->language = $this->settings->getConf('defaultLanguage');
		}
		$this->language = 'it-IT';
		$results = putenv('LC_ALL=' . $this->language);
		if (!$results) {
			exit ('putenv failed');
		}
		
		$results = setlocale(LC_ALL, $this->language . '.' . $this->settings->getCharset(), locale::check($language));
		if (!$results) {
			/*reporter::getReport('NLS Analisys')->addContents(0,
			'setlocale failed with ' . $results . ': locale function is not available on this platform,
			or the given local does not exist in this environment: ' . $language . '.' . $this->settings->getCharset());*/
			
			$results = setlocale(LC_ALL,
				$this->settings->getConf('defaultLanguage') . '.' . $this->settings->getCharset(), locale::check($language));
				
			if (!$results) {
				/*reporter::getReport('NLS Analisys')->addContents(1,
				'setlocale failed with ' . $results . ': locale function is not available on this platform,
				or the given local does not exist in this environment: ' . 
				$this->settings->getConf('defaultLanguage') . '.' . $this->settings->getCharset());*/
			}
			
			else {
				$retval = true;
				/*reporter::getReport('NLS Analisys')->addContents(0,
				'current locale is: ' . $this->settings->getConf('defaultLanguage') . '.' . $this->settings->getCharset());*/
			}
		}
		else {
			$retval = true;
			/*reporter::getReport('NLS Analisys')->addContents(0,
			'current locale is: ' . $this->language . '.' . $this->settings->getCharset());*/
		}
		return $retval;
	}
	
	public function addTranslation($domain, $directory = __PROTEUS_HOME__ . '/locale') {
		bindtextdomain($domain, $directory);
		$this->domains[] = $domain;
	}
	
	public function getTranslation($domain) {
		$result =false;
		if(in_array($domain, $this->domains)) {
			textdomain($domain);
			$result =true;
		}
		return $result;
	}
	
	public function getLanguage() {
		return $this->language;
	}

}

?>