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

class admin implements iModules {

	private $title;
	private $description;
	private $contents;
	private $output;
	
	private $settings;
	private $nls;
	private $db;
	
	public function __construct() {
		$this->title = gettext('Admin Area');
		$this->description = gettext('Default administration area of EVA Engine');
		$this->contents = 'TEST';
		$this->output = '';
		$this->db = dbFactory::buildDefaultDB();
		$userLog = new userLog($this->db, 'EVA');
		$this->user = $userLog->in();
		if(!$this->user) {
			$this->contents .= ' OK';
		}
		else {
			$this->contents .= ' KO';
		}
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) { }
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription($description) { }
	
	public function getContents() {
		return $this->contents;
	}
	
	public function setContents($contents) { }
	
	public function prepare() {
		$this->output = $this->contents;
	}
	
	public function getOutput() {
		return $this->output;
	}
	
	public function enableSM() {
		return true;
	}
	
	public function getSM() {
		return $this->settings;
	}
	
	public function setSM($settings) {
		$this->settings = $settings;
	}
	
	public function enableNLS() {
		return true;
	}
	
	public function setNLS($nls) {
		$this->nls = $nls;
	}
	
	public function getBaseURL() {
		return '/admin';
	}
	
	public function getDB() {
		return $this->db;
	}
	
}

?>
