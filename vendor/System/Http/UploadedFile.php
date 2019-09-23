<?php
 
namespace System\Http;

use System\Application;

class UploadedFile
{
	private $app;

	private $file=[];

	private $fileName;

	private $nameOnly;

	private $extension;

	private $mimeType;

	private $tempFile;

	private $size;

	private $error;

	private $allowImageExtensions=['gif','jpg','jpeg','png','webp'];


	public function __construct($input)
	{
		$this->getFileInfo($input);

	}

	private function getFileInfo($input)
	{
		
		if(empty($_FILES[$input]))
		{
			return ;
		}


		$file=$_FILES[$input];

		$this->error=$file['error'];

		if($this->error != UPLOAD_ERR_OK)
		{
			return ;
		}

		$this->file=$file;

		$this->fileName=$this->file['name'];

		$fileNameInfo=pathinfo($this->fileName);

		$this->nameOnly=$fileNameInfo['filename'];

	    $this->extension=strtolower($fileNameInfo['extension']);

		$this->mimeType=$this->file['type'];

		$this->tempFile=$this->file['tmp_name'];

		$this->size=$this->file['size'];
		

	}
////////////////////////////////////////////////////////////
	public function exists()
	{
		return !empty($this->file);
	}
////////////////////////////////////////////////////////////
	public function getFileName()
	{
		return $this->fileName;
	}
////////////////////////////////////////////////////////////
	public function getNameOnly()
	{
		return $this->nameOnly;
	}
///////////////////////////////////////////////////////////
	public function getExtension()
	{
		return $this->extension;
	}
///////////////////////////////////////////////////////////
	public function getMimeType()
	{
		return $this->mimeType;
	}
///////////////////////////////////////////////////////////
	public function isImage()
	{

		return (strpos($this->mimeType,'image/')===0
				 AND in_array($this->extension,$this->allowImageExtensions));
	}
///////////////////////////////////////////////////////////
	public function moveTo($target , $newFileName=null)
	{

		$fileName=$newFileName?:sha1(mt_rand()).'_'.sha1(mt_rand());
		$fileName.='.'.$this->extension;
		if(! is_dir($target))
		{
			mkdir($target,0777,true);
		}

		$uploadedFilePath=rtrim($target,'/').'/'.$fileName;
		
		move_uploaded_file($this->tempFile, $uploadedFilePath);
		return $fileName;
	}






}