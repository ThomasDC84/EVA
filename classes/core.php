<?php

/**

    This file is part of PROTEUS PHP Web Engine.

    PROTEUS PHP Web Engine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    PROTEUS PHP Web Engine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with PROTEUS PHP Web Engine.  If not, see <http://www.gnu.org/licenses/>.
    
**/

namespace PROTEUS;

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
		
		urlParser::__Init();
		
		$dbFactory = new dbFactory();
		
		//Plugin Manager will use default DB here
		self::$pmToken = rand();
		self::$pluginManager = new pluginManager(self::$pmToken, $dbFactory->buildDataBase(__PROTEUS_DEFAULT_DATABASE_FORMAT__));
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_FIRST
		
		self::loadModule();
		
		if(self::$module instanceOf iSupportDataBase) {
			
			self::$module->setDataBase($dbFactory->buildDataBase(self::$module->getDataBaseFormat()));
			
			if(self::$module instanceOf iSupportUser) {
				
				$userLog = new userLog(self::$module->getDataBase(), self::$module->getUserDomain());
				
				self::$module->setUser($userLog->in());
				
			}
			
			if(self::$module instanceOf iSupportSettings) {
				
				$settings = new settings(self::$module->getDataBase());
				self::$module->setSettingsManager($settings);
				
				if(self::$module instanceOf iSupportInternationalization) {
					$nativeLanguageSupport = new nativeLanguageSupport(self::$module);
					$settings->setLanguage($nativeLanguageSupport->getLanguage());
				}
			}
			
		}
		
		if(self::$module instanceOf iSupportTemplate) {
			$template = templateFactory::buildTemplate(self::$module->getTemplateFormat(), self::$module);
			self::$module->setTemplate($template);
		}
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_CONTENTS
		
		self::$module->prepare();
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_OUTPUT
		
		if(self::$module instanceOf iSupportTemplate) {
			$template->setTitle(self::$module->getTitle());
			$template->setDescription(self::$module->getDescription());
			$template->setContents(self::$module->getContents());
			self::$output = $template->getOutput(); //elaborate output from template and module
		}
		else {
			self::$output = self::$module->getOutput(); //output comes from the module
		}
		
		self::$pluginManager->toggleHook(self::$pmToken); //HOOK_LAST
		
		self::shutdown();
	}
	
	private static function loadModule() {
		self::$moduleName = urlParser::getPath(0);
		if(class_exists(self::$moduleName)) {
			self::$module = new self::$moduleName();
		}
		elseif(class_exists('PROTEUS\\'.self::$moduleName)) { //this is crucial for namespace compatiblity
			self::$moduleName = 'PROTEUS\\'.self::$moduleName;
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