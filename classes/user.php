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

class user {
	
	private $userLog;

	private $userDomain;
	
	private $userName;
	
	private $email;
	
	private $data;

	public function __construct($userLog, $userDomain, $userName, $email) {
		$this->userLog = $userLog;
		$this->userDomain = $userDomain;
		$this->userName = $userName;
		$this->email = $email;
	}
	
	public function getUserName() {
		return $this->userName;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getLanguage() {
		return $this->language;
	}
	
	public function setData($name, $value) {
		$this->data[$name] = $value;
	}
	
	public function getData($name) {
		$data = null;
		if(array_key_exists($name, $this->data)) {
			$data = $this->data[$name];
		}
		return $data;
	}
	
	public function logout() {
		$this->userLog->out();
	}

}

?>