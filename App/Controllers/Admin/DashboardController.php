<?php

namespace App\Controllers\Admin;
 use System\Controller;
class DashboardController extends Controller {


	public function index(){
		
		
		return $this->view->render('admin/main/dashboard');

	}	

	public function submit(){
		
		$this->validator->required('email')->email('email')->unique('email',['users','email']);
		$this->validator->required('password')->minLen('password',8);
		$this->validator->match('password','confirm_password');
		$file=$this->request->file('image');

		if($file->isImage())
		{
			echo $file->moveTo($this->file->to('public/images'),'A');
		}



	}	
}























/*echo $this->db->data([
			'email'=>'A',
			'status'=>'<b>',
		])->insert('users')->lastId();*/



		/*$user = $this->db->query('SELECT * FROM users WHERE id =?',6)->fetch();
		pre($user);*/

		/*$this->db->data('first_name','Abanob')
				 ->update('users');*/

		/*	$users=$this->db->select('*')->from('users')->where('id > ? AND id < ?', 0,10)->orderBy('id')->fetchAll();
			pre($users);*/


			/*$this->db->where('id > ? ', 6)->delete('users');*/
			/*pre($this->db->where('id != ?',2)->fetchAll('users'));
			echo "/////////".$this->db->rows();
			pre($this->db->fetchAll('users'));*/