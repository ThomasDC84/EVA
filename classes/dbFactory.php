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

class dbFactory {

	private $configuration;
	
	private $configurationFile;
	
	public function __construct($configurationFile = __PROTEUS_HOME__ . '/conf/db.ini.php') {
		$this->setConfigurationFile($configurationFile);
	}
	
	public function setConfigurationFile($configurationFile) {
		$this->configurationFile = $configurationFile;
		$this->configuration = parse_ini_file($this->configurationFile, true);
	}
	
	public function buildDataBase($dbType, $dbName = null) {
	
		if($dbType === true) {
			$dbType = $this->configuration['General']['defaultDB'];
		}
		
		switch($dbType) {
			case 'MySQL': {
				if($dbName == null) {
					$dbName = $this->configuration['MySQL']['dbname'];
				}
				$db = new dbMysql($this->configuration['MySQL']['host'],
				$this->configuration['MySQL']['username'],
				$this->configuration['MySQL']['password'],
				$dbName);
			}; break;
			case 'SQLite3': {
				if($dbName == null) {
					$dbName = $this->configuration['SQLite3']['dbname'];
				}
				$db = new dbSQLite3(__PROTEUS_HOME__ . '/db/'. $dbName . '.db');
			}; break;
			default: { $db = false; }
		}
		return $db;
	}
	
	public function buildDefaultDataBase() {
		return $this->buildDataBase($this->configuration['General']['defaultDB']);
	}

}

?>