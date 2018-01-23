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

class page implements iModules,
		      iSupportDataBase,
		      iSupportSettings,
		      iSupportInternationalization,
		      iSupportTemplate {
	
	private $id;
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
		$this->languageDomain = 'page';
		$this->txtDomain = __PROTEUS_HOME__ . '/locale';
		$this->output = '\'@\'';
	}
	
	private function detectID() {
		$cpn = array('/index.php', '/index.html', '/index.htm', '/index.shtml'); //cpn = common pages name
		$id = str_ireplace($cpn, '', $_SERVER['REQUEST_URI']);
		$id = trim($id, '/');
		$id = explode('/', $id);
		$id = array_pop($id);
		if(!ctype_digit($id) or empty($id)) {
			$this->id = 1;
		}
		else {
			$this->id = $id;
		}
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
		$this->detectID();
		if($this->dataBase->query('SELECT * FROM `pages` WHERE `id` = ' . $this->id) and
			$this->dataBase->getNumberOfRows() != 0) {
			$r = $this->dataBase->fetchResults();
			$this->title = $r['title'];
			$this->description = $r['description'];
			$this->contents = $r['contents'];
		}
		else {
			$this->title = 'Page 404';
			$this->description = 'Page not Found';
			$this->contents = 'The page you were looking for was not found';
		}
		
		$testWidget = new dummyWidget('Test', 'Hello World!');
		
		$sidebar = new sidebar('leftSidebar');
		
		$sidebar->addWidget($testWidget, 1);
		
		sidebarManager::addSidebar($sidebar);
	}
	
	public function getOutput() {
		return $this->output;
	}
	
	public function getRequireSettingsManager() {
		return true;
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
	
	public function getTemplateFormat() { //html, php, tpl...
		return 'HTML';
	}
	
	public function getTemplateParameter() { //template.html
		return __PROTEUS_HOME__ . '/modules/page/template.htm';
	}
	
	public function setTemplate($template) {
		$this->template = $template;
	}
}

?>
