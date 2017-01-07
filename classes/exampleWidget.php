<?php

namespace EVA;

class exampleWidget implements iWidget {
	
	private $title;
	private $contents;
	private $putInTemplate;
	
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
	
	public function setPutInTemplate($bool) {
		if($bool == true) {
			$this->putInTemplate  = true;
		}
		else {
			$this->putInTemplate  = false;
		}
	}
	
	public function putInTemplate() {
		return $this->putInTemplate;
	}

}

?>