<?php

namespace EVA;

class settings {
	
	private $_language;
	
	public function __construct() {
		$this->_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	}
	
	public function getLanguage() {
		return $this->_language;
	}
	
	public function getCookie($cookieName) {
		return $this;
	}
	
	public function setCookie($cookieName) {
		return $this;
	}
}

?>