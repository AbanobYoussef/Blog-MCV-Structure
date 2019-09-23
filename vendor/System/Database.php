<?php 
namespace System;

use PDO;
use PDOException;
class Database
{
	private $app;
	private static $connection;
	private $table;
	private $data=[];
	private $bindings=[];
	private $lastId;
	private $wheres=[];
	private $having=[];
	private $groupBy=[];
	private $selects=[];
	private $joins=[];
	private $limit;
	private $offset;
	private $orderBy=[];
	private $rows=0;

	public function __construct(Application $app)
	{
		$this->app=$app;
		if(!$this->isConnected())
		{
			$this->connect();
		}
	}

//////////////////////////////////////////////////
	private function isConnected()
	{
		 return static::$connection instanceof PDO;//to make sure that there is a connection (return bool resulte)
	}
////////////////////////////////////////////////////

	private function connect()
	{
		$connectionData=$this->app->file->call('config.php');
		extract($connectionData);
		try
		{
			static::$connection =new PDO('mysql:host='.$server.';dbname='.$dbname,$dbuser,$dbpass);
			static::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
			static::$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			static::$connection->exec('SET NAMES utf8');
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}

		//echo $this->isConnected();
	}

//////////////////////////////////////////////////////
	public function connection()
	{
		return static::$connection;
	}
//////////////////////////////////////////////////////
	public function select()
	{
		$selects=func_get_args();
		$this->selects=array_merge($this->selects,$selects);
		return $this;
	}
//////////////////////////////////////////////////////
public function join($select)
	{
		$this->joins[]=$select;
		return $this;
	}
//////////////////////////////////////////////////////
	public function limit($limit,$offset=0)
	{
		$this->limit=$limit;
		$this->offset=$offset;
		return $this;
	}
//////////////////////////////////////////////////////
	public function orderBy($orderBy,$sort='ASC')
	{
		$this->orderBy=[$orderBy,$sort];
		return $this;
	}
//////////////////////////////////////////////////////
	public function fetch($table=null)
	{
		if($table){
			$this->table($table);
		}
		$sql=$this->fetchStatement();
		$result=$this->query($sql,$this->bindings)->fetch();
		$this->reset();
		return $result;
	}
//////////////////////////////////////////////////////
	public function fetchAll($table=null)
	{
		if($table){
			$this->table($table);
		}

	    
		$sql=$this->fetchStatement();
		$query=$this->query($sql,$this->bindings);
		$results=$query->fetchAll();
		$this->rows=$query->rowCount();
		$this->reset();
		return $results;
	}
//////////////////////////////////////////////////////
	public function rows()
	{
		return $this->rows;
	}
/////////////////////////////////////////////////////
private	 function fetchStatement()
{
	//////////////////////////////
	$sql='SELECT ';
	if($this->selects)
	{
		$sql.=implode(',', $this->selects);
	}
	else
	{
		$sql.='*';
	}
	$sql.=' FROM '.$this->table.' ';
	////////////////////////////////
	if($this->joins)
	{
		$sql.=implode(' ', $this->joins);
	}
	if($this->wheres)
	{
		$sql.=' WHERE '.implode(' ', $this->wheres).' ';
	}
	
	if($this->having)
	{
		$sql.=' HAVING '.implode(' ',$this->having).' ';
	}
	if($this->orderBy)
	{
		$sql.=' ORDER BY '.implode(' ', $this->orderBy).' ';
	}
	if($this->groupBy)
	{
		$sql.=' GROUP BY '.implode(' ', $this->groupBy).' ';
	}
	if($this->limit)
	{
		$sql.=' LIMIT '. $this->limit;
	}
	if($this->offset)
	{
		$sql.=' OFFSET '.$this->offset;
	}
	return $sql;

}
//////////////////////////////////////////////////////
	public function table($table)
	{
		$this->table=$table;
		
		return $this;
	} 
//////////////////////////////////////////////////////
	public function from($table)
	{
		return $this->table($table);
	} 
//////////////////////////////////////////////////////
	public function data($key,$value=null)
	{
		 if(is_array($key))
		 {
		 	$this->data=array_merge($this->data,$key);
		 	$this->addToBindings($key);
		 }
		 else
		 {
		 	$this->data[$key]=$value;
		 	$this->addToBindings($value);
		 }
		 return $this;
	}
//////////////////////////////////////////////////////
	private function addToBindings($value)
	{
		if (is_array($value))
		 {
		 	$this->bindings=array_merge($this->bindings,array_values($value ));
		 }
		else
		{
			$this->bindings[]=$value;
		}
	}
//////////////////////////////////////////////////////
	public function lastId()
	{
		return $this->lastId;
	}
//////////////////////////////////////////////////////
	public function where()
	{
		$bindings=func_get_args();
		$sql=array_shift($bindings);
		$this->addToBindings($bindings);
		$this->wheres[]=$sql;
		return $this;
	}
//////////////////////////////////////////////////////
	public function having()
	{
		$bindings=func_get_args();
		$sql=array_shift($bindings);
		$this->addToBindings($bindings);
		$this->having[]=$sql;
		return $this;
	}
//////////////////////////////////////////////////////
	public function grougBy(...$arguments)
	{
		$this->grougBy=$arguments;
		return $this;
	}
//////////////////////////////////////////////////////
	private function setField()
	{
		$sql='';
		foreach ($this->data as $key => $value) {
		 	$sql.='`'.$key.'` = ? , ';
		 }
		 $sql=rtrim($sql,', ');
		 return $sql;
	}
//////////////////////////////////////////////////////
	public function query()
	{
		$bindings=func_get_args();
		$sql=array_shift($bindings);

		if(count($bindings)==1 AND is_array($bindings[0]))
		{
			$bindings=$bindings[0];
		}

		try
		{
				//$query=static::$connection->query($sql);

				$query=$this->connection()->prepare($sql);
				/*pre($query);
				echo "<br>";*/
				foreach ($bindings as $key => $value) {
					$query->bindValue($key+1, _e($value));
				}
				$query->execute();
				$this->reset();
				return $query;
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}
//////////////////////////////////////////////////////
	public function insert($table=null)
	{
		 if($table)
		 {
		 	$this->table($table);
		 }
		 $sql='INSERT INTO '.$this->table.' SET ';
		 $sql.=$this->setField();
		 $this->query($sql,$this->bindings);
		 $this->lastId=$this->connection()->lastInsertId();
		 return $this;
	}
//////////////////////////////////////////////////////
	public function update($table=null)
	{
		 if($table)
		 {
		 	$this->table($table);
		 }
		 $sql=' UPDATE '.$this->table.' SET ';
		 $sql.=$this->setField();
		 if($this->wheres){

		 	$sql .=' WHERE '.implode(' ', $this->wheres); 
		 }
		 $this->query($sql,$this->bindings);
		 return $this;
	}
///////////////////////////////////////////////////
	public function delete($table=null)
	{
		 if($table)
		 {
		 	$this->table($table);
		 }
		 $sql=' DELETE FROM '.$this->table.' ';
		 if($this->wheres){

		 	$sql .=' WHERE '.implode(' ', $this->wheres); 
		 }
		 $this->query($sql,$this->bindings);
		 return $this;
	}
///////////////////////////////////////////////////
	public function reset()
	{
		$this->table=null;
		$this->limit=null;
		$this->offset=null;
		$this->data=[];
		$this->bindings=[];
		$this->wheres=[];
		$this->selects=[];
		$this->joins=[];
		$this->orderBy=[];
	    $this->having=[];
	    $this->groupBy=[];

	}


	public function showData()
	{
		return $this->data;
	}

}