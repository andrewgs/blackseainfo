<?php

class Regions extends CI_Model {
	
	var $reg_id 		= 0;
	var $reg_name 		= "";
	var $reg_area 		= "";
	var $reg_district	= "";
	var $reg_priority	= 0;
	var $reg_alias		= "";
	
	function __construct(){
        
		parent::__construct();
    }
	
	function read_records(){
		
		$this->db->order_by('reg_priority','ASC');
		$this->db->order_by('reg_district','ASC');
		$this->db->order_by('reg_area','ASC');
		$this->db->order_by('reg_name','ASC');
		$query = $this->db->get('regions');
		return $query->result_array();
	}
	
	function read_city($id){
		
		$this->db->select('reg_name, reg_district');
		$this->db->where('reg_id',$id);
		$query = $this->db->get('regions');
		$data = $query->result_array();
		if(count($data)) return $data[0]['reg_name'].', '.$data[0]['reg_district'];
		else NULL;
	}
	
	function read_record($id){
		
		$this->db->where('reg_id',$id);
		$query = $this->db->get('regions',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	
	function insert_record($insertdata){
			
		$this->reg_name 	= $insertdata['name'];
		$this->reg_area		= $insertdata['area'];
		$this->reg_district	= $insertdata['district'];
		$this->db->insert('regions',$this);
		return $this->db->insert_id();
	}

	function save_region($id,$name,$area,$dictr){
	
		$this->db->set('reg_name',$name);
		$this->db->set('reg_area',$area);
		$this->db->set('reg_district',$dictr);
		$this->db->where('reg_id',$id);
		$this->db->update('regions');
		return $this->db->affected_rows();
	}

	function region_exist($alias){
		
		$this->db->select('reg_id');
		$this->db->where('reg_alias',$alias);
		$query = $this->db->get('regions',1);
		$data = $query->result_array();
		if(count($data)) return $data[0]['reg_id'];
		return FALSE;
	}
}
?>