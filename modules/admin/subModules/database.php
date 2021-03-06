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

namespace PROTEUS\admin;

class database {

	private $parentModule;
	
	public function __construct($adminModule) {
		$this->parentModule = $adminModule;
		$this->loadContents();
	}
	
	private function loadContents() {
		$contents = '';
		$dbFactory = new \PROTEUS\dbFactory();
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {
			write_php_ini($_POST, $dbFactory->getConfigurationFile());
			$updatemessage = get_template('update', __PROTEUS_HOME__ . '/modules/admin/templates/database.htm');
			$contents .= parse_template('UpdateSuccesfully',
				      gettext('Update Succesfully!'),
				      $updatemessage);
		}
		$configurationFile = $dbFactory->getConfigurationFile();
		$configuration = parse_ini_file($configurationFile, true);
		$template = get_template('settings', __PROTEUS_HOME__ . '/modules/admin/templates/database.htm');
		$contents .= parse_template(
			array(
			'Database Settings',
			'defaultDatabaseLabel',
			'MySQLhost',
			'MySQLhostLabel',
			'MySQLusername',
			'MySQLusernameLabel',
			'MySQLpassword',
			'MySQLpasswordLabel',
			'MySQLdbname',
			'MySQLdbnameLabel',
			'MySQLport',
			'MySQLportLabel',
			'MySQLsocket',
			'MySQLsocketLabel',
			'SQLite3DBName',
			'SQLite3DBNameLabel',
			'Update',
			'Reset'),
			
			array(
			gettext('Database Settings'),
			gettext('Default Database'),
			$configuration['MySQL']['host'],
			gettext('MySQL Host'),
			$configuration['MySQL']['username'],
			gettext('MySQL User Name'),
			$configuration['MySQL']['password'],
			gettext('MySQL Password'),
			$configuration['MySQL']['dbname'],
			gettext('MySQL Database Name'),
			$configuration['MySQL']['port'],
			gettext('MySQL Port'),
			$configuration['MySQL']['socket'],
			gettext('MySQL Socket'),
			$configuration['SQLite3']['dbname'],
			gettext('SQLite3 Database Name'),
			gettext('Update'),
			gettext('Reset')),
			$template);
		$contents = str_replace(
			'value="' . $configuration['General']['defaultDB'] . '"',
			'value="' . $configuration['General']['defaultDB'] . '" selected="selected"',
			$contents);
		$this->parentModule->setContents($contents);
	}
}

?>
