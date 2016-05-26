<?php

use Phalcon\Mvc\Controller;

class filteredBase extends ControllerBase
{

   public function onConstruct()
   {
   	  $this->view->disable();
   }

   public function beforeExecuteRoute($dispatcher)
   {
       if($this->auth->guest() == true)
       {

           $this->response->redirect([
                'for' => 'get-login'
           ]);
       }
      
   }

   public function afterExecuteRoute($dispatcher)
   {

   }


}

?>