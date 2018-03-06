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

include_once __PROTEUS_HOME__ . '/modules/admin/adminWidget.php';

class admin implements  iModules,
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
		$this->languageDomain = 'admin';
		$this->txtDomain = __PROTEUS_HOME__ . '/modules/admin/locale';
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
		$this->title = gettext('Administration Area');
		$this->description = gettext('PROTEUS Administration Module');
		$this->contents = gettext('Administration settings.');
		
		if(!$this->user) {
			$this->template->setTemplate(__PROTEUS_HOME__ . '/modules/admin/accessDenied.htm');
			$this->contents = gettext('Access Denied') . '. ' . 
				gettext('Please authenticate yourself in the') . ' <a href="/ulm/index.php?referer=/admin/index.php">' .
				gettext('authentication page') . '</a>.';
		}
		else {
			$leftSidebar = new sidebar('leftSideBar');
			
			$adminWidget = new adminWidget($this);
			
			$leftSidebar->addWidget($adminWidget, 1);
			
			$footerSidebar = new sidebar('footerSideBar');
			
			$footerWidget = new dummyWidget('footer', gettext('PROTEUS Admin Area'));
			
			$footerWidget->setUseTemplate(true);
			
			$footerSidebar->addWidget($footerWidget, 1);
			
			sidebarManager::addSidebar($leftSidebar);
			sidebarManager::addSidebar($footerSidebar);
			
			/** Load Specific Settings **/
			switch(urlParser::getUrlParameter('options')) {
				case 'module': {
					$moduleSettings = null;
					$moduleOption = urlParser::getUrlParameter('module') . 'Admin';
					if(class_exists($moduleOption, true)) {
						$moduleSettings = new $moduleOption();
					}
					elseif(class_exists('PROTEUS\\'.$moduleOption, true)) {
						$moduleOption = 'PROTEUS\\'.$moduleOption;
						$moduleSettings = new $moduleOption();
					}
					if($moduleSettings != null) {
						$this->title .= ' | ' . $moduleSettings->getTitle();
						$this->description .= ' | ' . $moduleSettings->getDescription();
						$this->contents .= $moduleSettings->getContents();
					}
					else {
						$this->title .= ' | ' . gettext('Not Found');
						$this->description .= ' | ' . gettext('Module requested not found');
						$this->contents .= gettext('The module selected does not exist or does not have an administration module');
					}
				}; break;
				case 'plugin': {
					$pluginSettings = null;
					$pluginOption = urlParser::getUrlParameter('plugin') . 'Admin';
					if(class_exists($pluginOption, true)) {
						$pluginSettings = new $pluginOption();
					}
					elseif(class_exists('PROTEUS\\'.$pluginOption, true)) {
						$pluginOption = 'PROTEUS\\'.$pluginOption;
						$pluginSettings = new $pluginOption();
					}
					if($pluginSettings != null) {
						$this->title .= ' | ' . $pluginSettings->getTitle();
						$this->description .= ' | ' . $pluginSettings->getDescription();
						$this->contents .= $pluginSettings->getContents();
					}
					else {
						$this->title .= ' | ' . gettext('Not Found');
						$this->description .= ' | ' . gettext('Plugin requested not found');
						$this->contents .= gettext('The plugin selected does not exist or does not have an administration module');
					}
				}; break;
				default: {
					callSubModule(urlParser::getUrlParameter('options')) or
					callSubModule('showcase');
				};
			}
		}
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
		return __PROTEUS_HOME__ . '/modules/admin/template.htm';
	}
	
	public function setTemplate($template) {
		$this->template = $template;
	}
}

?>