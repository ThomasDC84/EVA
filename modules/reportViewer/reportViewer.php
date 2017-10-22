<?php

namespace EVA;

include __EVA_HOME__ . '/modules/reportViewer/reportListWidget.php';

class reportViewer implements iModules {
	
	private $id;
	private $title;
	private $description;
	private $contents;
	private $output;
	
	public function __construct() {
		
		$user = logUser::login();
		if(!$user) {
			$this->title = gettext('System Report Viewer');
			$this->description = gettext('System Report Viewer');
			$this->contents = gettext('Access Denied') . '. ' . 
				gettext('Please authenticate yourself in the') . ' <a href="/ulm/index.php?referer=/reportViewer/index.php">' .
				gettext('authentication page') . '</a>.';
		}
		else {
			$domain = 'reportViewer';

			bindtextdomain($domain, __EVA_HOME__ . '/locale');

			textdomain($domain);
			
			$db = dbFactory::buildDefaultDB();
			$this->title = gettext('System Report Viewer');
			$this->description = gettext('System Report Viewer');
			$this->contents = '<p>' . gettext('No report selected to show') . '</p>';
			$this->readLog();
			$this->deleteLogs();
		}
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
		
		if(logUser::login() == false) {
			$template->setTemplate(__EVA_HOME__ . '/modules/reportViewer/accessDenied.htm');
		}
		else {
			$template->setTemplate(__EVA_HOME__ . '/modules/reportViewer/template.htm');
				
			$reportListWidget = new reportListWidget();
			
			$rightSidebar = new sidebar('rightSideBar');
			
			$rightSidebar->addWidget($reportListWidget, 1);
			$userWidget = new exampleWidget('user', gettext('Logged as: ') . logUser::login()->getUserName() . ' ');
			$userWidget->setPutInTemplate(false);
			
			
			$footerSidebar = new sidebar('footerSideBar');
			
			$footerSidebar->addWidget($userWidget, 1);
			
			sidebarManager::addSidebar($rightSidebar);
			sidebarManager::addSidebar($footerSidebar);
		}
		
		$template->setTitle($this->title);
		$template->setDescription($this->description);
		$template->setContents($this->contents);
		
		$this->output = $template->getOutput();		
	}
	
	public function getOutput() {
		return $this->output;
	}

}

?>