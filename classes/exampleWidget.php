<?php

namespace EVA;

class exampleWidget implements iWidget {
	
	public function __construct($title = '', $contents = '') {
		$this->title = $title;
		$this->contents = $contents;
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
	
	public function putInTemplate() {
		return true;
	}

}

?>