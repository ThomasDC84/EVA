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

class showcase {

	private $parentModule;
	
	public function __construct($adminModule) {
		$this->parentModule = $adminModule;
		$this->defaultMenu();
	}
	
	private function defaultMenu() {
		$this->parentModule->setContents(get_template('showcase', __PROTEUS_HOME__ . '/modules/admin/templates/showcase.htm'));
	}
}

?>
