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
}
?>