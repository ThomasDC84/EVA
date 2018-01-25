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
	private $entry;
	private $contents;

	public function __construct($id) {
		$this->id = $id;
		$this->entry = 1;
		$this->contents = '#### Report ID: ' . $this->id . ' | started at ' . date(DATE_ATOM) . "####\n\n";
	}
	
	public function addContents($contents, $errorLevel = 0) {
		$this->contents .= '######## Entry number ' . $this->entry . ' at ' . date(DATE_ATOM) . " with error level: $errorLevel ########\n\n" . $contents . "\n\n";
		$this->entry++;
	}
	
	public function __destruct() {
		$filename = __PROTEUS_HOME__ . '/reports/report-' . $this->id . '.log';
		touch($filename);
		if (is_writable($filename)) {
			file_put_contents($filename,
					  $this->contents .
					  '#### Report closed at ' . date(DATE_ATOM) . ' #### ' .
					  PHP_EOL.PHP_EOL);
		}
		else {
			//The file $filename is not writable;
		}
	}

}

?>