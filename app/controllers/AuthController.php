<?php

class AuthController extends ControllerBase
{
    public function getloginAction()
    {
    	View::make('auth.login');
    }

    public function postloginAction()
    {
       if($this->request->isPost())
       {
         $name = $this->request->getPost('name');
         $pass = $this->request->getPost('password');

          if(strlen($name) < 10)
          {
             return $this->response->redirect('');
          }

          if($this->auth->attempt([
              'name' => $name,
              'password' => sha1($pass)
          ]))
          {


          	$this->response->redirect([
                'for' => '/'
          	]);
          }
           else
	       {
	       	 $this->response->redirect([
	             'for' => 'get-login'
	       	 ]);
	       }
       }
    }

   

}

