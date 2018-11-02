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

include __PROTEUS_HOME__ . '/modules/testing/snippetListWidget.php';

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
	
	private $snippetCode;
	private $snippetFile;
	private $snippetList;
	private $snippetPath;
	
	public function __construct() {
		//load params here
		$this->languageDomain = 'testing';
		$this->txtDomain = __PROTEUS_HOME__ . '/modules/testing/locale';
		
		$this->snippetCode = urlParser::getUrlParameter('code');
		$this->snippetFile = urlParser::getUrlParameter('snippet');
		$this->snippetPath = __PROTEUS_HOME__ . '/modules/testing/snippets';
		$this->snippetsUrl = __PROTEUS_URL__ . '/modules/testing/snippets';
		
		$this->snippetList = array_diff(scandir($this->snippetPath), array('.', '..'));
	}
	
	private function deleteSnippets() {
		//delete logs if any
		if(urlParser::getUrlParameter('action') == 'deleteSnippets') {
			$snippetFiles = urlParser::getUrlParameter('snippetFile');
			if($snippetFiles) {
				if(!is_array($snippetFiles)) {
					if(file_exists($this->snippetPath . '/' . $snippetFiles)) {
						unlink($this->snippetPath . '/' . $snippetFiles);
					}
				}
				else {
					foreach($snippetFiles as $snippet) {
						if(file_exists($this->snippetPath . '/' . $snippet)) {
							unlink($this->snippetPath . '/' . $snippet);
						}
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
		$this->deleteSnippets();
		$code = '';
		if(false !== $this->snippetCode and false !== $this->snippetFile) {
			file_put_contents($this->snippetPath . '/' . $this->snippetFile, trim($_POST['code']));
		}
		$this->title = gettext('Test Area');
		$this->description = gettext('Module used for testing purpose');
		
		$this->contents = '';
		
		$snippetListWidget = new snippetListWidget();
		$rightSidebar = new sidebar('rightSideBar');
		$rightSidebar->addWidget($snippetListWidget, 1);
		
		sidebarManager::addSidebar($rightSidebar);
		
		if(false !== $this->snippetFile and  file_exists($this->snippetPath . '/' . $this->snippetFile)) {
			$this->contents = htmlentities(file_get_contents($this->snippetsUrl . '/' . $this->snippetFile));
			$code = file_get_contents($this->snippetPath . '/' . $this->snippetFile);
		}
		
		$this->template->replace('%{result}%', gettext('Result'));
		$this->template->replace('%{snippetFile}%', $this->snippetFile);
		$this->template->replace('%{codeLabel}%', gettext('Code'));
		$this->template->replace('%{code}%', trim($code));
		$this->template->replace('%{codeTry}%', gettext('Code to test'));
		$this->template->replace('%{fileName}%', gettext('File Name'));
		$this->template->replace('%{saveAndRun}%', gettext('Save and Run'));
		$this->template->replace('%{revertChanges}%', gettext('Revert Changes'));
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
