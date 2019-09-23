<?php
namespace System;
abstract class Controller
{

	protected $app;

	protected $errors=[];
	
	public function __construct(Application $app)
	{
		$this->app=$app;
	}

	public function __get($key)
	{
		return $this->app->get($key) ;
	}
	public function json($data)
	{
		return json_encode($data);
	}
}