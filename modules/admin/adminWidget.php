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

class adminWidget implements iWidget {

	public function __construct($adminModule) {
		$database = $adminModule->getDataBase();
		$language = $adminModule->getSettingsManager()->getLanguage();
		$this->title = gettext('Admin Widget');
		$this->description = gettext('Widget that shows a menu option in the administration area');
		$this->contents = '<div id="menu12">
			  <ul>' . PHP_EOL;
		$this->contents .= '<li><div class="bt1"><span class="ht11">&raquo;&nbsp;</span>
			    <span class="hw12">' . gettext('General') . '</span></div></li>
			    <li><a href="/admin/index.php">' . gettext('Showcase') . '</a></li>
			    <li><a href="/admin/index.php?options=statistics">' . gettext('Statistics') .' </a></li>
			    <li><a href="/admin/index.php?options=database">' . gettext('Data Base') . '</a></li>
			    <li><a href="/admin/index.php?options=internationalization">' . gettext('Internationalization') . '</a></li>
			    <li><a href="/admin/index.php?options=users">' . gettext('Users') . '</a></li>';
		
		/** Modules Section BEGIN **/
		$this->contents .= '<li><div class="bt1"><span class="ht11">&raquo;&nbsp;</span>
			    <span class="hw12">Moduli</span></div></li>';
		$database->query('SELECT * FROM `modules` ');
		while($module = $database->fetchResults()) {
			$info = null;
			$name = $module['name'];
			$description = $module['description'];
			$ini_file = __PROTEUS_HOME__ . '/modules/' . $module['name'] . '/module.ini';
			if(file_exists($ini_file)) {
				$info = parse_ini_file($ini_file, true);
				if(isset($info[$language]['name'])) {
					$name = $info[$language]['name'];
				}
				if(isset($info[$language]['description'])) {
					$description = $info[$language]['description'];
				}
			}
			$this->contents .= '<li><a title="' . $description . '" href="/admin/index.php?options=module&module=' . $module['name'] . '">' . $name . '</a></li>' . PHP_EOL;
		}
		/** Modules Section END**/
		
		/** Plugins Section BEGIN **/
		$this->contents .= '
			    <li><div class="bt1"><span class="ht11">&raquo;&nbsp;</span>
			    <span class="hw12">Accessori</span></div></li>';
		$database->query('SELECT * FROM `plugins` ');
		while($plugin = $database->fetchResults()) {
			$info = null;
			$name = $plugin['name'];
			$description = $plugin['description'];
			$ini_file = __PROTEUS_HOME__ . '/plugins/' . str_replace('PROTEUS\\', '',$plugin['name']) . '/plugin.ini';
			if(file_exists($ini_file)) {
				$info = parse_ini_file($ini_file, true);
				if(isset($info[$language]['name'])) {
					$name = $info[$language]['name'];
				}
				if(isset($info[$language]['description'])) {
					$description = $info[$language]['description'];
				}
			}
			$this->contents .= '<li><a title="' . $description . '" href="/admin/index.php?options=plugin&plugin=' . str_replace('PROTEUS\\', '',$plugin['name']) . '">' . $name . '</a></li>' . PHP_EOL;
		}
		$this->contents .= '<li><div class="bt1"><span class="ht11">&raquo;&nbsp;</span>
			    <span class="hw12">' . gettext('Help') . '</span></div></li>
			    <li><a href="/admin/index.php?options=help">' . gettext('Guide') . '</a></li>
			    <li><a href="/admin/index.php?options=info">' . gettext('Info') . '</a></li>';
		$this->contents .= '
			  </ul>
			</div>';
		/** Plugins Section END**/
	}

	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getContents() {
		return $this->contents;
	}
	
	public function setContents() {
		$this->contents = $contents;
	}
	
	public function useTemplate() {
		return true;
	}

}