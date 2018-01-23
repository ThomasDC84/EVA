<?php

/**

    This file is part of PROTEUS PHP Web Engine.

    PROTEUS PHP Web Engine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    PROTEUS PHP Web Engine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with PROTEUS PHP Web Engine.  If not, see <http://www.gnu.org/licenses/>.
    
**/

namespace PROTEUS;

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
		$filename = __PROTEUS_HOME__ . '/reports/report-' . date('Y-m-d\TH.i.s') . '.log';
		touch($filename);
		if (is_writable($filename)) {
			if (!$handle = fopen($filename, 'a')) {
				echo "Cannot open file ($filename)";
				exit;
			}
			if (fwrite($handle, $this->contents . '#### Report closed at ' . date(DATE_ATOM) . ' #### ' .  "\n") === FALSE) {
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