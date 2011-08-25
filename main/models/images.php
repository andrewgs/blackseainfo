<?php

class Images extends CI_Model {
	
	var $id 	= 0;
	var $unit	= 0;
	var $title 	= "";
	var $thumb	= 0;
	var $image	= 0;
	
	function __construct(){
        
		parent::__construct();
    }
	
	function read_records($unit){
		
		$this->db->select('id,title');
		$this->db->where('unit',$unit);
		$this->db->order_by('title','ASC');
		$query = $this->db->get('images');
		return $query->result_array();
	}
	
	function read_limit_records($unit,$count){
		
		$sql = "SELECT id,title FROM images WHERE unit = $unit ORDER BY rand() LIMIT $count"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_image($id){
	
		$this->db->where('id',$id);
		$this->db->select('image');
		$query = $this->db->get('images');
		$data = $query->result_array();
		return $data[0]['image'];
	}
	
	function get_thumb($id){
	
		$this->db->where('id',$id);
		$this->db->select('thumb');
		$query = $this->db->get('images');
		$data = $query->result_array();
		return $data[0]['thumb'];
	}
}
?>