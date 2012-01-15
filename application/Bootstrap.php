<!-- 

Copyright (C) 2011 MassiveLogicSystem Development Team

This file is part of Aylin.

Aylin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Aylin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Aylin.  If not, see <http://www.gnu.org/licenses/>.

-->

<?php

require_once 'models/common/Constant.php';

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	// We also want to ensure we have an XHTML DocType declaration for our application
	protected function _initConfigureView()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');

		$view->headTitle(Constant::application_name . ' ' . Constant::application_type);

		// View data.
		$view->application_name 	= Constant::application_name;
		$view->application_type 	= Constant::application_type;
		$view->application_version 	= Constant::application_version;
		$view->application_date 	= Constant::application_date;
	}

	// We also want to ensure we have an XHTML DocType declaration for our application
	protected function _initSetEnviroment()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');

		// Theme.
		$view->enviroment_theme 	= Constant::enviroment_theme;
	}

	// Load plugins.
	protected function _initPlugins(){
		$this->bootstrap('frontController');

		$plugin = new MLS_Zend_Plugin_Layout();
		$this->frontController->registerPlugin($plugin);
	}

	/**
	 *
	 * Load de translate's adapter.
	 */
	protected function _initTranslateAdapter() {
		
		Zend_Loader::loadClass('Zend_Translate');
		Zend_Loader::loadClass('Zend_Registry');
		//$translate = new Zend_Translate('gettext', '../application/languages/es_ES.mo');

		$translate = new Zend_Translate(
			array(
		        'adapter' => 'gettext',
		        'content' => '../application/languages/en_US.mo',
				'locale'  => 'en'
	        )
        );
        
		$translate->addTranslation(
		    array(
		    	'adapter' => 'gettext',
		        'content' => '../application/languages/es_ES.mo',
		        'locale'  => 'es'
		    )
		);
			
		$translate->setLocale('es');
         
        // Save Zend_Translate object to the registry so we don't need to create our object over and over again in our application.
        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Translate', $translate);
	}
}

