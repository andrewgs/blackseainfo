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
		$this->db->order_by('date','DESC');
		$query = $this->db->get('news');
		return $query->result_array();
	}
	
	function read_news($count,$region){
		
		$sql = "SELECT * FROM news WHERE region IN (0,$region) ORDER BY date DESC LIMIT $count"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
?>