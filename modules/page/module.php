<?php

namespace EVA;

class page implements iModules {
	
	private $title;
	private $description;
	private $contents;
	private $output;
	
	public function __construct() {
		$db = dbFactory::buildDefaultDB();
		$db->query("SELECT * FROM `pages` WHERE `id` = 1 ");
		$r = $db->fetchResults();
		$this->title = $r['title'];
		$this->description = $r['description'];
		$this->contents = $r['contents'];
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		//do nothing
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription($description) {
		//do nothing
	}

	public function getContents() {
		return $this->contents;
	}
	
	public function setContents($contents) {
		$this->contents = $contents;
	}
	
	public function prepare() {
		$template = templateFactory::buildTemplate('HTML');				
		$template->setTitle($this->title);
		$template->setDescription($this->description);
		$template->setContents($this->contents);
				
		$testWidget = new exampleWidget('Test', 'Hello World!');
		
		$sidebar = new sidebar('leftSidebar');
		
		$sidebar->addWidget($testWidget, 1);
		
		sidebarManager::addSidebar($sidebar);
		
		$this->output = $template->getOutput();		
	}
	
	public function getOutput() {
		return $this->output;
	}

}

?>