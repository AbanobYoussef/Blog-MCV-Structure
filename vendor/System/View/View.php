<?php
namespace System\View;

use System\File;
class View implements ViewInterface{

	private $file;
	private $viewPath;
	private $data=[];
	private $output;

	public function __construct(File $file ,$viewPath, array $data){
		$this->file=$file;

		$this->preparePath($viewPath);

		$this->data=$data;
	}

	public function preparePath($viewPath){
		
		$this->viewPath=$this->file->to('App/Views/'.$viewPath.'.php');
		//echo $this->viewPath.'<br>';
		if(!$this->viewFileExists())
		{
			die($viewPath.'does not exits in Views Folder');
		}
	}


	public function viewFileExists(){
		return $this->file->exists($this->viewPath);
		
	}

	public function getOutput(){

		if (is_null($this->output))
		{
			ob_start();
			  extract($this->data);
			require $this->viewPath;
			$this->output=ob_get_clean();
		}
		return $this->output;
	}

	public function __toString(){
		return $this->getOutput();
	}
}