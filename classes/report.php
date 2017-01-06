<?php

namespace EVA;

class report {
	
	private $id;
	
	private $contents;

	public function __construct($id) {
		$this->id = $id;
		$this->contents = '#### Report ID: ' . $this->id . ' | started at ' . date(DATE_ATOM) . "####\n\n";
	}
	
	public function addContents($errorLevel, $contents) {
		$this->contents .= '######## New entry at ' . date(DATE_ATOM) . " with error level: $errorLevel ########\n\n" . $contents . "\n\n";
	}
	
	public function __destruct() {
		$filename = __EVA_HOME__ . '/reports/report-' . date('Y-m-d\TH.i.s') . '.log';
		touch($filename);
		if (is_writable($filename)) {
			if (!$handle = fopen($filename, 'a')) {
				echo "Cannot open file ($filename)";
				exit;
			}
			if (fwrite($handle, $this->contents . '#### Report closed at ' . date(DATE_ATOM) . ' #### ' .  "\n" . $errorMessage) === FALSE) {
				echo "Cannot write to file ($filename)";
				exit;
			}
			fclose($handle);
		}
		else {
			echo "The file $filename is not writable";
		}
	}

}

?>