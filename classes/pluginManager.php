<?php

namespace EVA;

class pluginManager implements \SplSubject {
    private $_plugins;
	private $_hook = 0;
	private $_token;

    public function __construct($token) {
        $this->_plugins = new \SplObjectStorage();
		$this->_token = $token;
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