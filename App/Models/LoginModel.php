<?php

namespace App\Models;

use System\Model;

class LoginModel extends Model
{
	
	protected $table='users';
	public $user='';

	public function __constract()
	{

	}

	public function isValidLogin($email,$password)
	{
		$user=$this->where('email =?',$email)->fetch($this->table);
		if (! $user)
			{
				return false;
			}
			$this->user=$user; 
        return password_verify($password,$user->password);
	}
	public function user()
	{
		$this->isLogged();
		return $this->user;
	}

	public function isLogged()
	{
		
		if($this->cookie->has('login'))
		{
			$code=$this->cookie->get('login');

			
		}
		elseif ($this->session->has('login')) 
		{
			$code=$this->session->get('login');
		}
		else
	    {
	    	
			$code='';
		}
		$user=$this->where('code=?',$code)->fetch($this->table);
		if(! $user)
		{
			return false;
		}
		$this->user=$user;
		return true;
	}
}