<?php

/**

    This file is part of EVA PHP Web Engine.

    EVA PHP Web Engine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    EVA PHP Web Engine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with EVA PHP Web Engine.  If not, see <http://www.gnu.org/licenses/>.
    
**/

namespace EVA;

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
				if($plugin['enabled'] == 1 and class_exists($plugin['ID'])) {
					$this->attach(new $plugin['ID']());
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
			    /*$authToken different from $this->_token*/;
		    }
	    }

	public function getHook() {
	    return $this->_hook;
	}
}

?>