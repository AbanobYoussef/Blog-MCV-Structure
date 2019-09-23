<?php
namespace System;
use Closure;
class Application
{

	private $container=[];

	static private $inst;

	private function __construct(File $file)
	{
		$this->share('file',$file);
		$this->registerClasses();
		$this->loadHelpers();
	}

	public static function getInstane($file=null)
	{
		if(is_null(self::$inst))
		{
			self::$inst = new Application($file);
		}
		return static::$inst;
	}
	private function registerClasses()
	{
		spl_autoload_register([$this,'load']);
	}

	public function load($class)
	{
		if(strpos($class, 'App')===0)
		{
			$file=$this->file->to($class .'.php');
			
			//echo $file.'<br>';

		} else{
			// get the class from vendor
			$file=$this->file->toVendor($class .'.php');
			
		}
		if($this->file->exists($file))
			{
				$this->file->call($file);
			}
	}
/////////////////////////////////////
	public function __get($key)
	{
		return $this->get($key);
	}

	public function get($key)
	{
		if(!$this->isSharing($key))
		{
			
			if($this->isCoreAlias($key)){
				$this->share($key,$this->craeteNewCoreObject($key));
			}else {
				die('<b>'.$key.'</b> not foumd in application container');
				
			}
		}
		return $this->container[$key];
	}
///////////////////////////////////////////
	private function craeteNewCoreObject($alias)
	{
		$coreClasses=$this->coreClasses();
		$object=$coreClasses[$alias];
		return new $object($this);
	}
///////////////////////////////////////////
	public function isSharing($key){
		return isset($this->container[$key]);
	}
///////////////////////////////////////////
	public function share($key,$value)
	{
		if($value instanceof Closure)
		{
			$value =call_user_func($value ,$this);
		}
		$this->container[$key]=$value;
	}
//////////////////////////////////////////
	private function coreClasses()
	{
		return[
			'request'    =>'System\\Http\\Request',
			'response'   =>'System\\Http\\Response',
			'session'    =>'System\\Session',
			'cookie'     =>'System\\Cookie',
			'load'       =>'System\\Loader',
			'html'       =>'System\\Html',
			'db'         =>'System\\Database',
			'view'       =>'System\\View\\ViewFactory',
			'route'      =>'System\\Route',
			'url'        =>'System\\Url',
			'validator'  =>'System\\Validation',
			'pagination'    => 'System\\Pagination',
		];
	}
//////////////////////////////////////////
	private function isCoreAlias($alias)
	{
		$coreClasses=$this->coreClasses();
		return isset($coreClasses[$alias]);
	}
//////////////////////////////////////////
	private function loadHelpers()
	{
		$this->file->call($this->file->toVendor('helpers.php'));
		//pre($this);
	}
//////////////////////////////////////////
	public function run()
	{
		$this->session->start();
		$this->request->preparUrl();
		$this->file->call($this->file->to('App/init.php'));
		list($controller,$method,$arguments)=$this->route->getProperRoute();
		
		if($this->route->hasCallsFirst())
		{
			$this->route->callFirstCalls();
		}

		$output=(string) $this->load->action($controller,$method,$arguments);
		$this->response->setOutput($output);
		$this->response->send();

	}
}