<?php

namespace EVA;

class pluginExample implements \SplObserver {
    public function update(\SplSubject $pluginManager) {
		switch($pluginManager->getHook()) {
			case 0: echo 'ci troviamo all\'inizio<br/>'; break;
			case 1: echo 'i contenuti sono pronti<br/>'; break;
			case 2: echo 'la pagina &egrave; pronta!<br/>'; break;
			default: echo 'abbiamo sforato, cavolo!<br/>';
			echo '<pre>';
			var_dump(settings::getCharset());
			var_dump(settings::getLanguage());
			var_dump(settings::getEncoding());
			settings::setCookie('fagor!', 'ebbon ebbon!');
			var_dump(settings::getCookie('fagor!'));
			echo '</pre>';
		}
    }
}

?>