<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('generaRandom'))
{    
	function generaRandom()
	{
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$cad = "";
		for($i=0;$i<50;$i++) {
			$cad .= substr($str,rand(0,62),1);
		}
		return $cad;
	}
}