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

class Install_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$stepsList = array(
    			"Choose language",
    			"Verify requirements",
    			"Set up database",
    			"Install system",
    			"Configure enviroment",
    			"Summary"
    			);

    	$this->view->currentStep = 0;
    	$this->view->stepsList = $stepsList;
    }
}

