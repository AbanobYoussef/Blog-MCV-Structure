<?php
 
namespace App\Controllers\Admin;

use System\Controller;


class UsersController extends Controller
{
	
	public function index()
	{
		$this->html->setTitle('Users');

		$data['users']=$this->load->model('Users')->all();
		$data['success']=$this->session->has('success')? $this->session->pull('success'):null;
		return $this->adminLayout->render($this->view->render('admin/users/list',$data));

	}


	public function add()
	{
		
		return $this->form();
	}


 // open the edit form
	public function edit($id)
	{
		$UModel=$this->load->model('Users');
		if(! $UModel->exists($id))
		{
			return $this->url->redirectTo('/404');
		} 

		$user=$UModel->get($id);

		return $this->form($user);

	}


// save the edited info
	public function save($id)
	{
		$json=[];

		if($this->isValid($id))
		{// no erroes 
			$this->load->model('Users')->update($id);
			$json['success']="Users Groups Has Been Updated Successfully";
			$json['redirectTo']=$this->url->link('admin/users');
		}
		else
		{// there are errors

			$json['errors']=$this->validator->flattenMessages();
		}
		return $this->json($json);
	}



	public function submit()
	{
		$json=[];

		if($this->isValid())
		{// no erroes 
			$this->load->model('Users')->create();
			$json['success']="Users Groups Has Been Created Successfully";
			$json['redirectTo']=$this->url->link('admin/users'); 
		}
		else 
		{// there are errors

			$json['errors']=$this->validator->flattenMessages();
		}
		return $this->json($json);
	}

 

	public function delete($id)
	{
		$UGModel=$this->load->model('Users');
		if( !$UGModel->exists($id))
		{
			pred($UGModel);
			return $this->url->redirectTo('/404');
		} 

		$UGModel->delete($id);
		$json['success']="Users Has Been Deleted"; 
		return $this->json($json);
	}


	public function isValid($id=null)
	{

		$this->validator->required('FirstName','First Name is Required');
		$this->validator->required('LastName','Last Name is Required');
		$this->validator->required('email')->email('email');
		$this->validator->unique('email',['users','email','id',$id]);
		$image=$this->request->file('image');
		if(is_null($id))
		{
			// if the id is null 
			// then this method is called to create new user
			// so we will validate the password as it should be required 
			// and the image as well
			$this->validator->required('password')->minLen('password',8)->match('password','confirm_password','Confirm Password Should Match Password');
 
			$this->validator->requiredFile('image')->image('image');

		}
		else if($image->exists())
		{
			$this->validator->image('image');
		}

		return $this->validator->passes();
	}




	private function form($user=null)
	{

		if($user)
		{
			// editing form

 			$data['action']= $this->url->link('admin/users/save/' .$user->id);

 			$data['heading']= 'Edit '.$user->first_name.' '.$user->second_name;

 			$data['butName']= 'Edit';

  
		}
		else
		{
			// adding form

			$data['action']= $this->url->link('admin/users/submit');

			$data['heading']= 'Add New users';

			$data['butName']= 'Add';

		}
 
		$user=(array) $user;
		$data['first_name']=array_get($user,'first_name');
		$data['second_name']=array_get($user,'second_name');
		$data['status']=array_get($user,'status','enabled');
 		$data['users_group_id']=array_get($user,'users_group_id');
		$data['email']=array_get($user,'email');
		$data['image']=array_get($user,'image');
		$data['gender']=array_get($user,'gender');
		$data['birthday']='';
		$data['image']='';

		if(! empty($user['birthday']))
		{
			$data['birthday']=date('d-m-Y',$user['birthday']);
		}

		if(! empty($user['image']))
		{
			$data['image']=assets('images/'.$user['image']);
		}
		$data['users_groups']=$this->load->model('UsersGroups')->all();
		
		return $this->view->render('admin/users/form',$data);
	}


	




	

}


