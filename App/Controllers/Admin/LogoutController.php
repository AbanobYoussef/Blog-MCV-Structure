<?php

namespace App\Controllers\Admin;

use System\Controller;


class LogoutController extends Controller
{
	
	public function index()
	{
		
		$this->session->destroy(); 
		$this->cookie->destroy();
		return $this->url->redirectTo('/admin/login');

	}
	public function submit()
	{

		$loginModel=$this->load->model('Login');
		if ($this->isValid())
		{
			$logedInUser = $loginModel->user();
			if($this->request->post('remeber'))
			{
				//save login data in cookie
				$this->cookie->set('login',$logedInUser->code);

			}
			else
			{
				//save login data in session
				$this->session->set('login',$logedInUser->code);

			}
			$json=[];
			$json['success']=' Welcome Back '.$logedInUser->first_name;
			$json['redirect']=$this->url->link('/admin');
			return $this->json($json);

		} 
		else
	    {
			$json=[];
			$json['errors']=implode('<br>', $this->errors);
			return $this->json($json);
		}
	}


	private function isValid()
	{
		$email=$this->request->post('email');
		$password=$this->request->post('password');
		if(! $email)
		{
			$this->errors[]='Please Insert Email address';
		}elseif (! filter_var($email,FILTER_VALIDATE_EMAIL))
		{

			$this->errors[]='Please Insert Valid Email ';
		}

		if(! $password)
		{
			$this->errors[]='Please Insert Password';
		}

		if(! $this->errors)
		{
			$loginModel=$this->load->model('Login');
			if(! $loginModel->isValidLogin($email,$password))
			{
				$this->errors[]='Invalid Login Data';
			}
		}
		return empty($this->errors);
	}


}


