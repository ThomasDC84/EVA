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
			if($widget->useTemplate() == false) {
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