<?php 

namespace System;

class Route{
	private $app;

	private $route=[];

	private $current=[];

	private $calls=[];

	private $notFound;
/////////////////////////////////////////////////
	public function __construct(Application $app)
	{
		$this->app=$app;
	}
////////////////////////////////////////////////
	public function callFirst(callable $callable)
	{
		$this->calls['first'][]=$callable;
		return $this;
	}
////////////////////////////////////////////////
	public function hasCallsFirst()
	{
		return !empty($this->calls['first']);
	}

////////////////////////////////////////////////
	public function callFirstCalls()
	{
		foreach ($this->calls['first'] as $callback)
		{
			 call_user_func($callback,$this->app);
		}
	}
/////////////////////////////////////////////////
	public function add($url , $action ,$requestMethod='GET')
	{
		$route=[
			'url'=>$url,
			'pattern'=>$this->generatePattern($url),
			'action'=>$this->getAction($action),
			'method'=>$requestMethod
		];
		$this->routes[]=$route;
	}

/////////////////////////////////////////////
	private function generatePattern($url){
		$pattern='#^';
		//:text ([a-zA-Z0-9]+)
		//:id (\d+)
		$pattern.=str_replace([':text',':id'], ['([a-zA-Z0-9]+)','(\d+)'],$url);

		$pattern .='$#';
		return $pattern;
	}
/////////////////////////////////////////////
	private function getAction($action){
		
		$action=str_replace('/', '\\',$action);

		return strpos($action,'@')!== false?$action:$action.'@index';
	}
//////////////////////////////////////////////
	public function notFound($url){
		$this->notFound=$url;
	}
/////////////////////////////////////////////
	public function getProperRoute(){
		foreach ($this->routes as $route) {
			if($this->isMatching($route['pattern'])AND $this->isMatchingRequestMethod($route['method']))
			{
				$arguments=$this->getArgumentsFrom($route['pattern']);
				list($controller,$method)=explode('@', $route['action']);
				$this->current=$route;
				return [$controller,$method,$arguments];

			}
		}
		return $this->app->url->redirectTo($this->notFound);
	}
///////////////////////////////////////////////

	private function isMatching($pattern)
	{
		return preg_match($pattern, $this->app->request->url());
	}
/////////////////////////////////////////

	private function getArgumentsFrom($pattern)
	{
		preg_match($pattern, $this->app->request->url(),$matches);
		array_shift($matches);
		return $matches;
	}
/////////////////////////////////////////////// 

	private function isMatchingRequestMethod($route)
	{
		return $route==$this->app->request->method();
	}
///////////////////////////////////////////////////

	public function routes ()
	{
		return $this->route;
	}
///////////////////////////////////////////////////
	public function getCurrentRoute()
	{

		return $this->current['url'];
	}

}