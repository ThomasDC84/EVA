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
		
		$bestType                           = 'en';
        $parsedTypes                        = array();

        $parsedTypes['type'][0]             = 'en';
        $parsedTypes['qFactorUser'][0]      = '1';

        $parsedTypes['type'][1]             = 'it_IT';
        $parsedTypes['qFactorUser'][1]      = '0.3';

        $parsedTypes['type'][2]             = 'it';
        $parsedTypes['qFactorUser'][2]      = '0.2';
		
		echo '<pre>';
		
		echo 'string(5) "it-it"
array(2) {
  ["type"]=>
  array(4) {
    [0]=>
    string(5) "it-it"
    [1]=>
    string(2) "it"
    [2]=>
    string(5) "en-us"
    [3]=>
    string(2) "en"
  }
  ["qFactorUser"]=>
  array(4) {
    [0]=>
    string(1) "1"
    [1]=>
    string(3) "0.8"
    [2]=>
    string(3) "0.5"
    [3]=>
    string(3) "0.3"
  }
}';

echo "\n\n";
		
		var_dump(\conNeg::langBest());
		var_dump(\conNeg::langAll());
		
		 $appPref = 'iso-8859-5;q=0.9,utf-8;q=0.6';
		 var_dump(\conNeg::charBest($appPref));
		 var_dump(\conNeg::charAll());
		
		echo '</pre>';
		
	}
	
	public function getOutput() {
		return $this->output;
	}

}

?>