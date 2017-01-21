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
	
	public function getSection($sectionName) {
		$section = '';
		$start = '<!--' . $sectionName . '-->';
		$end = '<!--/' . $sectionName . '-->';
		$ini = strpos($this->output, $start);
		if ($ini !== 0) {
			$ini += strlen($start);
			$len = strpos($this->output, $end, $ini) - $ini;
			$section = substr($this->output, $ini, $len);
			$this->output = str_replace(array($start, $end, $section), '', $this->output);
		}
		return $section;
	}
	
	public function getOutput() {
		$this->output = str_replace(array('%{title}%', '%{descritpion}%', '%{contents}%', '%{EVA_URL}%'),
									array($this->title, $this->description, $this->contents, settings::getConf('eva_url')),
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