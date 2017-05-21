<?php

namespace EVA;

class sidebar implements iSidebar {
	
	private $name;
	private $widgets;
	private $contents;
	
	public function __construct($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function addWidget($widget, $index) {
		$retVal = false;
		if($widget instanceof iWidget) {
			$this->widgets[$index] = $widget;
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
	
	public function getContents() {
		foreach($this->widgets as $widget) {
			if($widget->putInTemplate() == true) {
				$this->contents = 
					'<table style="width:100%">
					<tr>
						<th>'.$widget->getTitle().'</th>
					</tr>
					<tr>
						<td style="text-align: center;">'.$widget->getContents().'</td>
					</tr>
					</table>';
			}
			else {
				$this->contents = $widget->getContents();
			}
		}
		return $this->contents;
	}
}

?>