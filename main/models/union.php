<?php

class Union extends CI_Model {
	
	function __construct(){
        
		parent::__construct();
    }
	
	function zone_subtype($region){
		
		$query = "SELECT tps_name,tps_alias FROM types INNER JOIN catalog ON tps_id = ctl_subtype WHERE ctl_region = $region GROUP BY tps_name";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		else return null;
	}
	
	function limit_all_zone_booking($count,$from){
		
		$query = "SELECT booking.id,booking.fio,booking.note,booking.date,booking.email,booking.phone,catalog.ctl_id,catalog.ctl_name,catalog.ctl_alias,regions.reg_district,regions.reg_name,regions.reg_alias FROM booking INNER JOIN catalog ON unit_id = ctl_id INNER JOIN regions ON region_id = reg_id ORDER BY booking.date DESC LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		else return null;
	}
	
	function limit_zone_booking($region,$count,$from){
		
		$query = "SELECT booking.id,booking.fio,booking.note,booking.date,booking.email,booking.phone,catalog.ctl_id,catalog.ctl_name,catalog.ctl_alias,regions.reg_district,regions.reg_name,regions.reg_alias FROM booking INNER JOIN catalog ON unit_id = ctl_id INNER JOIN regions ON region_id = reg_id WHERE booking.region_id = $region ORDER BY booking.date DESC LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		else return null;
	}
}
?>