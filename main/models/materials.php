<?php

class Materials extends CI_Model {
	
	var $id 	= 0;
	var $title 	= "";
	var $note	= "";
	var $link	= "";
	var $type	= 0;
	var $region	= 0;
	
	function __construct(){
        
		parent::__construct();
    }
	
	function read_records($region,$type){
	
		$this->db->where('region',$region);
		$this->db->where('type',$type);
		$this->db->order_by('title','ASC');
		$query = $this->db->get('materials');
		return $query->result_array();
	}
}
?>