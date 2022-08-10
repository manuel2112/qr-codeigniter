<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('slugify'))
{    
	function slugify($text, $divider = '-')
	{
	  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  $text = preg_replace('~[^-\w]+~', '', $text);
	  $text = trim($text, $divider);
	  $text = preg_replace('~-+~', $divider, $text);
	  $text = strtolower($text);
	
	  if (empty($text)) {
		return 'n-a';
	  }
	
	  return $text;
	}
}