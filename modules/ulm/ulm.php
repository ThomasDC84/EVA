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

class ulm implements  iModules,
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
		$this->languageDomain = 'ulm';
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
		$this->title = gettext('User Log Manager');
		$this->description = gettext('PROTEUS ULM Module for general user login/logout');
		
		if(isset($_GET['action']) and $_GET['action'] == 'logout') {
			//save username here to say goodbye later...
			$this->user->logout(); //this doesn't work
			$this->user = false;
		}

		$this->contents = get_template('logInForm', file_get_contents(__PROTEUS_HOME__ . '/modules/ulm/loginForm.htm'));

		$referer = '';
		$refererPrefix= '&referer=';

		if(!$this->user) {
			if(isset($_GET['referer'])) {
				$referer = $_GET['referer'];
			}
			else {
				$refererPrefix = '';
			}

			$this->contents = str_replace(
				array('%{Login}%', '%{User Name:}%', '%{Password:}%', '%{LogIn}%', '%{Reset}%', '%{$referer}%'),
				array(gettext('Login'), gettext('User Name:'), gettext('Password:'), gettext('Log In'), gettext('Reset'), $refererPrefix.$referer),
				$this->contents);
		}
		else {
			$this->contents = '<div style="text-align: center"><p>' . gettext('Logged as') . ' ' . $this->user->getUserName() . '<br/><a href="?action=logout">' . gettext('Log Out') . '</a></p></div>';
			if(isset($_GET['referer'])) {
				header('Refresh: 5; URL=' . $_GET['referer']);
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
		return __PROTEUS_HOME__ . '/modules/ulm/template.htm';
	}
	
	public function setTemplate($template) {
		$this->template = $template;
	}
}

?>