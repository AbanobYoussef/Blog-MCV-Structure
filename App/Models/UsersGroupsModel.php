<?php
 
namespace App\Models;

use System\Model;

class UsersGroupsModel extends Model
{
	
	protected $table='users_groups';

 

 
	public function create()
	{
		$UsgID=$this->data('name',$this->request->post('UGName'))
			       ->insert($this->table)->lastId();
	    // Remove any emapty vaule in the array 
	    
	    $pages = $this->request->post('pages');

	    if($pages)
	    {
	    	foreach ($pages as $page) 
	    	{
	    	 $this->data('users_group_id',$UsgID)
	    		 ->data('page',$page)
	    		 ->insert('users_group_permision');
	    	}
	    }
	}
 

	public function get($id)
	{
		$UG=parent::get($id);
		if($UG)
		{

			$pages=$this->select('page')
			            ->where('users_group_id =?',$UG->id)
		                ->fetchAll('users_group_permision');

		    $UG->pages=[];
		   if($pages)
			{
				foreach ($pages as $page) {
					$UG->pages[]=$page->page;
				}
			}
		}
		

		return $UG;
	}

	public function update($id)
	{
		$this->data(/*Table name*/'name',$this->request->post('UGName'))
			// ->data('status',$this->request->post('status'))
			 ->where('id=?',$id)
			 ->update($this->table);
	}


}

