<?php
 
namespace App\Controllers\Admin;

use System\Controller;


class PostsController extends Controller
{
	
	public function index()
	{
		$this->html->setTitle('Posts');

		$data['posts']=$this->load->model('Posts')->all();
		$data['success']=$this->session->has('success')? $this->session->pull('success'):null;
		return $this->adminLayout->render($this->view->render('admin/posts/list',$data));

	}


	public function add()
	{
		
		return $this->form();
	}


 // open the edit form
	public function edit($id)
	{
		$UModel=$this->load->model('Posts');
		if(! $UModel->exists($id))
		{
			return $this->url->redirectTo('/404');
		} 

		$post=$UModel->get($id);

		return $this->form($post);

	}


// save the edited info
	public function save($id)
	{
		$json=[];

		if($this->isValid($id))
		{// no erroes 
			$this->load->model('Posts')->update($id);
			$json['success']="Posts Groups Has Been Updated Successfully";
			$json['redirectTo']=$this->url->link('admin/posts');
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
			$this->load->model('Posts')->create();
			$json['success']="Posts Groups Has Been Created Successfully";
			$json['redirectTo']=$this->url->link('admin/posts'); 
		}
		else 
		{// there are errors

			$json['errors']=$this->validator->flattenMessages();
		}
		return $this->json($json);
	}

 

	public function delete($id)
	{
		$UGModel=$this->load->model('Posts');
		if( ! $UGModel->exists($id))
		{
			return $this->url->redirectTo('/404');
		} 

		$UGModel->delete($id);
		$json['success']="Posts Group Has Been Deleted"; 
		return $this->json($json);
	}


	public function isValid($id=null)
	{

		$this->validator->required('title');
		$this->validator->required('details');
		$this->validator->required('tags');
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




	private function form($post=null)
	{

		if($post)
		{
			// editing form

 			$data['action']= $this->url->link('admin/posts/save/' .$post->id);

 			$data['heading']= 'Edit '.$post->title;

 			$data['butName']= 'Edit';

  
		}
		else
		{
			// adding form

			$data['action']= $this->url->link('admin/posts/submit');

			$data['heading']= 'Add New posts';

			$data['butName']= 'Add';

		}
 
		$post=(array) $post;
		$data['title']=array_get($post,'title');
		$data['category_id']=array_get($post,'category_id');
		$data['status']=array_get($post,'status','enabled');
		$data['details']=array_get($post,'details');
		$data['tags']=array_get($post,'tags');
		$data['image']=array_get($post,'image');
		$data['id']=array_get($post,'id');
		$data['image']='';

		
		if(! empty($post['image']))
		{
			$data['image']=assets('images/'.$post['image']);
		}

		$data['related_posts']=[];
		if($post['related_posts'])
		{

		$data['related_posts']=explode(',', $post['related_posts']);
		}

		$data['categories']=$this->load->model('Categories')->all();
		$data['posts']=$this->load->model('Posts')->all();

		
		return $this->view->render('admin/posts/form',$data);
	}


	




	

}


