<?php

namespace EVA;

class dbSQLite3 {
	
	private $handle;
	
	private $locationIsSet;
	
	private $returnedSet;
	
	public function __construct($location = __EVA_HOME__ . '/db/sql.db') {
		$this->locationIsSet = false;
		if($location != false) {
			$this->setLocation($location);
			$this->locationIsSet = true;
		}
	}
	
	public function setLocation($location) {
		if(!$this->locationIsSet) {
			$this->handle = new \SQLite3($location);
		}
	}
	
	public function query($query) {
		$this->returnedSet = $this->handle->query($query);
	}
	
	public function fetchResults($type = SQLITE3_ASSOC) {
		return $this->returnedSet->fetchArray($type);
	}
	
	public function __destruct() {
		$this->handle->close();
	}
	
}

?>