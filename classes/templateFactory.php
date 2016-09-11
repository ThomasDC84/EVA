<?php

namespace EVA;

class templateFactory {
	public static function buildTemplate($templateType) {
		$template = false;
		if(class_exists('EVA\template'.$templateType, true)) {
			$templateClass = 'EVA\template' . $templateType;
			$template = new $templateClass();
		}
		return $template;
	}
	
	public static function buildDefaultTemplate() {
		return new templateHTML();		
	}
	
}

?>