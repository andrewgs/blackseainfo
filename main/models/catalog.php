<?php

class Catalog extends CI_Model {
	
	var $ctl_id 	= 0;
	var $ctl_name 	= "";
	var $ctl_short	= "";
	var $ctl_note	= "";
	var $ctl_image	= "";
	var $ctl_type	= 0;
	var $ctl_subtype= 0;
	var $ctl_region	= 0;
	var $ctl_price	= "";
	
	function __construct(){
        
		parent::__construct();
    }
	
	function read_records(){
		
		$this->db->order_by('ctl_region','ASC');
		$this->db->order_by('ctl_type','ASC');
		$query = $this->db->get('catalog');
		return $query->result_array();
	}
	
	function read_catalog_zone($region){
		
		$this->db->select('ctl_id,ctl_name,ctl_short,ctl_note,ctl_type,ctl_subtype,ctl_price');
		$this->db->where('ctl_region',$region);
		$this->db->order_by('ctl_type','ASC');
		$query = $this->db->get('catalog');
		return $query->result_array();
	}

	function read_subtype_zone($region,$type){
		
		$this->db->select('ctl_id,ctl_name,ctl_short,ctl_note,ctl_type,ctl_subtype,ctl_price');
		$this->db->where('ctl_region',$region);
		$this->db->where('ctl_subtype',$type);
		$this->db->order_by('ctl_type','ASC');
		$query = $this->db->get('catalog');
		return $query->result_array();
	}
	
	function read_unit($unit){
		
		$this->db->select('ctl_id,ctl_name,ctl_note,ctl_subtype,ctl_price');
		$this->db->where('ctl_id',$unit);
		$query = $this->db->get('catalog',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}

	function unit_exist($unit){
		
		$this->db->where('ctl_id',$unit);
		$query = $this->db->get('catalog',1);
		$data = $query->result_array();
		if(count($data)>0) return TRUE;
		return FALSE;
	}
	
	function get_image($id){
	
		$this->db->where('ctl_id',$id);
		$this->db->select('ctl_image');
		$query = $this->db->get('catalog');
		$data = $query->result_array();
		return $data[0]['ctl_image'];
	}
}
?>