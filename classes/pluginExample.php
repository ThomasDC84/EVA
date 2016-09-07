<?php

namespace EVA;

class pluginExample implements \SplObserver {
	
    public function update(\SplSubject $pluginManager) {
		switch($pluginManager->getHook()) {
			case 1: /*module not available*/; break;
			case 2: core::getModule()->setContents(
				core::getModule()->getContents().
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
				if(settings::getEncoding() == 'gzip') {
					//header("Content-Encoding: gzip");
					//core::setOutput(gzencode(core::getOutput(), 9));
					};
				break;
			default: ;
		}
    }
}

?>