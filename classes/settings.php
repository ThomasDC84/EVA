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
	
	public function getCharset() {
		return $this->_language;		
	}
	
	public function getCookie($cookieName) {
		return $this;
	}
    /**
     * 
     * 
     * @param <string> $cookieName 
     * @param <string> $value  
     * @param <int> $expire  
     * @param <string> $path  
     * @param <string> $domain  
     * @param <bool> $secure  
     * @param <bool> $httponly  
     * 
     * @return <bool>
     */
	
	public function setCookie($cookieName, $value = "", $expire = 0, $path = "", $domain = "", $secure = false, $httponly = false) {
		return setCookie($cookieName, $value, $expire, $path, $domain, $secure, $httponly);
	}
}

?>