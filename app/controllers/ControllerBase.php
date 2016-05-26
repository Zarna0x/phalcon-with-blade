<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	public function onConstruct()
    {
       $this->view->disable();
    }

}
