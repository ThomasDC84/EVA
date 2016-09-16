<?php

namespace EVA;

class dbFactory {
	
	private static $defaultDB;
	
	public static function boot() {
		if(!self::$defaultDB = settings::getConf('General', 'defaultDB')) {
			self::$defaultDB = 'none';
		}
	}
	
	public static function buildDB($dbType) {
		switch($dbType) {
			case 'MySQL': $db = new dbMysql(settings::getConf('MySQL', 'host'),
											settings::getConf('MySQL', 'username'),
											settings::getConf('MySQL', 'password'),
											settings::getConf('MySQL', 'dbname')); break;
			case 'SQLite3': $db = new dbSQLite3(__EVA_HOME__ . '/db/'.
											settings::getConf('SQLite3', 'dbname').
											'.db'); break;
			default: $db = false;
		}
		return $db;
	}
	
	public static function buildDefaultDB() {
		return self::buildDB(self::$defaultDB);
	}

}

?>