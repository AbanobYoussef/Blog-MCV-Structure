<?php 
namespace System\Http;
 class Request
 {

 	private $url;

 	private $baseUrl;
 	
 	private $files=[];



 	public function preparUrl()
 	{
 		 $script=dirname($this->server('SCRIPT_NAME'));
 		 $requestUri=$this->server('REQUEST_URI');
 		 if (strpos($requestUri,'?')!==false) {
 		 	list($requestUri,$queryString)=explode('?', $requestUri);
 		 }

 		 $this->url= rtrim(preg_replace('#^'.'/Blog%20MVC'.'#','', $requestUri),'/');

 		if( ! $this->url)
 		{
 			$this->url='/';
 		}

 		 $this->baseUrl=$this->server('REQUEST_SCHEME').'://'.$this->server('HTTP_HOST').'/Blog%20MVC/';
 	}
 ///////////////////////////////////////////////////////////
 	public function get($key , $default=null)
 	{
 		return array_get($_GET,$key,$default);
 	}
 	 public function post($key, $default = null)
    {
        // just remove any white space if there is a value
        $value = array_get($_POST, $key, $default);
        if (is_array($value)) {
            $value = array_filter($value);
        } else {
            $value = trim($value);
        }

        return $value;
    }
 
///////////////////////////////////////////////////////////
 	public function file($input)
 	{
 		if(isset($this->files[$input]))
 		{
 			return $this->files[$input];
 		}

 		$uploadedFile=new UploadedFile($input);

 		$this->files[$input]=$uploadedFile;

 		return $this->files[$input];

 	}
///////////////////////////////////////////////////////////
 	public function server($key , $default=null)
 	{
 		return array_get($_SERVER,$key,$default);
 	}
///////////////////////////////////////////////////////////
 	public function method()
 	{
 		return $this->server('REQUEST_METHOD');
 	}
///////////////////////////////////////////////////////////
 	public function baseUrl()
 	{
 		return  $this->baseUrl;
  	}
///////////////////////////////////////////////////////////
 	public function url()
 	{
 		//pre($this->url);
 		return $this->url;
 	}
///////////////////////////////////////////////////////////
 	public function referer()
 	{
 		//pre($this->url);
 		return $this->server('HTTP_REFERER');
 	}


 
 }