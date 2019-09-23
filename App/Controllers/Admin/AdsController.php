<?php
 
namespace App\Controllers\Admin;

use System\Controller;


class AdsController extends Controller
{
	
	public function index()
	{
		$this->html->setTitle('Ads');

		$data['ads']=$this->load->model('Ads')->all();
		$data['success']=$this->session->has('success')? $this->session->pull('success'):null;
		return $this->adminLayout->render($this->view->render('admin/ads/list',$data));

	}


	public function add()
	{
		
		return $this->form();
	}


 // open the edit form
	public function edit($id)
	{
		$UModel=$this->load->model('Ads');
		if(! $UModel->exists($id))
		{
			return $this->url->redirectTo('/404');
		} 

		$ad=$UModel->get($id);

		return $this->form($ad);

	}


// save the edited info
	public function save($id)
	{
		$json=[];

		if($this->isValid($id))
		{// no erroes 
			$this->load->model('Ads')->update($id);
			$json['success']="Ads Groups Has Been Updated Successfully";
			$json['redirectTo']=$this->url->link('admin/ads');
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
			$this->load->model('Ads')->create();
			$json['success']="Ads Groups Has Been Created Successfully";
			$json['redirectTo']=$this->url->link('admin/ads'); 
		}
		else 
		{// there are errors

			$json['errors']=$this->validator->flattenMessages();
		}
		return $this->json($json);
	}

 

	public function delete($id)
	{
		$UGModel=$this->load->model('Ads');
		if( ! $UGModel->exists($id))
		{
			return $this->url->redirectTo('/404');
		} 

		$UGModel->delete($id);
		$json['success']="Ads Has Been Deleted"; 
		return $this->json($json);
	}


	public function isValid($id=null)
	{
		$this->validator->required('name');
		$this->validator->required('link');
		$this->validator->required('page');
		$this->validator->required('starts_at');
		$this->validator->required('ends_at');
		$image=$this->request->file('image');
		if(is_null($id))
		{
			$this->validator->requiredFile('image')->image('image');

		}
		else if($image->exists())
		{
			$this->validator->image('image');
		}

		return $this->validator->passes();
	}




	private function form($ad=null)
	{
 
		if($ad)
		{
			// editing form

 			$data['action']= $this->url->link('admin/ads/save/' .$ad->id);

 			$data['heading']= 'Edit '.$ad->name;

 			$data['butName']= 'Edit';
 			

  
		}
		else
		{
			// adding form

			$data['action']= $this->url->link('admin/ads/submit');

			$data['heading']= 'Add New ads';

			$data['butName']= 'Add';
		}
 
		$ad=(array) $ad;
		$data['start_at']=!empty($ad['start_at'])?date('d-m-Y',$ad['start_at']):false;
		$data['end_at']=!empty($ad['end_at'])?date('d-m-Y',$ad['end_at']):false;  ;
		$data['name']=array_get($ad,'name');
		$data['link']=array_get($ad,'link');
		$data['ad_page']=array_get($ad,'page');
		$data['status']=array_get($ad,'status','enabled');
		$data['image']='';

		if(! empty($ad['image']))
		{
			$ad['image']=assets('images/'.$ad['image']);
		}

		$data['pages']=$this->getPermissionPages();

		
		return $this->view->render('admin/ads/form',$data);
	}


	private function getPermissionPages ()
	{
		$permission=[];

		foreach ($this->route->routes as $route) {
			if(strpos($route['url'], '/admin')!==0)
			{
				$permission[]=$route['url'];
			}
		}
		return $permission;
	}


	




	

}


