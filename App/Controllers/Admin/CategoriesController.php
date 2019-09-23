<?php

namespace App\Controllers\Admin;

use System\Controller;


class CategoriesController extends Controller
{
	
	public function index()
	{
		$this->html->setTitle('Categories');

		$data['categories']=$this->load->model('Categories')->all();
		$data['success']=$this->session->has('success')? $this->session->pull('success'):null;
		return $this->adminLayout->render($this->view->render('admin/categories/list',$data));
	}

	public function add()
	{
		
		return $this->form();
	}


 // open the edit form
	public function edit($id)
	{
		$CatModel=$this->load->model('Categories');
		if(! $CatModel->exists($id))
		{
			return $this->url->redirectTo('/404');
		} 

		$Cat=$CatModel->get($id);

		return $this->form($Cat);

	}


// save the edited info
	public function save($id)
	{
		$json=[];

		if($this->isValid())
		{// no erroes 
			$this->load->model('Categories')->update($id);
			$json['success']="Categorty Has Been Updated Successfully";
			$json['redirectTo']=$this->url->link('admin/categories');
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
			$this->load->model('Categories')->create();
			$json['success']="Categorty Has Been Created Successfully";
			$json['redirectTo']=$this->url->link('admin/categories'); 
		}
		else
		{// there are errors

			$json['errors']=$this->validator->flattenMessages();
		}
		return $this->json($json);
	}

 

	public function delete($id)
	{
		$CatModel=$this->load->model('Categories');
		if(! $CatModel->exists($id))
		{
			return $this->url->redirectTo('/404');
		} 

		$CatModel->delete($id);
		$json['success']="category Has Been Deleted"; 
		return $this->json($json);
	}


	public function isValid()
	{

		$this->validator->required('catName','Category is Required');
		return $this->validator->passes();
	}


	private function form($Cat=null)
	{

		if($Cat)
		{
			// editing form

 			$data['action']= $this->url->link('admin/categories/save/' .$Cat->id);

 			$data['heading']= 'Edit '.$Cat->name;

 			$data['butName']= 'Edit';
 			

		}
		else
		{
			// adding form

			$data['action']= $this->url->link('admin/categories/submit');

			$data['heading']= 'Add New Category';

			$data['butName']= 'Add';

		}

		$data['name']=$Cat?$Cat->name:null;
		$data['status']=$Cat?$Cat->status:'enabled';
		return $this->view->render('admin/categories/form',$data);
	}
	

}


