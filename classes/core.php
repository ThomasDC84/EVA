<?php

namespace EVA;

include_once __EVA_HOME__ . '/modules/pages/pages.php';

final class core {
	
	const VERSION = '4.0.0';
	
	protected static $_pluginManager;
	protected static $_module;
	protected static $_output;
	
	private static $_pmToken;
	
	public static function boot() {
		ob_start();
		
		settings::boot();
		dbFactory::boot();
		
		self::$_pmToken = rand();
		self::$_pluginManager = new pluginManager(self::$_pmToken);
		self::$_pluginManager->attach(new pluginExample);
		self::$_pluginManager->toggleHook(self::$_pmToken); //HOOK_FIRST
		
		$template = templateFactory::buildDefaultTemplate();
		$module = new pages(1);
		
		self::$_pluginManager->toggleHook(self::$_pmToken); //HOOK_CONTENTS
				
		$template->setTitle($module->getTitle());
		$template->setDescription($module->getDescription());
		$template->setContents($module->getContents());
		
		echo $template->getOutput();
		
		self::$_pluginManager->toggleHook(self::$_pmToken); //HOOK_LAST
		
		self::shutdown();
	}
	
	private static function loadModule() {
		/*self::$_module = detectModule();
		$template = templateFactory::buildTemplate();
		$template->setContents(self::$_module->getContents());*/
	}
	
	private static function shutdown() {
		ob_end_flush();
	}
	
}

?>