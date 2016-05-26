<?php
  /*
   * Define Custom Routes
   */
  $router = new Phalcon\Mvc\Router(false);

  /*
   * index page
   */ 
  $router->add('/',[
      'controller' => 'Index',
      'action'     => 'Index'
  ])->setName('/');

  /*
   * login page
   * @request method $_GET
   */
 $router->addGet('/login',[
   'controller' => 'Auth',
   'action'     => 'getlogin'
 ])->setName('get-login');


 /*
   * login page
   * @request method $_POST
   */
 $router->addPost('/login',[
   'controller' => 'Auth',
   'action'     => 'postlogin'
 ])->setName('post-login');
?>