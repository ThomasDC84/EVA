<?php

namespace EVA;

class dbMysql {
	
	private $connection;
	
	public function __construct($host, $username, $password, $dbName) {
		$this->connection = mysqli_connect($host, $username, $password) or die("what?");
		mysqli_select_db($this->connection, $dbName) or die( "Unable to select database");
		if($this->connection === false) {
			// Handle error - notify administrator, log to a file, show an error screen, etc.
		}
	}
	
	public function query($query) {
		$results=array();
		$queryResult = mysqli_query($this->connection, $query);
		while( $result = mysqli_fetch_array( $queryResult, MYSQL_ASSOC ) ) {
			array_push($results, $result);
        }
		$results = $results[0];
		return $results;
	}
	
	public function __destruct() {
		mysqli_close($this->connection);
	}
}

?>