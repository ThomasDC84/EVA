<?php

/**

    This file is part of PROTEUS PHP Web Engine.

    PROTEUS PHP Web Engine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    PROTEUS PHP Web Engine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with PROTEUS PHP Web Engine.  If not, see <http://www.gnu.org/licenses/>.
    
**/

namespace PROTEUS;

class templateHTML implements iTemplate {
	
	private $title;
	private $description;
	private $contents;
	private $module;
	private $sidebars;
	private $output;
	
	public function __construct($module) {
		$this->module = $module;
		$this->output = file_get_contents($module->getTemplateParameter());
	}
	
	public function setTemplate($templateParameter) {
		$this->output = file_get_contents($templateParameter);
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function setContents($contents) {
		$this->contents = $contents;		
	}
	
	public function addLink($rel, $type, $href) {
		$this->replace('</head>', '<link rel="' . $rel . '" type="' . $type . '" href="' . $href . '" />' . "\n	</head>");
	}
	
	public function addMeta($name, $content) {
		$this->replace('</head>',
		'<meta name="' . $name . '" content="' . $content . '" />' . "\n	</head>");
	}
	
	public function addStyleSheet($styleSheetUrl) {
		$this->addLink('stylesheet', 'text/css', $styleSheetUrl);
	}
	
	public function addScript($scriptUrl) {
		$this->replace('</head>',
		'<script src="' . $scriptUrl . '" type="text/javascript"></script>' . "\n	</head>");
	}
	
	public function replace($subject, $replacement) {
		$this->output = str_replace($subject, $replacement, $this->output);
	}
	
	public function getOutput() {
		$this->output = str_replace(array('%{title}%', '%{descritpion}%', '%{contents}%', '%{PROTEUS_URL}%'),
									array($this->title, $this->description, $this->contents, $this->module->getBaseURL()),
									$this->output);
		if(sidebarManager::getNumberOfSidebars() > 0) {
			foreach(sidebarManager::getSidebars() as $sidebar) {
				$this->output = str_replace('%{' . $sidebar->getName() . '}%',
											$sidebar->getContents(),
											$this->output);
			}
		}
		return $this->output;
	}
}

?>