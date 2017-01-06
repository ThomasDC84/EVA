<?php

namespace EVA;

include __EVA_HOME__ . '/modules/reportViewer/reportListWidget.php';

class page implements iModules {
	
	private $id;
	private $title;
	private $description;
	private $contents;
	private $output;
	
	public function __construct() {
		
		$locale = 'it_IT';
		if (isSet($_GET["locale"])) $locale = $_GET["locale"];

		$domain = 'reportViewer';

		$results = putenv("LC_ALL=$locale");
		if (!$results) {
			exit ('putenv failed');
		}

		$results = setlocale(LC_ALL, $locale, 'italian');
		if (!$results) {
			exit ('setlocale failed: locale function is not available on this platform, or the given local does not exist in this environment');
		}

		bindtextdomain($domain, __EVA_HOME__ . '/locale');

		textdomain($domain);
		
		$db = dbFactory::buildDefaultDB();
		$this->title = gettext('System Report Viewer');
		$this->description = gettext('System Report Viewer');
		$this->contents = '<p>' . gettext('No report selected to show') . '</p>';
		$this->readLog();
		$this->deleteLogs();
	}
	
	private function readLog() {
		//read Log if any
		if(isset($_GET['readLog'])) {
			if(file_exists(__EVA_HOME__ . '/reports/' . $_GET['readLog'])) {
				$reportFileName = $_GET['readLog'];
				$report = file_get_contents(__EVA_HOME__ . '/reports/' . $_GET['readLog']);
				$this->contents = '<div style="padding: 10px;"><h1>' . $reportFileName . '</h1><hr/><br/><pre>' . $report . '</pre></div>';
			}
		}
	}
	
	private function deleteLogs() {
		//delete logs if any
		if(isset($_POST['report'])) {
			if(!is_array($_POST['report'])) {
				if(file_exists(__EVA_HOME__ . '/reports/' . $_POST['report'])) {
					unlink($_POST['report']);
				}
			}
			else {
				foreach($_POST['report'] as $report) {
					if(file_exists(__EVA_HOME__ . '/reports/' . $report)) {
						unlink(__EVA_HOME__ . '/reports/' . $report);
					}
				}
			}
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
		$template->setTemplate(__EVA_HOME__ . '/modules/reportViewer/template.htm');
		$template->setTitle($this->title);
		$template->setDescription($this->description);
		$template->setContents($this->contents);
				
		$reportListWidget = new reportListWidget();
		
		$sidebar = new sidebar('rightSideBar');
		
		$sidebar->addWidget($reportListWidget, 1);
		
		sidebarManager::addSidebar($sidebar);
		
		$this->output = $template->getOutput();		
	}
	
	public function getOutput() {
		return $this->output;
	}

}

?>