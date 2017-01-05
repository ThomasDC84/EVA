<?php

namespace EVA;

class dbMysql {
	
	private $connection;
	
	private $returnedSet;
	
	public function __construct($host, $username, $password, $dbName) {
		$this->connection = new \mysqli($host, $username, $password) or die("what?");
		$this->connection->select_db($dbName) or die( "Unable to select database");
		if($this->connection === false) {
			// Handle error - notify administrator, log to a file, show an error screen, etc.
		}
	}
	
	public function query($queryString) {
		$result = false;
		if($this->returnedSet = $this->connection->query($queryString)) { //return an error here via errorLog
			$result = true;
		}
		return $result;
	}
	
	public function getNumberOfRows() {
		$numberOfRows = 0;
		if(is_object($this->returnedSet)) {
			$numberOfRows = $this->returnedSet->num_rows;
		}
		return $numberOfRows;
	}
		
	public function fetchResults() {
		return $this->returnedSet->fetch_assoc();		
	}
	
	public function __destruct() {
		$this->connection->close();
	}
}

?>