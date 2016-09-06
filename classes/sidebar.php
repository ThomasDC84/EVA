<?php

namespace EVA;

class sidebar {
	
	private $name;
	private $widgets;
	
	public function __construct($name) {
		$this->name = $name;
	}
	
	public function addWidget($index, $widget) {
		$retVal = false;
		if($widget instanceof iWidget) {
			$widgets[$index] = $widget;
			$retVal = true;
		}
		return $retVal;
	}
	
	public function getWidget($index) {
		$retVal = false;
		if(isset($sidebars[$sidebarID])) {
			$retVal = $this->widgets[$index];
		}
		return $retVal;
	}
	
	public function removeWidget($index) {
		$retVal = false;
		if(isset($sidebars[$sidebarID])) {
			unset($this->widgets[$index]);
			$retVal = true;
		}
		return $retVal;
	}
}

?>