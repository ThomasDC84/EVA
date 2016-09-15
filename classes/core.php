<?php

namespace EVA;

final class core {
	
	const VERSION = '4.0.0';
	
	private static $pluginManager;
	
	private static $module;
	
	private static $output;
	
	private static $pmToken;
	
	public static function boot() {
		
		settings::boot();
		dbFactory::boot();
		
		self::$pmToken = rand();
		self::$pluginManager = new pluginManager(self::$pmToken);
		self::$pluginManager->attach(new examplePlugin());
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_FIRST
		
		self::loadModule();
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_CONTENTS
		
		self::$module->prepare();
		
		self::$output = self::$module->getOutput();
				
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_LAST
		
		self::shutdown();
	}
	
	private static function loadModule() {
		preg_match('/^\/(.*?)\//i', $_SERVER['REQUEST_URI'], $m);
		$m = array_pop($m);
		if(file_exists(__EVA_HOME__ . '/modules/' . $m . '/module.php')
			and (class_exists($m) or class_exists('EVA\\'.$m))) {
				self::$module = new $m();
		}
		else {
			include_once __EVA_HOME__ . '/modules/page/module.php';
			self::$module = new page();
		}
	}
	
	public static function getModule() {
		return self::$module;
	}
	
	public static function getOutput() {
		return self::$output;
	}
	
	public static function setOutput($string) {
		self::$output = $string;
	}
	
	private static function shutdown() {
		echo self::$output;
	}
	
}

?>