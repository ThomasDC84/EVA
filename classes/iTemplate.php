<?php

namespace EVA;

interface iTemplate {
	
	public function setTitle($title);
	
	public function setDescription($description);
	
	public function setContents($contents);
	
	public function addSidebar($sidebar, $sidebarID);
	
	public function getOutput();
	
}

?>