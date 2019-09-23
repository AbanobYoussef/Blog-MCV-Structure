<?php
use System\Application;

if(! function_exists('pre'))
{
	function pre($var)
	{
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
}

if(! function_exists('pred'))
{
	function pred($var)
	{
		pre($var);
		die;
	}
}

if(! function_exists('array_get')) {
	function array_get($array , $key , $def=null)
	{
		return isset($array[$key])?$array[$key]:$def;
	}
}


if(! function_exists('_e')) {
	function _e($value)
	{
		return htmlspecialchars($value);
	}
}

if(! function_exists('assets')) {
	function assets($path)
	{
		//global $app;
		$app = Application::getInstane();
		return $app->url->link('public/'.$path);
	}


if(! function_exists('url')) {
		function url($path)
		{
			//global $app;
			$app = Application::getInstane();
			return $app->url->link($path);
		}

	}

	 function read_more($string, $number_of_words)
    {
        // remove any empty values in the exploded array
        $words_of_string = explode(' ' , $string);

        if (count($words_of_string) <= $number_of_words) {
            return $string;
        }

        return implode(' ', array_slice($words_of_string, 0, $number_of_words));
    }


    if (! function_exists('seo')) {
     /**
     * Remove any unwanted characters from the given string
     * and replace it with -
     *
     * @param string $string
     * @return string
     */
    function seo($string)
    {
        // remove any white spaces from the beginning and
        //the end of the given string
        $string = trim($string);

        // replace any non English or numeric characters and dashes with white space
        $string = preg_replace('#[^\w]#', ' ' , $string);

        // replace any multi white spaces with just one white space
        $string = preg_replace('#[\s]+#', ' ', $string);

        // replace white spaces with dash
        $string = str_replace(' ', '-', $string);

        // make all letters in small case letters
        // and trim any dashes
        return trim(strtolower($string), '-');
    }
}
}


