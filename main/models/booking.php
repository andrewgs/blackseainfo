<?php

class Booking extends CI_Model {
	
	var $id 		= 0;
	var $fio 		= "";
	var $note		= "";
	var $date		= "";
	var $unit_id	= "";
	var $region_id	= "";
	var $type_id	= "";
	var $email		= "";
	var $phone		= "";
	
	function __construct(){
        
		parent::__construct();
    }
	
	function read_records(){
		
		$query = $this->db->get('booking');
		return $query->result_array();
	}
	
	function read_reviews($count){
		
		$sql = "SELECT * FROM booking ORDER BY rand() LIMIT $count"; 
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function count_records(){
		
		$this->db->select('count(*) as cnt');
		$this->db->order_by('id DESC');
		$query = $this->db->get('booking');
		$data = $query->result_array();
		return $data[0]['cnt'];
	}
	
	function read_limit_records($count,$from){
		
		$this->db->limit($count,$from);
		$this->db->order_by('id DESC');
		$query = $this->db->get('booking');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}

	function insert_record($region,$type,$insert){
		
		$this->fio = $insert['fio'];
		$this->note = $insert['note'];
		$this->date = date("Y-m-d");
		$this->unit_id = $insert['catalog'];
		$this->region_id = $region;
		$this->type_id = $type;
		$this->email = $insert['email'];
		$this->phone = $insert['phone'];
		
		$this->db->insert('booking',$this);
	}
}
?>