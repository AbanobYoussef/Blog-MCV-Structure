<?php  

namespace System;

class Validation 
{
	private $app;

	private $errors=[];

	public function __construct(Application $app)
	{
		$this->app=$app;
	}
///////////////////////////////////////////////////////////
	public function required($inputName , $customErrorMessage=null)
	{
		if($this->hasErrors($inputName))
		{
			return $this;
		}
		$inputValue=$this->value($inputName);
		if($inputValue ==='')
		{
			$message=$customErrorMessage?:sprintf('%s Is Required',ucfirst($inputName));
			$this->addError($inputName,$message);
		}
		return $this;
	}
///////////////////////////////////////////////////////////
	public function requiredFile($inputName , $customErrorMessage=null)
	{
		if($this->hasErrors($inputName))
		{
			return $this;
		}
		$file=$this->app->request->file($inputName);
		if(! $file->exists() )
		{
			$message=$customErrorMessage?:sprintf('%s Is Required',ucfirst($inputName));
			$this->addError($inputName,$message);
		}
		return $this;
	}
///////////////////////////////////////////////////////////
	public function image($inputName , $customErrorMessage=null)
	{
		if($this->hasErrors($inputName))
		{
			return $this;
		}
		$file=$this->app->request->file($inputName);

		if($file->exists())
		{
			return $this;
		}

		if(! $file->isImage() )
		{
			$message=$customErrorMessage?:sprintf('%s Is Not valid Image',ucfirst($inputName));
			$this->addError($inputName,$message);
		}
		return $this;
	}

///////////////////////////////////////////////////////////
	public function email($inputName , $customErrorMessage=null)
	{
		if($this->hasErrors($inputName))
		{
			return $this;
		}

		$inputValue=$this->value($inputName);
		if(! filter_var($inputValue , FILTER_VALIDATE_EMAIL))
		{
			$message=$customErrorMessage?:sprintf('%s is not valid email',ucfirst($inputName));
			$this->addError($inputName,$message);
		}
		return $this;
	}
///////////////////////////////////////////////////////////
	public function float($inputName , $customErrorMessage=null)
	{
		if($this->hasErrors($inputName))
		{
			return $this;
		}

		$inputValue = $this->value($inputName);

		if(! is_float($inputValue))
		{
			$message=$customErrorMessage?:sprintf('%s Accepts only floats',ucfirst($inputName));
			$this->addError($inputName,$message);
		}

		return $this;

	}
///////////////////////////////////////////////////////////
	public function minLen($inputName ,$length, $customErrorMessage=null)
	{
		
		$inputValue = $this->value($inputName);
		if(strlen($inputValue)<$length)
		{
			$message=$customErrorMessage?:sprintf('%s should be at least %d',ucfirst($inputName),$length);
			$this->addError($inputName,$message);
		}
		return $this;

	}
///////////////////////////////////////////////////////////
	public function maxLen($inputName ,$length, $customErrorMessage=null)
	{
		if($this->hasErrors($inputName))
		{
			return $this;
		}
		$inputValue = $this->value($inputName);
		if(strlen($inputValue) > $length)
		{
			$message=$customErrorMessage?:sprintf('%s should be almost %d',ucfirst($inputName),$length);
			$this->addError($inputName,$message);
		}
		return $this;


	}
///////////////////////////////////////////////////////////
	public function match($firstInputName , $secondInputName , $customErrorMessage=null)
	{
		$firtsInputValue=$this->value($firstInputName);
		$secondInputValue=$this->value($secondInputName);
		if($firtsInputValue!=$secondInputValue)
		{
			$message=$customErrorMessage?:sprintf('%s should match %s',ucfirst($secondInputName),ucfirst($firstInputName));
			$this->addError($secondInputName,$message);
		}
		return $this;
	}
///////////////////////////////////////////////////////////
	public function unique($inputName ,array  $databaseDate ,$customErrorMessage=null)
	{
		if($this->hasErrors($inputName))
		{
			return $this;
		}

		$inputValue=$this->value($inputName);

		$table=null;
		$column=null;
		$excepCol=null;
		$excepVal=null;

		if(count($databaseDate)==2)
		{
			list($table,$column)=$databaseDate;

		}

		if(count($databaseDate)==4)
		{
			list($table,$column ,$excepCol,$excepVal)=$databaseDate;

		}

		if($excepCol AND $excepVal)
		{

			$result=$this->app->db->select($column)
							  ->from($table)
							  ->where($column.'=? AND '.$excepCol.' != ?',$inputValue , $excepVal )
							  ->fetch();
		}
		else
		{

			$result=$this->app->db->select($column)
							  ->from($table)
							  ->where($column.'=? ',$inputValue)
							  ->fetch();
		}

		if($result)
		{
			$message=$customErrorMessage?:sprintf('%s already exists',ucfirst($inputName));
			$this->addError($inputName,$message);
		}

	}
///////////////////////////////////////////////////////////
	public function message($message)
	{
		$this->errors[]=$message;
		return $this;
	}
///////////////////////////////////////////////////////////
	public function validate()
	{

	}
///////////////////////////////////////////////////////////
	public function fails()
	{
		return ! empty($this->errors);
	}
///////////////////////////////////////////////////////////
	public function passes()
	{
		return empty($this->errors);
	}
///////////////////////////////////////////////////////////
	public function getMessage()
	{
		return $this->errors;
	}
///////////////////////////////////////////////////////////
	private function value($input)
	{
		return $this->app->request->post($input);
	}
///////////////////////////////////////////////////////////
	private function addError($inputName ,$errorMessage)
	{
		$this->errors[$inputName]=$errorMessage;
	}
///////////////////////////////////////////////////////////
	private function hasErrors($inputName)
	{
		return array_key_exists($inputName, $this->errors);
	}
///////////////////////////////////////////////////////////
	public function flattenMessages()
	{
		return implode('<br>', $this->getMessage());
	}




		

}