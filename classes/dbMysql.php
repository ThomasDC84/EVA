<?php

namespace EVA;

class dbMysql {
	
	private $connection;
	
	private $returnedSet;
	
	public function __construct($host, $username, $password, $dbName) {
		$this->connection = mysqli_connect($host, $username, $password) or die("what?");
		mysqli_select_db($this->connection, $dbName) or die( "Unable to select database");
		if($this->connection === false) {
			// Handle error - notify administrator, log to a file, show an error screen, etc.
		}
	}
	
	public function query($query) {
		$this->returnedSet = mysqli_query($this->connection, $query);
	}
	
	public function fetchResults() {
		return mysqli_fetch_array( $this->returnedSet, MYSQL_ASSOC );		
	}
	
	public function __destruct() {
		mysqli_close($this->connection);
	}
}

?>