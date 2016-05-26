<?php 

namespace Libs;


use Windwalker\Renderer\BladeRenderer as BladeRenderer; 
use Phalcon\Http\Response as Response;

 /**
 * Blade Class
 */
 class Blade extends BladeRenderer
 {
 	
 	public function make($file, $data = null)
 	{    
 		$response = new Response();
     
        if($data)
        {
             $response->setContent($this->render($file,$data));
        }else
        {
           	$response->setContent($this->render($file));
        }

        $response->send();
 	    
 	}
 }
?>