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

class dbMysql implements iDatabase {
	
	private $connection;
	
	private $returnedSet;
	
	public function __construct($host, $username, $password, $dbName) {
		$this->connection = new \mysqli($host, $username, $password, $dbName) or die("what?");
		if($this->connection === false) {
			exit('connection false');
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