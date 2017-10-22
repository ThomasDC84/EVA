<?php

namespace EVA;

final class core {
	
	const VERSION = '4.0.0';
	
	private static $pluginManager;
	
	private static $module;
	
	private static $moduleName;
	
	private static $output;
	
	private static $pmToken;
	
	public static function boot() {
	
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		
		dbFactory::boot();
		settings::boot();
		nativeLanguageSupport::boot();
		
		self::$pmToken = rand();
		self::$pluginManager = new pluginManager(self::$pmToken);
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_FIRST
		
		self::loadModule();
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_CONTENTS
		
		self::$module->prepare();
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_OUTPUT
		
		self::$output = self::$module->getOutput();
				
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_LAST
		
		self::shutdown();
	}
	
	private static function loadModule() {
		$m = explode('/', $_SERVER['REQUEST_URI']);
		self::$moduleName = $m[1];
		
		if(class_exists(self::$moduleName)) {
			self::$module = new self::$moduleName();
		}
		elseif(class_exists('EVA\\'.self::$moduleName)) { //this is crucial for namespace compatiblity
			self::$moduleName = 'EVA\\'.self::$moduleName;
			self::$module = new self::$moduleName();
		}
		else {
			self::$module = new page();
		}
	}
	
	public static function getModule() {
		return self::$module;
	}
	
	public static function getModuleName() {
		return self::$moduleName;
	}
	
	public static function getOutput() {
		return self::$output;
	}
	
	public static function setOutput($string) {
		self::$output = $string;
	}
	
	private static function shutdown() {
		header('Content-Length: ' . strlen(self::$output));
		header('Vary: Accept-Encoding');
		echo self::$output;
	}
	
}

?>