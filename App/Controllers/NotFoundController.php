<?php

namespace App\Controllers;
 use System\Controller;
class NotFoundController extends Controller {


	public function index()
	{
		
		return $this->view->render('Not Found');
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