<?php
 
namespace App\Controllers\Admin;

use System\Controller;


class ProfileController extends Controller
{


 
// save the edited info
	public function update()
	{
		$json=[];
		$user=$this->load->model('Login')->user();

		if($this->isValid($user->id))
		{// no erroes 
			$this->load->model('Users')->update($user->id);
			$json['success']="User Groups Has Been Updated Successfully";
			$json['redirectTo']=$this->url->link('admin/users');
		}
		else
		{// there are errors

			$json['errors']=$this->validator->flattenMessages();
		}
		return $this->json($json);
	}


	public function isValid($id=null)
	{

		$this->validator->required('FirstName','First Name is Required');
		$this->validator->required('LastName','Last Name is Required');
		$this->validator->required('email')->email('email');
		if($this->request->post('password'))
		{
			$this->validator->required('password')->minLen('password',8);
		}
		if($this->request->post('image'))
		{
			$this->validator->image('image');
		}

		return $this->validator->passes();
	}



	

}


