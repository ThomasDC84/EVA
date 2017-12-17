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

final class settings {
	
	private $charset;
	private $encoding;
	private $config;
	private $db;
	
	public function __construct($db) {
		$this->db = $db;
		$this->config = array();
		if(false !== $db->query('SELECT * FROM `settings`') and
			$db->getNumberOfRows() != 0) {
			while($r = $db->fetchResults()) {
				$this->config[$r['name']] = $r['value'];
			}
		}
		$this->charset = \conNeg::charBest($this->config['preferredCharset']);
		if($this->charset == NULL) {
			$this->charset = 'utf8';
		}
		$this->encoding = \conNeg::encBest($this->config['preferredEncoding']);
	}
	
	public function getConf($parameter) { //dynamic? depends it from the db?
		$cfg = false;
		if(isset($this->config[$parameter])) {
			$cfg = $this->config[$parameter];
		}
		return $cfg;
	}
	
	public function setConf($value, $parameter, $subparam = null) { //dynamic? depends it from the db?
		if($subparam == null) {
			$this->config[$parameter] = $value;
		}
		else {
			$this->config[$parameter][$subparam] = $value;
		}
	}
	
	public function getCharset() { //static, user is only one...
		return $this->charset;		
	}
	
	public function getEncoding() { //static, user is only one...
		return $this->encoding;
	}
	
	public function getCookie($cookieName) { //static, user is only one...
		$cookieVal = false;
		if(isset($_COOKIE[$cookieName])) {
			$cookieVal = $_COOKIE[$cookieName];
		}
		return $cookieVal;
	}
	
	public function setCookie($cookieName, $value = "", $expire = 0,
		$path = "", $domain = "", $secure = false, $httponly = false) { //static, user is only one...
		return setCookie($cookieName, $value, $expire, $path, $domain, $secure,
		$httponly);
	}
}

?>