<?php

class Types extends CI_Model {
	
	var $tps_id 	= 0;
	var $tps_name 	= "";
	var $tps_group	= 0;
	var $tps_visible= 1;
	var $tps_alias	= "";
	
	function __construct(){
        
		parent::__construct();
    }
	
	function read_records(){
		
		$this->db->order_by('tps_group','ASC');
		$query = $this->db->get('types');
		return $query->result_array();
	}
	
	function read_group($group){
		
		$this->db->where('tps_group',$group);
		$query = $this->db->get('types');
		return $query->result_array();
		if(count($data)) return $data;
		else NULL;
	}
	
	function read_groups(){
		
		$this->db->where('tps_visible',1);
		$this->db->order_by('tps_group','ASC');
		$this->db->order_by('tps_name','ASC');
		$query = $this->db->get('types');
		return $query->result_array();
		if(count($data)) return $data;
		else NULL;
	}
	
	function read_name($type){
		
		$this->db->select('tps_name');
		$this->db->where('tps_id',$type);
		$query = $this->db->get('types',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0]['tps_name'];
		return NULL;
	}
	
	function type_exist($alias){
		
		$this->db->select('tps_id');
		$this->db->where('tps_alias',$alias);
		$query = $this->db->get('types',1);
		$data = $query->result_array();
		if(count($data)) return $data[0]['tps_id'];
		return FALSE;
	}
}
?>