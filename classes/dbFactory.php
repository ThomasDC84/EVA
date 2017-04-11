<?php

namespace EVA;

class dbFactory {
	
	private static $config;
	
	public static function boot() {
		self::$config = parse_ini_file(__EVA_HOME__ . '/conf/db.ini.php', true); 
	}
	
	public static function buildDB($dbType, $dbName = null) {
		
		switch($dbType) {
			case 'MySQL': {
				if($dbName == null) {
					$dbName = self::$config['MySQL']['dbname'];
				}
				$db = new dbMysql(self::$config['MySQL']['host'],
				self::$config['MySQL']['username'],
				self::$config['MySQL']['password'],
				$dbName);
			}; break;
			case 'SQLite3': {
				if($dbName == null) {
					$dbName = self::$config['SQLite3']['dbname'];
				}
				$db = new dbSQLite3(__EVA_HOME__ . '/db/'. $dbName . '.db');
			}; break;
			default: $db = false;
		}
		return $db;
	}
	
	public static function buildDefaultDB($dbName = null) {
		return self::buildDB(self::$config['General']['defaultDB'], $dbName);
	}

}

?>