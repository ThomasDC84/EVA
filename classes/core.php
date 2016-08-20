<?php

namespace EVA;

class core {
	
	const VERSION = '4.0.0';
	
	private $_settings;
	
	private $_pluginManager;
	private $_pmToken;
	
	public function __construct() {
		$this->_pmToken = rand();
		$this->_pluginManager = new pluginManager($this->_pmToken);
		$this->_pluginManager->attach(new pluginExample);
		$this->_pluginManager->toggleHook($this->_pmToken);
		$this->_pluginManager->toggleHook($this->_pmToken);
		$this->_pluginManager->toggleHook($this->_pmToken);
		$this->_pluginManager->toggleHook(98345938);
		$this->_pluginManager->toggleHook($this->_pmToken);
		
		$_settings = new settings;
		
		echo 'La lingua rilevata dal sistema &egrave;: ' .$_settings->getLanguage(); 
	}
	
}

?>