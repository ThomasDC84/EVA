<?php

/**

    This file is part of EVA PHP Web Engine.

    EVA PHP Web Engine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    EVA PHP Web Engine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with EVA PHP Web Engine.  If not, see <http://www.gnu.org/licenses/>.
    
**/

namespace EVA;

class dummyWidget implements iWidget {
	
	private $title;
	private $contents;
	private $useTemplate;
	
	public function __construct($title = '', $contents = '') {
		$this->title = $title;
		$this->contents = $contents;
		$this->putInTemplate = true;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getContents() {
		return $this->contents;
	}
	
	public function setContents() {
		$this->contents = $contents;
	}
	
	public function useTemplate() {
		return $this->useTemplate;
	}
	
	public function setUseTemplate($bool) {
		if($bool == true) {
			$this->useTemplate  = true;
		}
		else {
			$this->useTemplate  = false;
		}
	}

}

?>