<?php

namespace EVA;

class page implements iModules {
	
	private $id;
	private $title;
	private $description;
	private $contents;
	private $output;
	
	public function __construct() {
		$db = dbFactory::buildDefaultDB();
		$this->detectID();
		if($p = $db->query('SELECT * FROM `pages` WHERE `id` = ' . $this->id)
			and $p->num_rows != 0) {
			$r = $db->fetchResults();
			$this->title = $r['title'];
			$this->description = $r['description'];
			$this->contents = $r['contents'];
		}
		else {
			$this->title = 'Page 404';
			$this->description = 'Page not Found';
			$this->contents = 'The page you were looking for was not found';
		}
	}
	
	private function detectID() {
		$cpn = array('/index.php', '/index.html', '/index.htm', '/index.shtml');
		$id = str_ireplace($cpn, '', $_SERVER['REQUEST_URI']);
		$id = trim($id, '/');
		$id = explode('/', $id);
		$id = array_pop($id);
		if(!ctype_digit($id)) {
			$id = 1;
		}
		else {
			$this->id = $id;
		}
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription($description) {
		$this->description = $description;
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