<?php

namespace EVA;

class reportListWidget implements iWidget {
	
	private $files;
	
	public function __construct() {
		$this->listReports();
		$this->title = 'Report List';
		$this->contents = '<form method=\'post\' action=\'index.php?action=deletePosts\'>
					<fieldset>
						<legend style="text-align: center;">' . gettext('Report List:') . '</legend><br/>';
		foreach($this->files as $log) {
			$this->contents .= '<input type="checkbox" name="report[]" id="' . $log . '" value="' . $log . '" />';
			$this->contents .= '<label for="' . $log . '">' . str_replace('.log', '', $log) . '</label> | <a href="index.php?readLog=' . $log . '" />'. gettext('Show') . '</a><br/>';
		}
		$this->contents .= '<br/>
							<input type="checkbox" id="selectAll" onClick="toggle(this)" /><label for="selectAll">' . gettext('Select All') . '</label><br/>
							<p style="text-align: center;">
								<input type="submit" value="'. gettext('Delete Selected') . '" />
								<input type="reset" value="'. gettext('Select None') . '">
							</p>
					</fieldset>
				</form>';
	}
	
	private function listReports() {
		$this->files = array();
		$dir = __EVA_HOME__ . '/reports/';
		$dh  = opendir($dir);
		while (false !== ($file = readdir($dh))) {
			if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'log') {
				$this->files[] = $file;
			}
		}
	}
	
    public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;		
	}
	
    public function getContents() {
		return $this->contents;
	}
	
	public function setContents() {
		$this->contents = $contents;		
	}
	
	public function putInTemplate() {
		return false;
	}

}

?>