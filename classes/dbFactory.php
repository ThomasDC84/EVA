<?php

namespace EVA;

class dbFactory {
	
	private static $defaultDB;
	
	public static function boot() {
		if(!self::$defaultDB = settings::getConf('defaultDB')) {
			self::$deafultDB = 'none';
		}
	}
	
	public static function buildDB($dbType) {
		switch($dbType) {
			case 'MySQL': $db = new dbMysql('localhost', 'root', '', 'dovelocompro'); break;
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