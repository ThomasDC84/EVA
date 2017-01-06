<?php

namespace EVA;

interface iWidget
{
    public function getTitle();
    public function getContents();
	public function putInTemplate();
}

?>