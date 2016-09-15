<?php

namespace EVA;

class dbFactory {
	
	private static $defaultDB;
	
	public static function boot() {
		if(!self::$defaultDB = settings::getConf('General', 'defaultDB')) {
			self::$deafultDB = 'none';
		}
	}
	
	public static function buildDB($dbType) {
		switch($dbType) {
			case 'MySQL': $db = new dbMysql(settings::getConf('MySQL', 'host'),
											settings::getConf('MySQL', 'username'),
											settings::getConf('MySQL', 'password'),
											settings::getConf('MySQL', 'dbname')); break;
			case 'SQLite3': $db = new dbSQLite3(); break;
			default: $db = false;
		}
		return $db;
	}
	
	public static function buildDefaultDB() {
		return self::buildDB(self::$defaultDB);
	}

}

?>