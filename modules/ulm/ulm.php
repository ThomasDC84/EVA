<?php

namespace EVA;

class ulm implements iModules {
	
	private $title;
	private $description;
	private $contents;
	private $template;
	private $output;
	
	public function __construct() {
		
		$this->title = gettext('User Log Manager');
		$this->description = gettext('EVA ULM Module for general user login/logout');
		
		$this->template = templateFactory::buildTemplate('HTML');		
		$this->template->setTemplate(__EVA_HOME__ . '/modules/ulm/template.htm');
		
		if(isset($_GET['action']) and $_GET['action'] == 'logout') {
			logUser::logout();
			$user = false;
		}
		else {
			$user = logUser::login();
		}
		
		$this->contents = $this->template->getSection('logInForm');
		
		$referer = '';
		$refererPrefix= '';
				
		if(!$user) {
			if(isset($_GET['referer'])) {
				$referer = $_GET['referer'];
			}
			else {
				$refererPrefix = '&referer=';
			}
			
			$this->contents = str_replace(
				array('%{Login}%', '%{User Name:}%', '%{Password:}%', '%{LogIn}%', '%{Reset}%', $refererPrefix.'%{$referer}%'),
				array(gettext('Login'), gettext('User Name:'), gettext('Password:'), gettext('Log In'), gettext('Reset'), $referer),
				$this->contents);
		}
		else {
			$this->contents = '<div><p>Logged as ' . $user->getUserName() . '<br/><a href="?action=logout">' . gettext('Log Out') . '</a></p></div>';
			if(isset($_GET['referer'])) {
				header('Refresh: 5; URL=' . $_GET['referer']);
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
		$this->template->setTitle($this->title);
		$this->template->setDescription($this->description);
		$this->template->setContents($this->contents);
		
		$this->output = $this->template->getOutput();		
	}
	
	public function getOutput() {
		return $this->output;
	}
	
}

?>