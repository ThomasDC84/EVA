<?php

namespace EVA;

class examplePlugin implements \SplObserver {
	
    public function update(\SplSubject $pluginManager) {
		switch($pluginManager->getHook()) {
			case 1: if(!ob_get_contents()) ob_start(); //module not available
				break;
			case 2: core::getModule()->setContents(
				core::getModule()->getContents().
				'<br/>'.
				'i contenuti sono pronti<br/>'.
				'<pre>'.
				settings::getCharset()."\n".
				settings::getLanguage()."\n".
				settings::getEncoding()."\n".
				settings::setCookie('fagor!', 'ebbon ebbon!')."\n".
				settings::getCookie('fagor!').
				'</pre>');
				break;
			case 3: /*module modifications does not take any affects, but output does*/
				if(empty(ob_get_contents()) and settings::getEncoding() == 'gzip') {
					header("Content-Encoding: gzip");
					core::setOutput(gzencode(core::getOutput(), 9));
				}
				else {
					ob_end_flush();
				};
				break;
			default: ;
		}
    }
}

?>