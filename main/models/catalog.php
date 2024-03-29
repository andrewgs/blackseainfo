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
	var $ctl_alias	= "";
	
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
		
		$this->db->select('ctl_id,ctl_name,ctl_short,ctl_note,ctl_type,ctl_subtype,ctl_price,ctl_alias');
		$this->db->where('ctl_region',$region);
		$this->db->order_by('ctl_type','ASC');
		$query = $this->db->get('catalog');
		return $query->result_array();
	}
	
	function read_catalog_class_zone($region,$subtype){
		
		$this->db->select('ctl_id,ctl_name,ctl_short,ctl_note,ctl_type,ctl_subtype,ctl_price,ctl_alias');
		$this->db->where('ctl_subtype',$subtype);
		$this->db->where('ctl_region',$region);
		$this->db->order_by('ctl_type','ASC');
		$query = $this->db->get('catalog');
		return $query->result_array();
	}

	function read_subtype_zone($region,$type){
		
		$this->db->select('ctl_id,ctl_name,ctl_short,ctl_note,ctl_type,ctl_subtype,ctl_price,ctl_alias');
		$this->db->where('ctl_region',$region);
		$this->db->where('ctl_subtype',$type);
		$this->db->order_by('ctl_type','ASC');
		$query = $this->db->get('catalog');
		return $query->result_array();
	}
	
	function read_unit($unit){
		
		$this->db->select('ctl_id,ctl_name,ctl_note,ctl_subtype,ctl_price,ctl_alias');
		$this->db->where('ctl_id',$unit);
		$query = $this->db->get('catalog',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}

	function insert_record($insertdata){
		
		$this->ctl_name 	= $insertdata['name'];
		$this->ctl_short	= $insertdata['short'];
		$this->ctl_note		= $insertdata['note'];
		$this->ctl_price	= $insertdata['price'];
		$this->ctl_image	= $insertdata['image'];
		$this->ctl_type		= $insertdata['type'];
		$this->ctl_subtype	= $insertdata['class'];
		$this->ctl_region	= $insertdata['region'];
		$this->ctl_alias	= $insertdata['alias'];
		$this->db->insert('catalog',$this);
		return $this->db->insert_id();
	}

	function unit_exist($alias,$region){
		
		$this->db->select('ctl_id');
		$this->db->where('ctl_alias',$alias);
		$this->db->where('ctl_region',$region);
		$query = $this->db->get('catalog',1);
		$data = $query->result_array();
		if(count($data)>0) return $data[0]['ctl_id'];
		return FALSE;
	}
	
	function read_name($id){
		
		$this->db->select('ctl_name');
		$this->db->where('ctl_id',$id);
		$query = $this->db->get('catalog');
		$data = $query->result_array();
		if(count($data)) return $data[0]['ctl_name'];
		else NULL;
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