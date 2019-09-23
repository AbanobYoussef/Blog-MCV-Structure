<?php
 
namespace App\Controllers\Admin;

use System\Controller;


class UsersGroupsController extends Controller
{
	
	public function index()
	{
		$this->html->setTitle('UsersGroups');

		$data['users_groups']=$this->load->model('UsersGroups')->all();
		$data['success']=$this->session->has('success')? $this->session->pull('success'):null;
		return $this->adminLayout->render($this->view->render('admin/users-groups/list',$data));

	}


	public function add()
	{
		
		return $this->form();
	}


 // open the edit form
	public function edit($id)
	{
		$UGModel=$this->load->model('UsersGroups');

		if(! $UGModel->exists($id))
		{
			pre($UGModel);
			return $this->url->redirectTo('/404');
		} 

		$usersGroups=$UGModel->get($id);

		return $this->form($usersGroups);

	}


// save the edited info
	public function save($id)
	{
		$json=[];

		if($this->isValid())
		{// no erroes 
			$this->load->model('UsersGroups')->update($id);
			$json['success']="Users Groups Has Been Updated Successfully";
			$json['redirectTo']=$this->url->link('admin/users-groups');
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
			$this->load->model('UsersGroups')->create();
			$json['success']="Users Groups Has Been Created Successfully";
			$json['redirectTo']=$this->url->link('admin/users-groups'); 
		}
		else
		{// there are errors

			$json['errors']=$this->validator->flattenMessages();
		}
		return $this->json($json);
	}

  

	public function delete($id)
	{
		$UGModel=$this->load->model('UsersGroups');
		if( ! $UGModel->exists($id))
		{
			return $this->url->redirectTo('/404');
		} 

		$UGModel->delete($id);
		$json['success']="Users Group Has Been Deleted"; 
		return $this->json($json);
	}


	public function isValid()
	{

		$this->validator->required('catName','Users Group is Required');
		return $this->validator->passes();
	}


	private function form($UGModel=null)
	{

		if($UGModel)
		{
			// editing form

 			$data['action']= $this->url->link('admin/users-groups/save/' .$UGModel->id);

 			$data['heading']= 'Edit '.$UGModel->name;

 			$data['butName']= 'Edit';

 
		}
		else
		{
			// adding form

			$data['action']= $this->url->link('admin/users-groups/submit');

			$data['heading']= 'Add New users group';

			$data['butName']= 'Add';

		}

		$data['name']=$UGModel?$UGModel->name:null;
		$data['userPages']=$UGModel?$UGModel->pages:[];
		//$data['status']=$UGModel?$UGModel->status:'enabled';
		$data['pages']=$this->getPermissionPages();
		return $this->view->render('admin/users-groups/form',$data);
	}


	private function getPermissionPages ()
	{
		$permission=[];

		foreach ($this->route->routes as $route) {
			if(strpos($route['url'], '/admin')===0)
			{
				$permission[]=$route['url'];
			}
		}
		return $permission;
	}




	

}


