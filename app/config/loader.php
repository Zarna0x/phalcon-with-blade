<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->facadeDir
    )
)->register();


/*
 * Register Namespaces
 */
$loader->registerNamespaces([
   "Libs" => $config->application->libs
]);

$loader->register();