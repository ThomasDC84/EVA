<?php

namespace EVA;

final class core {
	
	const VERSION = '4.0.0';
	
	protected static $_pluginManager;
	private static $_pmToken;
	
	public static function boot() {
		settings::start();
		self::$_pmToken = rand();
		if( !isset(self::$_pluginManager) ) {
			self::$_pluginManager = new pluginManager(self::$_pmToken);
		}
		self::$_pluginManager->attach(new pluginExample);
		self::$_pluginManager->toggleHook(self::$_pmToken);
		self::$_pluginManager->toggleHook(self::$_pmToken);
		self::$_pluginManager->toggleHook(self::$_pmToken);
		self::$_pluginManager->toggleHook(98345938);
		self::$_pluginManager->toggleHook(self::$_pmToken);
	}
	
}

?>