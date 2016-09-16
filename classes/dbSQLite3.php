<?php

namespace EVA;

class dbSQLite3 {
	
	private $handle;
	
	private $locationIsSet;
	
	private $returnedSet;
	
	public function __construct($location = false) {
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
		$result = false;
		if($this->returnedSet = $this->handle->query($query)) {
			$result = true;
		}
		return $result; 
	}
	
	public function getNumberOfRows() {
		$numberOfRows = 0;
		$this->returnedSet->reset();
		while ($this->returnedSet->fetchArray())
			$numberOfRows++;
		$this->returnedSet->reset();
		return $numberOfRows;
	}
	
	public function fetchResults($type = SQLITE3_ASSOC) {
		return $this->returnedSet->fetchArray($type);
	}
	
	public function __destruct() {
		$this->handle->close();
	}
	
}

?>