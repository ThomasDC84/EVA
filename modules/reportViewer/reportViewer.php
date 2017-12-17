<?php

/**

    This file is part of EVA PHP Web Engine.

    EVA PHP Web Engine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    EVA PHP Web Engine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with EVA PHP Web Engine.  If not, see <http://www.gnu.org/licenses/>.
    
**/

namespace EVA;

include __EVA_HOME__ . '/modules/reportViewer/reportListWidget.php';

class reportViewer implements iModules,
			      iSupportDataBase,
			      iSupportUser,
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
		$this->languageDomain = 'reportViewer';
		$this->txtDomain = __EVA_HOME__ . '/locale';
	}
	
	private function readLog() {
		//read Log if any
		if(isset($_GET['readLog'])) {
			if(file_exists(__EVA_HOME__ . '/reports/' . $_GET['readLog'])) {
				$reportFileName = $_GET['readLog'];
				$report = file_get_contents(__EVA_HOME__ . '/reports/' . $_GET['readLog']);
				$this->contents = '<div style="padding: 10px;"><h1>' . $reportFileName . '</h1><hr/><br/><pre>' . $report . '</pre></div>';
			}
		}
	}
	
	private function deleteLogs() {
		//delete logs if any
		if(isset($_POST['report'])) {
			if(!is_array($_POST['report'])) {
				if(file_exists(__EVA_HOME__ . '/reports/' . $_POST['report'])) {
					unlink($_POST['report']);
				}
			}
			else {
				foreach($_POST['report'] as $report) {
					if(file_exists(__EVA_HOME__ . '/reports/' . $report)) {
						unlink(__EVA_HOME__ . '/reports/' . $report);
					}
				}
			}
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
		
		$title = gettext('System Report Viewer');
			
		$this->title = $title;
		$this->description = $title;
		
		if(!$this->user) {
			$this->template->setTemplate(__EVA_HOME__ . '/modules/reportViewer/accessDenied.htm');
			$this->contents = gettext('Access Denied') . '. ' . 
				gettext('Please authenticate yourself in the') . ' <a href="/ulm/index.php?referer=/reportViewer/index.php">' .
				gettext('authentication page') . '</a>.';
		}
		else {
			$reportListWidget = new reportListWidget();
			
			$rightSidebar = new sidebar('rightSideBar');
			
			$rightSidebar->addWidget($reportListWidget, 1);
			
			$userWidget = new exampleWidget('user', gettext('Logged as: ') . $this->user->getUserName() . ' ');
			$userWidget->setPutInTemplate(false);
			
			$footerSidebar = new sidebar('footerSideBar');
			
			$footerSidebar->addWidget($userWidget, 1);
			
			sidebarManager::addSidebar($rightSidebar);
			sidebarManager::addSidebar($footerSidebar);
			
			$this->contents = '<p>' . gettext('No report selected to show') . '</p>';
			$this->readLog();
			$this->deleteLogs();
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
		return '/eva/';
	}
	
	public function getDataBaseFormat() {
		return __EVA_DEFAULT_DATABASE_FORMAT__;
	}
	
	public function getDataBase() {
		return $this->dataBase;
	}

	public function setDataBase($dataBase) {
		$this->dataBase = $dataBase;
	}
	
	public function getUserDomain() {
		return 'EVA';
	}
	
	public function setUser($user) {
		$this->user = $user;
	}
	
	public function getTemplateFormat() { //html, php, tpl...
		return 'HTML';
	}
	
	public function getTemplateParameter() { //template.html
		return __EVA_HOME__ . '/modules/reportViewer/template.htm';
	}
	
	public function setTemplate($template) {
		$this->template = $template;
	}
}

?>