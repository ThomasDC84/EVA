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

class dbSQLite3 implements iDatabase {
	
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