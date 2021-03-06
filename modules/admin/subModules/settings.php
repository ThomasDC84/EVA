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

class settings {

	private $parentModule;
	
	public function __construct($adminModule) {
		$this->parentModule = $adminModule;
		$this->defaultMenu();
	}
	
	private function defaultMenu() {
		$template = get_template('settings', __PROTEUS_HOME__ . '/modules/admin/templates/settings.htm');
		$contents = parse_template(
		  array('PROTEUS_HOME',
			'PROTEUS_URL',
			'General Settings',
			'Update',
			'Reset'),
		  array(__PROTEUS_HOME__,
			__PROTEUS_URL__,
			gettext('General Settings'),
			gettext('Update'),
			gettext('Reset')),
		  $template);
		$this->parentModule->setTitle($this->parentModule->getTitle() . ' | ' . gettext('General Settings'));
		$this->parentModule->setContents($contents);
	}
}

?>
