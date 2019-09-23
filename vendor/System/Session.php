<?php 
namespace System;
 class Session
 {

 	private $app;
 	public function __construct(Application $app)
 	{
 		$this->app=$app;
 	}


public function start()
 	{
 		ini_set('session.use_only_cookies',1);
 		if(! session_id()){
 			session_start(); 
 		}
 	}

 	public function set($key , $value)
 	{
 		$_SESSION[$key]=$value;
 	}

 	public function get($key , $default=null)
 	{
 		return array_get($_SESSION,$key,$default);
 	}

 	public function has($key)
 	{
 		return isset($_SESSION[$key]);
 	}

 	public function remove($key)
 	{
 		unset($_SESSION[$key]);
 	}

 	public function pull($key)
 	{
 		$value=$this->get($key);

 		$this->remove($key);

 		return $value;
  	}


 	public function all()
 	{
 		return $_SESSION;
 	}

 	public function destroy()
 	{
 		unset($_SESSION);
 		session_destroy();
 	}
 
 }