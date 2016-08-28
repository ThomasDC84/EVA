<?php

namespace EVA;

class templateHTML implements iTemplate {
	
	private $title;
	private $description;
	private $contents;
	private $sidebars;
	
	private $output;
	
	public function __construct() {
		$this->output = file_get_contents(__EVA_HOME__ . '/modules/pages/template.htm');
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function setContents($contents) {
		$this->contents = $contents;		
	}
	
	public function addSidebar($sidebar, $sidebarID) {
		//nothing here for the moment
	}
	
	public function getOutput() {
		$this->output = str_replace(
		array('%{title}%', '%{descritpion}%', '%{contents}%'),
		array($this->title, $this->description, $this->contents),
		$this->output
		);
		return $this->output;
	}
}

?>