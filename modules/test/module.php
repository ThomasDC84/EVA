<?php

namespace EVA;

class test implements iModules {
	
	private $title;
	private $description;
	private $contents;
	private $output;
	
	public function __construct() {
		$db = dbFactory::buildDefaultDB();
		/*if($db->query('SELECT * FROM `pages` WHERE `id` = ' . $this->id) and
			$db->getNumberOfRows() != 0) {
			$r = $db->fetchResults();
			$this->title = $r['title'];
			$this->description = $r['description'];
			$this->contents = $r['contents'];
		}*/
		$this->title = 'test';
		$this->description = 'description';
		$this->contents = 'contents';
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
		//nativeLanguageSupport::boot();
		nativeLanguageSupport::setLanguage('it_IT');
		nativeLanguageSupport::addTranslation('reportViewer');
		nativeLanguageSupport::getTranslation('reportViewer');
		
		$this->output = gettext('System Report Viewer');
		$this->output .= '<br>';
		$this->output .= gettext('System Report Viewer');
		$this->output .= '<br>';
		$this->output .= gettext('No report selected to show');
		
	}
	
	public function getOutput() {
		return $this->output;
	}

}

?>