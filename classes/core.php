<?php

namespace EVA;

include_once __EVA_HOME__ . '/modules/pages/page.php';

final class core {
	
	const VERSION = '4.0.0';
	
	protected static $pluginManager;
	
	protected static $module;
	
	protected static $output;
	
	private static $pmToken;
	
	public static function boot() {
		
		settings::boot();
		dbFactory::boot();
		
		self::$pmToken = rand();
		self::$pluginManager = new pluginManager(self::$pmToken);
		self::$pluginManager->attach(new pluginExample);
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_FIRST
		
		self::loadModule();
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_CONTENTS
		
		self::$output = self::$module->getOutput();
				
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_LAST
		
		self::shutdown();
	}
	
	private static function loadModule() {
		self::$module = new page();
	}
	
	public static function &getModule() {
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