<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Mvc\Router;
/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();


/*
 * Routes
 */
$di->set('router',function(){
   include_once __DIR__.'/routes.php';

   return $router;
},true);

/*
 * HTML Lib
 */
$di->set('html',function() use ($di){
   $html = new \Libs\HTML($di);
   
   return $html;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);
   
    //    $view->registerEngines(array(
    //     '.volt' => function ($view, $di) use ($config) {

    //         $volt = new VoltEngine($view, $di);

    //         $volt->setOptions(array(
    //             'compiledPath' => $config->application->cacheDir,
    //             'compiledSeparator' => '_'
    //         ));

    //         return $volt;
    //     },
    //     '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    // ));

     return $view;

});


/*
 * Setup Blade Engine
 */

$di->set('blade',function() use ($config){
    $paths = [
        $config->application->viewsDir
    ];
    

    $renderer = new \Libs\Blade($paths,[
       'cache_path' => $config->application->cacheDir
    ]);

    return $renderer;
});


/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($config) {
    $dbConfig = $config->database->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

    return new $class($dbConfig);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash(array(
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ));
});


$di->set('config',function() use ($config){
    return $config;
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});


/*
 * Auth 
 */

$di->set('auth',function(){
   $auth = new \Libs\Auth();

   return $auth;
},true);