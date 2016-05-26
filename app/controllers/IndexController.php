<?php

/*
 * @Index controller
 * @Author Zarna0x
 * (c) 2016
 */
class IndexController extends filteredBase
{
    
    public function indexAction()
    {   
	   View::make('index.home');
    }

}

