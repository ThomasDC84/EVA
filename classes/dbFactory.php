<?php

namespace EVA;

class dbFactory {
	
	private static $config;
	
	public static function boot() {
		self::$config = parse_ini_file(__EVA_HOME__ . '/conf/db.ini.php', true); 
	}
	
	public static function buildDB($dbType) {
		switch($dbType) {
			case 'MySQL': $db = new dbMysql(self::$config['MySQL']['host'],
											self::$config['MySQL']['username'],
											self::$config['MySQL']['password'],
											self::$config['MySQL']['dbname']); break;
			case 'SQLite3': $db = new dbSQLite3(__EVA_HOME__ . '/db/'.
											self::$config['SQLite3']['dbname'].
											'.db'); break;
			default: $db = false;
		}
		return $db;
	}
	
	public static function buildDefaultDB() {
		return self::buildDB(self::$config['General']['defaultDB']);
	}

}

?>