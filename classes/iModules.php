<?php

namespace EVA;

interface iModules {
	
	public function getTitle();
	
	public function setTitle($title);
	
	public function getDescription();
		
	public function setDescription($description);
	
	public function getContents();
	
	public function setContents($contents);
	
	public function prepare();
	
	public function getOutput();
	
}

?>