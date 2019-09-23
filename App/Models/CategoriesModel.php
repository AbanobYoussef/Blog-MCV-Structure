<?php

namespace App\Models;

use System\Model;

class CategoriesModel extends Model
{
	
	protected $table='categories';

 


	public function create()
	{
		$this->data(/*Table name*/'name',$this->request->post('catName'))
			 ->data('status',$this->request->post('status'))
			 ->insert($this->table);
	}

	public function update($id)
	{
		$this->data(/*Table name*/'name',$this->request->post('catName'))
			 ->data('status',$this->request->post('status'))
			 ->where('id=?',$id)
			 ->update($this->table);
	}


	public function getEnabledCategoriesWithNumberOfTotalPosts()
    {
        

        if (! $this->app->isSharing('enabled-categories')) {
            
            $categories = $this->select('c.id', 'c.name')
                               ->select('(SELECT COUNT(p.id) FROM posts p WHERE p.status="enabled" AND p.category_id=c.id) AS total_posts')
                               ->from('categories c')
                               ->where('c.status=?' , 'enabled')
                               ->having('total_posts > 0')
                               ->fetchAll();

            $this->app->share('enabled-categories', $categories);
        }

        return $this->app->get('enabled-categories');
    }



     public function getCategoryWithPosts($id)
    {
        $category = $this->where('id=? AND status=?', $id, 'enabled')->fetch($this->table);

        if (! $category) return [];

        // We Will get the current page
        $currentPage = $this->pagination->page();
        // We Will get the items Per Page
        $limit = $this->pagination->itemsPerPage();

        // Set our offset
        $offset = $limit * ($currentPage - 1);

        $category->posts = $this->select('p.*', 'u.first_name', 'u.second_name')
                                ->select('(SELECT COUNT(co.id) FROM comments co WHERE co.post_id=p.id) AS total_comments')
                                ->from('posts p')
                                ->join('LEFT JOIN users u ON p.user_id=u.id')
                                ->where('p.category_id=? AND p.status=?', $id, 'enabled')
                                ->orderBy('p.id', 'DESC')
                                ->limit($limit, $offset)
                                ->fetchAll();

        // Get total posts for pagination
        $totalPosts = $this->select('COUNT(id) AS `total`')
                                ->from('posts')
                                ->where('category_id=? AND status=?', $id, 'enabled')
                                ->orderBy('id', 'DESC')
                                ->fetch();

        if ($totalPosts) {
            $this->pagination->setTotalItems($totalPosts->total);
        }

        return $category;
    }


}

