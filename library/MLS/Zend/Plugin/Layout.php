<!-- 

Copyright (C) 2011 MassiveLogicSystem Development Team

This file is part of MLS PHP Library.

MLS PHP Library is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

MLS PHP Library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with MLS PHP Library.  If not, see <http://www.gnu.org/licenses/>.

-->


<?php

class MLS_Zend_Plugin_Layout extends Zend_Controller_plugin_Abstract{

	public function preDispatch(Zend_Controller_Request_Abstract $request){

		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOptions();
		$moduleName = $request->getModuleName();

		if (isset($config[$moduleName]['resources']['layout']['layout'])) {

			$layoutScript = $config[$moduleName]['resources']['layout']['layout'];
			Zend_Layout::getMvcInstance()->setLayout($layoutScript);
		}

		if (isset($config[$moduleName]['resources']['layout']['layoutPath'])) {

			$layoutPath = $config[$moduleName]['resources']['layout']['layoutPath'];
			$moduleDir = Zend_Controller_Front::getInstance()->getModuleDirectory();

			Zend_Layout::getMvcInstance()->setLayoutPath($layoutPath);
		}
	}
}