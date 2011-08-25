<?php
class Users extends CI_Model {

	var $uid 			= 0;	/* идентификатор пользователя*/
	var $uemail 		= '';	/* логин пользователя*/
	var $upassword 		= '';	/* пароль пользователя*/
	var $uname 			= '';	/* имя пользователя*/
	var $ucryptpassword	= '';	
	
	function __construct(){
    
		parent::__construct();
	}

	function read_record($id){
		
		$this->db->where('uid',$id);
		$query = $this->db->get('users',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function read_info($id){
		
		$this->db->select('uid,upassword,uname,uemail');
		$this->db->where('uid',$id);
		$query = $this->db->get('users');
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return FALSE;
	}
	
	function save_single_data($uid,$field,$data){
		
		$this->db->where('uid',$uid);
		$this->db->set($field,$data);
		$this->db->update('users');
		return $this->db->affected_rows();
	}
	
	function update_data($uid,$data){
		
		$this->db->where('uid',$uid);
		$this->db->set('uname',$data['name']);
		$this->db->set('uemail',$data['login']);
		$this->db->set('upassword',$data['newpass']);
		$this->db->set('ucryptpassword',$this->encrypt->encode($data['newpass']));
		$this->db->update('users');
		return $this->db->affected_rows();
	}
	
	function auth_user($login,$password){
		
		$this->db->where('uemail',$login);
		$this->db->where('upassword',md5($password));
		$query = $this->db->get('users',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}

	function update_password($password,$id){
			
		$this->db->set('upassword',md5($password));
		$this->db->where('uid',$id);
		$this->db->update('users');
		$res = $this->db->affected_rows();
		if($res == 0) return FALSE;
		return TRUE;
	}
	
	function user_exist($field,$parameter){
			
		$this->db->where($field,$parameter);
		$query = $this->db->get('users',1);
		$data = $query->result_array();
		if(count($data)) return $data[0]['uid'];
		return FALSE;
	}
	
		
	function read_field($uid,$field){
			
		$this->db->where('uid',$uid);
		$query = $this->db->get('users',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0][$field];
		return FALSE;
	}
	
	function get_image($id){
	
		$this->db->where('uid',$id);
		$this->db->select('uphoto');
		$query = $this->db->get('users');
		$data = $query->result_array();
		return $data[0]['uphoto'];
	}

	function get_simage($id){
	
		$this->db->where('uid',$id);
		$this->db->select('uphoto');
		$query = $this->db->get('users');
		$data = $query->result_array();
		return $data[0]['usphoto'];
	}
}
?>