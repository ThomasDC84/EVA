<?php

namespace EVA;

class templateHTML implements iTemplate {
	
	private $title;
	private $description;
	private $contents;
	private $sidebars;
	
	private $output;
	
	public function __construct() {
		$this->output = '';
	}
	
	public function setTemplate($template) {
		$this->output = file_get_contents($template);
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
	
	public function getOutput() {
		$this->output = str_replace(array('%{title}%', '%{descritpion}%', '%{contents}%'),
									array($this->title, $this->description, $this->contents),
									$this->output);
		if(sidebarManager::getNumberOfSidebars() > 0) {
			foreach(sidebarManager::getSidebars() as $sidebar) {
				$this->output = str_replace('%{' . $sidebar->getName() . '}%',
											$sidebar->getContents(),
											$this->output);
			}
		}
		return $this->output;
	}
}

?>