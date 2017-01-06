<?php

namespace EVA;

//report factory

class reporter {
	
	private static $reports;
	
	public static function getReport($id) {
		$report = false;
		if(is_array(self::$reports) and array_key_exists($id, self::$reports)) {
			$report = self::$reports[$id];
		}
		else {
			$report = new report($id);
			self::$reports[$id] = $report;
		}
		return $report;
	}

}

?>