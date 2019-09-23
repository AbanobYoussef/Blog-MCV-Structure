<?php
namespace System;
class Loader
{


	private $app;

	private $controllers=[];

	private $models=[];

	public function __construct(Application $app){

		$this->app=$app;
	}

////////////////////////////////////////////////////
	public function action ($controller,$method='index',$arguments=[]){

		$obj=$this->controller($controller);

		return call_user_func_array([$obj,$method],$arguments);

	}
////////////////////////////////////////////////////
	public function controller($controller){

		$controller=$this->getControllerName($controller);
		if(!$this->hasController($controller)){
			$this->addController($controller);
		}

		return $this->getController($controller);

	}
////////////////////////////////////////////////////
	private function hasController($controller){

		return array_key_exists($controller, $this->controllers);
	}
////////////////////////////////////////////////////

	private function addController($controller){
		$obj= new $controller ($this->app);
		//Home
		//App\Controllers\Home
		$this->controllers[$controller]=$obj;
	}

////////////////////////////////////////////////////
	private function getController($controller){
		return $this->controllers[$controller];
	}

////////////////////////////////////////////////////
	private function getControllerName($controller){
		$controller.='Controller';
		$controller ='App\\Controllers\\'.$controller;
		return str_replace('/', '\\',  $controller) ;

	}
////////////////////////////////////////////////////
	public function model($model)
	{
		$model=$this->getModelName($model);
		
		if(!$this->hasModel($model)){

			$this->addModel($model);
		}

		return $this->getModel($model);
		
	}
////////////////////////////////////////////////////
	private function hasModel($model)
	{
		return array_key_exists($model, $this->models);
	}

////////////////////////////////////////////////////
	private function addModel($model){
		$obj= new $model ($this->app);
		//Home
		//App\Controllers\Home
		$this->models[$model]=$obj;
	}

////////////////////////////////////////////////////
	private function getModel($model){
		return $this->models[$model];
	}
//////////////////////////////////////////////////
	private function getModelName($model){
		$model.='Model';
		$model ='App\\Models\\'.$model;
		return str_replace('/', '\\',  $model) ;
	}
//////////////////////////////////////////////////

}