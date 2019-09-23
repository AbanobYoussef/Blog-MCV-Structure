<?php
namespace System;

class File
{
	private $root; 
	const DS=DIRECTORY_SEPARATOR;

	public function __construct($root)
	{
		$this->root=$root;
	}
	public function exists($file)
	{
		return file_exists($file);
	}

	public function call($file)
	{
		return require $file;
	}

	public function toVendor($path)
	{
		return $this->to('vendor/'.$path);
	}

	public function toPublic($path)
	{
		return $this->to('public/'.$path);
	}

	public function to($path)
	{
		return $this->root.static::DS.str_replace(['/',"\\"],static::DS,$path);
	}
}