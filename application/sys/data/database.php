<?php 
defined('_PHPMVC2') or die;

final class Database
{
	public $isConnected;
	protected $db;
	
	public function __construct($type, $host, $dbname, $username, $password, $options=array()){
		$this->isConnected = true;
		try { 
			$this->db = new PDO("{$type}:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			//$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} 
		catch(PDOException $e) { 
			$this->isConnected = false;
			throw new Exception($e->getMessage());
		}
	}
	public function getPDO(){
		return $this->db;
	}
	
	public function Disconnect(){
		$this->db = null;
		$this->isConnected = false;
	}
	
	public function getRow($query, $params=array()){
		try { 
			$stmt = $this->db->prepare($query); 
			$stmt->execute($params);
			return $stmt->fetch();  
		}
		catch(PDOException $e){
			throw new Exception($e->getMessage());
		}
	}
	
	public function getRows($query, $params=array()){
		try { 
			$stmt = $this->db->prepare($query); 
			$stmt->execute($params);
			return $stmt->fetchAll();       
		}
		catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}       
	}
	
	public function executeNonQuery($query, $params=array()){
		try { 
			$stmt = $this->db->prepare($query); 
			$stmt->execute($params);
		}
		catch(PDOException $e){
			throw new Exception($e->getMessage());
		}           
	}
}