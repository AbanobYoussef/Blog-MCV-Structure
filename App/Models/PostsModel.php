<?php
  
namespace App\Models; 
   
use System\Model;

class PostsModel extends Model
{
	
	protected $table='posts';


	public function all()
	{
		return $this->select('p.*','c.name AS `category`','u.first_name','u.second_name')
			         ->from('posts p')
					 ->join('LEFT JOIN categories c ON p.category_id=c.id')
					 ->join('LEFT JOIN users u ON p.user_id=u.id')
					 ->fetchAll();
	}


	public function create()
	{
		$image=$this->uploadImage();
		$user=$this->load->model('Login')->user();
		if($this->all())
		{
			$relatedPosts=array_filter($this->request->post('related_posts'),'is_numeric');
			$this->data('related_posts',implode(',',$relatedPosts));
		}
		$this->data('title',$this->request->post('title'))
		->data('image',$image)
		->data('details',$this->request->post('details'))
		->data('category_id',$this->request->post('category_id'))
		->data('user_id',$user->id)
		->data('status',$this->request->post('status'))
		->data('tags',$this->request->post('tags'))
		->data('created',$now=time())
		->insert($this->table);
	    
	}
  

	private function uploadImage()
	{
		$image=$this->request->file('image');
		if(! $image->exists())
		{ 
			return null;
		}

		return $image->moveTo($this->app->file->toPublic('images'));
	}




	public function update($id)
	{
		$image=$this->uploadImage();
		if($image)
		{
			$this->data('image',$image);
		}
			if($this->request->post('related_posts'))
			{
				$relatedPosts=array_filter($this->request->post('related_posts'),'is_numeric');
				$this->data('related_posts',implode(',',$relatedPosts));
			}

			$this->data('title',$this->request->post('title'))
		         ->data('details',$this->request->post('details'))
		         ->data('category_id',$this->request->post('category_id'))
		         ->data('status',$this->request->post('status'))
		         ->data('tags',$this->request->post('tags'))
		         ->where('id=?',$id)
		    	 ->update($this->table);
	}

	 public function latest()
    {
        // get the latest added posts
        return $this->select('p.*','c.name AS `category`','u.first_name','u.second_name')
                    ->select('(SELECT COUNT(co.id) FROM comments co WHERE co.post_id=p.id) AS total_comments')
			         ->from('posts p')
					 ->join('LEFT JOIN categories c ON p.category_id=c.id')
					 ->join('LEFT JOIN users u ON p.user_id=u.id')
                     ->where('p.status=?', 'enabled')
                     ->orderBy('p.id', 'DESC')
					 ->fetchAll();
    }



     public function getPostWithComments($id)
    {
        $post = $this->select('p.*', 'c.name AS `category`', 'u.first_name', 'u.second_name', 'u.image AS userImage')
                     ->from('posts p')
                     ->join('LEFT JOIN categories c ON p.category_id=c.id')
                     ->join('LEFT JOIN users u ON p.user_id=u.id')
                     ->where('p.id=? AND p.status=?', $id, 'enabled')
                     ->fetch();

        if (! $post) return null;

        // we will get the post comments
        // and each comment we will get for him the user name
        // who created that comment
        $post->comments = $this->select('c.*', 'u.first_name', 'u.second_name', 'u.image AS userImage')
                               ->from('comments c')
                               ->join('LEFT JOIN users u ON c.user_id=u.id')
                               ->where('c.post_id=?', $id)
                               ->fetchAll();

        return $post;
    }



    public function addNewComment($id, $comment, $userId)
    {
        $this->data('post_id', $id)
             ->data('comment', $comment)
             ->data('status', 'enabled')
             ->data('created', time())
             ->data('user_id', $userId)
             ->insert('comments');
    }
 

}