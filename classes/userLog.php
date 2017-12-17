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

class userLog {

	private $currentUser = false;
	private $cet; //cookie expiration time
	private $db;
	private $userDomain;
	
	public function __construct($db, $userDomain = null, $cet = 604800) {
		$this->db = $db;
		$this->userDomain = $userDomain;
		$this->cet = $cet;
	}
 
	public function in() {
		$retval = false;
		if(!is_object($this->currentUser)) {
			if(!($this->currentUser = $this->fromCookie())) {
				$this->currentUser = $this->fromPOST();
			}
			if(is_object($this->currentUser)) {
				$retval = &$this->currentUser;
			}
		}
		else {
			$retval = &$this->currentUser;
		}
		return $retval;
	}
	
	public function out() {
		setcookie('userDomain', '', time()-3600, '/');
		setcookie('userName', '', time()-3600, '/');
		setcookie('password', '',  time()-3600, '/');
	}

	private function getUser($userName, $password, $cookieAccess = false) {
		$user = false;
		$userName = escapeString($userName);
		if(!$cookieAccess) {
			$password = md5($password);
		}
		$query = "SELECT * FROM users WHERE userDomain = '$this->userDomain' AND userName = '$userName' AND password = '$password'";
		if($this->db->query($query) and
			$this->db->getNumberOfRows() != 0) {
			$r = $this->db->fetchResults();
			$user = new user($this, $this->userDomain, $r['userName'], $r['email']);
			
			//load user data here
			
			setcookie('userDomain', $this->userDomain, time()+86400, '/');
			setcookie('userName', $userName, time()+86400, '/');
			setcookie('password', $password, time()+86400, '/');
		}
		return $user;
	}

	private function fromPOST() {
		$userName = '';
		$password = '';
		if(isset($_POST['userName']) and isset($_POST['password'])) {
			$userName = $_POST['userName'];
			$password = $_POST['password'];
		}
		return $this->getUser($userName, $password);
	}

	private function fromCookie() {
		$user = false;
		if(isset($_COOKIE["userName"]) and isset($_COOKIE["password"])) {
			$userName = $_COOKIE["userName"];
			$password = $_COOKIE["password"];
			$user = $this->getUser($userName, $password, true);
		}
		return $user;
	}

	public function setCET($time) {
		self::$cet = $time;
	}

}

?>