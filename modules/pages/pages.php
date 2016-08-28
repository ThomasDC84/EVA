<?php

namespace EVA;

class pages implements iModules {
	
	private $titles;
	private $description;
	private $contents;
	
	public function __construct($pageIndex) {
		$db = dbFactory::buildDefaultDB();
		$r = $db->query("SELECT * FROM `pages` ");
		$this->title = $r['title'];
		$this->description = $r['description'];
		$this->contents = $r['contents'];
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getDescription() {
		return $this->description;
	}

	public function getContents() {
		return $this->contents;
	}

}

?>