<?php

namespace EVA;

class dbFactory {
	
	public static function boot() {
		// read the conf
	}
	
	public static function build($dbType) {
		$db = false;
		switch($dbType) {
			case 'MySQL': $db = new dbMysql(); break;
			case 'PostgreSQL': $db = new dbPostgreSQL(); break;
			default:;
		}
		return $db;
	}
	
	public static function buildDefaultDB() {
		return $db = new dbMysql('localhost', 'root', '', 'dovelocompro');
	}

}

?>