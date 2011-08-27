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
		
		$this->db->where('date <=',date("Y-m-d"));
		$this->db->order_by('date','DESC');
		$query = $this->db->get('news');
		return $query->result_array();
	}
	
	function read_record($id){
	
		$this->db->where('id',$id);
		$query = $this->db->get('news',1);
		$data = $query->result_array();
		if(count($data)) return $data[0];
		return NULL;
	}
	
	function insert_record($data){
			
		$this->title	= $data['title'];
		$this->text		= $data['text'];
		$this->date		= $data['date'];
		$this->region 	= $data['region'];
		$this->db->insert('news',$this);
		return $this->db->insert_id();
	}

	function update_record($id,$data){
			
		$this->db->set('title',$data['title']);
		$this->db->set('text',$data['text']);
		$this->db->set('date',$data['date']);
		$this->db->where('id',$id);
		$this->db->update('news');
		return $this->db->affected_rows();
	}
	
	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('news');
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
		
		$this->db->where('date <=',date("Y-m-d"));
		$this->db->where('region',$region);
		$this->db->or_where('region',0);
		$this->db->limit($count,$from);
		$this->db->order_by('date DESC');
		$query = $this->db->get('news');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function read_limit_zone($region,$count,$from){
		
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