<?php

class Reviews extends CI_Model {
	
	var $rew_id 		= 0;
	var $rew_author 	= "";
	var $rew_note		= "";
	
	function __construct(){
        
		parent::__construct();
    }
	
	function read_records(){
		
		$query = $this->db->get('reviews');
		return $query->result_array();
	}
	
	function read_reviews($count){
		
		$sql = "SELECT * FROM reviews ORDER BY rand() LIMIT $count"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
?>