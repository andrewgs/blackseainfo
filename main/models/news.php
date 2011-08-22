<?php

class News extends CI_Model {
	
	var $id 	= 0;
	var $title 	= "";
	var $text	= "";
	var $region	= "";
	var $date	= "";
	
	function __construct(){
        
		parent::__construct();
    }
	
	function read_records(){
		$this->db->order_by('date','DESC');
		$query = $this->db->get('news');
		return $query->result_array();
	}
	
	function read_record($id){
	
		$this->db->where('id',$id);
		$this->db->order_by('date','DESC');
		$query = $this->db->get('news',1);
		$data = $query->result_array();
		if(count($data)) return $data[0];
		return NULL;
	}
	
	function read_news($count,$region){
		
		$sql = "SELECT * FROM news WHERE region IN (0,$region) ORDER BY date DESC LIMIT $count"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function count_records($region){
		
		$this->db->select('count(*) as cnt');
		$this->db->where('region',$region);
		$this->db->order_by('date DESC');
		$query = $this->db->get('news');
		$data = $query->result_array();
		return $data[0]['cnt'];
	}
	
	function read_limit_records($region,$count,$from){
		
		$this->db->where('region',$region);
		$this->db->limit($count,$from);
		$this->db->order_by('date DESC');
		$query = $this->db->get('news');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
}
?>