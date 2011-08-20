<?php

class Types extends CI_Model {
	
	var $tps_id 	= 0;
	var $tps_name 	= "";
	var $tps_group	= 0;
	
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
}
?>