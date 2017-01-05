<?php

namespace EVA;

class user {

	private $userName;
	
	private $email;
	
	private $data;

	public function __construct($userName, $email) {
		$this->userName = $userName;
		$this->email = $email;
	}
	
	public function getUserName() {
		return $this->userName;
	}
	
	public function getEmail() {
		return $this->email;
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

}

?>