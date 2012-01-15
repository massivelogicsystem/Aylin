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
// scripts/load.mysql.php
 
/**
* Script for creating and loading database
*/
 

echo defined('APPLICATION_PATH') . "\n";

// Initialize the application path and autoloading
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

echo realpath(dirname(__FILE__)) . '/../application' . "\n";
echo "AqUI" . "\n";

set_include_path(implode(PATH_SEPARATOR, array(
    APPLICATION_PATH . '/../library',
    get_include_path(),
)));
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();
 
// Define some CLI options
$getopt = new Zend_Console_Getopt(array(
    'withdata|w' => 'Load database with sample data',
    'env|e-s'    => 'Application environment for which to create database (defaults to development)',
    'help|h'     => 'Help -- usage message',
));
try {
    $getopt->parse();
} catch (Zend_Console_Getopt_Exception $e) {
    // Bad options passed: report usage
    echo $e->getUsageMessage();
    return false;
}
 
// If help requested, report usage message
if ($getopt->getOption('h')) {
    echo $getopt->getUsageMessage();
    return true;
}
 
// Initialize values based on presence or absence of CLI options
$withData = $getopt->getOption('w');
$env      = $getopt->getOption('e');
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (null === $env) ? 'development' : $env);
 
// Initialize Zend_Application
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
 
// Initialize and retrieve DB resource
$bootstrap = $application->getBootstrap();
$bootstrap->bootstrap('db');
$dbAdapter = $bootstrap->getResource('db');
 
// let the user know whats going on (we are actually creating a
// database here)
if ('testing' != APPLICATION_ENV) {
    echo 'Writing Database Guestbook in (control-c to cancel): ' . PHP_EOL;
    for ($x = 5; $x > 0; $x--) {
        echo $x . "\r"; sleep(1);
    }
}
 
// Check to see if we have a database file already
$options = $bootstrap->getOption('resources');
$dbFile  = $options['db']['params']['dbname'];
if (file_exists($dbFile)) {
    unlink($dbFile);
}
 
// this block executes the actual statements that were loaded from
// the schema file.
try {
    $schemaSql = file_get_contents(dirname(__FILE__) . '/schema.mysql.sql');
    // use the connection directly to load sql in batches
    $dbAdapter->getConnection()->exec($schemaSql);
    chmod($dbFile, 0666);
 
    if ('testing' != APPLICATION_ENV) {
        echo PHP_EOL;
        echo 'Database Created';
        echo PHP_EOL;
    }
 
    if ($withData) {
        $dataSql = file_get_contents(dirname(__FILE__) . '/data.mysql.sql');
        // use the connection directly to load sql in batches
        $dbAdapter->getConnection()->exec($dataSql);
        if ('testing' != APPLICATION_ENV) {
            echo 'Data Loaded.';
            echo PHP_EOL;
        }
    }
 
} catch (Exception $e) {
    echo 'AN ERROR HAS OCCURED:' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    return false;
}
 
// generally speaking, this script will be run from the command line
return true;

?>
