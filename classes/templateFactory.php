<?php

namespace EVA;

class templateFactory {
	public static function buildTemplate($templateType) {
		return new templateHTML();
	}
	
	public static function buildDefaultTemplate() {
		return new templateHTML();		
	}
	
}

?>