<?php
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(array(
    'flightDB\Models' => $config->application->modelsDir,
    'flightDB\Controllers' => $config->application->controllersDir,
    'flightDB\Forms' => $config->application->formsDir,
    'flightDB' => $config->application->libraryDir
));

$loader->register();

// Use composer autoloader to load vendor classes
require_once __DIR__ . '/../../vendor/autoload.php';
