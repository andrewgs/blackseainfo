<?php

class Materials extends CI_Model {
	
	var $id 	= 0;
	var $title 	= "";
	var $note	= "";
	var $link	= "";
	var $type	= 0;
	var $region	= 0;
	var $image	= '';
	var $thumb	= '';
	
	function __construct(){
        
		parent::__construct();
    }
	
	function read_records($region,$type){
		
		$this->db->select('id,title,note,link,type,region');
		$this->db->where('region',$region);
		$this->db->where('type',$type);
		$this->db->order_by('title','ASC');
		$query = $this->db->get('materials');
		return $query->result_array();
	}
	
	function read_limit_records($region,$count,$type){
		
		$sql = "SELECT id,title,note,link,type,region FROM materials WHERE region = $region AND type = $type ORDER BY rand() LIMIT $count"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function no_zone_records($count,$type){
		
		$sql = "SELECT id,title,note,link,type,region FROM materials WHERE type = $type ORDER BY rand() LIMIT $count"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function main_slide($count,$type){
		
		$sql = "SELECT id,title,note FROM materials WHERE type = $type ORDER BY rand() LIMIT $count"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function insert_record($data){
			
		$this->title	= $data['title'];
		$this->note		= $data['note'];
		$this->link		= $data['link'];
		$this->type		= $data['type'];
		$this->region 	= $data['region'];
		$this->image 	= $data['image'];
		$this->thumb 	= $data['thumb'];
		$this->db->insert('materials',$this);
		return $this->db->insert_id();
	}

	function delete_record($id){
	
		$this->db->where('id',$id);
		$this->db->delete('materials');
		return $this->db->affected_rows();
	}
	
	function get_image($id){
	
		$this->db->where('id',$id);
		$this->db->select('image');
		$query = $this->db->get('materials');
		$data = $query->result_array();
		return $data[0]['image'];
	}
	
	function get_thumb($id){
	
		$this->db->where('id',$id);
		$this->db->select('thumb');
		$query = $this->db->get('materials');
		$data = $query->result_array();
		return $data[0]['thumb'];
	}
}
?>