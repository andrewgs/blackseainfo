<?php

class Catalog extends CI_Model {
	
	var $ctl_id 	= 0;
	var $ctl_name 	= "";
	var $ctl_short	= "";
	var $ctl_note	= "";
	var $ctl_image	= "";
	var $ctl_type	= 0;
	var $ctl_region	= 0;
	
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
		
		$this->db->select('ctl_id,ctl_name,ctl_short,ctl_note,ctl_type');
		$this->db->where('ctl_region',$region);
		$this->db->order_by('ctl_type','ASC');
		$query = $this->db->get('catalog');
		return $query->result_array();
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