<?php
  
namespace App\Models; 
   
use System\Model;

class AdsModel extends Model
{
	
	protected $table='ads';


	public function create()
	{
		$image=$this->uploadImage();
		if($image)
		{
			$this->data('image',$image);
		}
		$this->data('name',$this->request->post('name'))
		->data('link',$this->request->post('link'))
		->data('start_at',strtotime($this->request->post('start_at')))
		->data('end_at',strtotime($this->request->post('end_at')))

		->data('status',$this->request->post('status'))
		->data('page',$this->request->post('page'))
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
			if($this->request->post('related_ads'))
			{
				$relatedAds=array_filter($this->request->post('related_ads'),'is_numeric');
				$this->data('related_ads',implode(',',$relatedAds));
			}

			$this->data('name',$this->request->post('name'))
				->data('link',$this->request->post('link'))
				->data('start_at',strtotime($this->request->post('start_at')))
				->data('end_at',strtotime($this->request->post('end_at')))

				->data('status',$this->request->post('status'))
				->data('page',$this->request->post('page'))
				->data('created',$now=time())
		         ->where('id=?',$id)
		    	 ->update($this->table);
	}


	public function enabled()
     {
         $currentRoute = $this->route->getCurrentRoute();

         $now = time();

         return $this->where('status=? AND page=? AND start_at <= ? AND end_at >= ?', 'enabled', $currentRoute, $now, $now)->fetchAll($this->table);
     }
 

}