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

define('FIRST_HOOK', 1);
define('FEATURES_LOADED_HOOK', 2);
define('CONTENTS_HOOK', 3);
define('LAST_HOOK', 4);

class pluginManager implements \SplSubject {
	private $_plugins;
	private $_hook = 0;
	private $_token;

	public function __construct($token, $db) {
		$this->_token = $token;
		$this->_plugins = new \SplObjectStorage();
		//load plugins list, require db
		$plugins = array();
		if($db->query('SELECT * FROM `plugins`') and
			$db->getNumberOfRows() != 0) {
			while($plugin = $db->fetchResults()) {
				if($plugin['enabled'] == 1) {
					if(class_exists($plugin['name'])) {
						$this->attach(new $plugin['name']());
					}
					else {
						report('plugin', 'plugin class not found: ' . $plugin['name']);
					}
				}	
			}
		}
	}

	public function attach(\SplObserver $plugin) {
	    $this->_plugins->attach($plugin);
	}

	public function detach(\SplObserver $plugin) {
	    $this->_plugins->detach($plugin);
	}

	public function notify() {
	    foreach ($this->_plugins as $plugin) {
		$plugin->update($this);
	    }
	}
	    
	public function toggleHook($authToken) {
		if($authToken === $this->_token) {
			$this->_hook++;
			$this->notify();
		}
		else {
			report('Plug-in Manager Anomaly', '$authToken different from $this->_token', 'RED ALERT');
		}
	}

	public function getHook() {
	    return $this->_hook;
	}
}

?>