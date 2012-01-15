<?php

class Install_Bootstrap extends Zend_Application_Module_Bootstrap
{
	// Configuration view to Install Module
	protected function _initConfigureView()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		
		$view->enviroment_theme_install 	= Constant::enviroment_theme_install;
	}
}