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

class testing implements iModules,
			iSupportDataBase,
			iSupportUser,
			iSupportSettings,
			iSupportInternationalization,
			iSupportTemplate {
	
	private $title;
	private $description;
	private $contents;
	private $output;
	private $dataBase;
	private $languageDomain;
	private $txtDomain;
	private $settings;
	private $user;
	private $template;
	
	public function __construct() {
		//load params here
		$this->languageDomain = 'dummy';
		$this->txtDomain = __PROTEUS_HOME__ . '/locale';
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getContents() {
		return $this->contents;
	}

	public function setContents($contents) {
		$this->contents = $contents;
	}

	public function prepare() {
		$this->title = gettext('Test Area');
		$this->description = gettext('Module used for testing purpose');
		$this->contents = gettext('Test contents<br><pre><code>');
		urlParser::__Init();
		$this->contents .= 'path: ' . urlParser::getPath() . PHP_EOL;
		
		$i=0;
		while(urlParser::getPath($i) !== false) {
			  $this->contents .= $i . ') ' .  urlParser::getPath($i) . PHP_EOL;
			  $i++;
		}
		
		$className = 'pageAdmin';
		$this->contents .= '/modules/' . str_ireplace('Admin', '', $className) . '/' . $className . '.php' . PHP_EOL;
		
		$this->contents .= '</code></pre>';
		
	}

	public function getOutput() {
		return $this->output;
	}
	
	public function getSettingsManager() {
		return $this->settings;
	}
	
	public function setSettingsManager($settings) {
		$this->settings = $settings;
	}
	
	public function getLanguageDomain() {
		return $this->languageDomain;
	}
	
	public function getTextDomain() {
		return $this->txtDomain;
	}
	
	public function getBaseURL() {
		return '/proteus/';
	}
	
	public function getDataBaseFormat() {
		return __PROTEUS_DEFAULT_DATABASE_FORMAT__;
	}
	
	public function getDataBase() {
		return $this->dataBase;
	}

	public function setDataBase($dataBase) {
		$this->dataBase = $dataBase;
	}

	public function getRequireUserSupport() {
		return true;
	}
	
	public function getUserDomain() {
		return 'PROTEUS';
	}
	
	public function setUser($user) {
		$this->user = $user;
	}
	
	public function getTemplateFormat() { //html, php, tpl...
		return 'HTML';
	}
	
	public function getTemplateParameter() { //template.html
		return __PROTEUS_HOME__ . '/modules/testing/template.htm';
	}
	
	public function setTemplate($template) {
		$this->template = $template;
	}
}

?> 
