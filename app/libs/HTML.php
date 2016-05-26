<?php
namespace Libs;

use \Phalcon\Di\Injectable as Injector;

/**
* @HTML class
*/
class HTML extends Injector
{
	public function style($path)
	{
        $fullpath = $this->url->get([ 'for' => '/' ]).$path;
        return "<link rel='stylesheet' type='text/css' href={$fullpath}>";
	}

	public function script($path)
	{
		$fullpath = $this->url->get([ 'for' => '/' ]).$path;
        return "<script type='text/javascript' src={$fullpath}></script>";
	}
}

?>