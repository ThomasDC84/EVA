<?php

namespace EVA;

class dbSQLite3 {
	
	private $handle;
	
	private $returnedSet;
	
	public function __construct($location = __EVA_HOME__ . '/sql.db') {
		$this->handle = new \SQLite3($location);
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