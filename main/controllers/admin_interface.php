<?php

class Admin_interface extends CI_Controller {

	var $user = array('uid'=>0,'uname'=>'','ulogin'=>'','upassword'=>'','status'=>FALSE);
	var $months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля",
						"05"=>"мая","06"=>"июня","07"=>"июля","08"=>"августа",
						"09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
	
	
	function __construct(){
	
		parent::__construct();
		
		$this->load->model('users');
		$this->load->model('regions');
		$this->load->model('booking');
		$this->load->model('union');
		$cookieuid = $this->session->userdata('login_id');
		if(isset($cookieuid) and !empty($cookieuid)):
			$this->user['uid'] = $this->session->userdata('userid');
			if($this->user['uid']):
				$userinfo = $this->users->read_info($this->user['uid']);
				if($userinfo):
					$this->user['uname']	 = $userinfo['uname'];
					$this->user['upassword'] = $userinfo['upassword'];
					$this->user['uemail'] 	 = $userinfo['uemail'];
					$this->user['status'] 	 = TRUE;
				endif;
			endif;
			
			if($this->session->userdata('login_id') != md5($this->user['uemail'].$this->user['upassword'])):
				$this->user['status'] = FALSE;
				$this->user = array();
				redirect('admin');
			endif;
		else:
			redirect('admin');
		endif;
	}
	
	function profile(){
	
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Профиль",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'status'		=>FALSE,
					'uri_string'	=> ''
			);
		if($this->input->post('submit')):
			$this->form_validation->set_rules('name','','required|htmlspecialchars|strip_tags|trim');
			$this->form_validation->set_rules('login','','valid_email|required|trim');
			$this->form_validation->set_rules('newpass','','trim|min_length[6]');
			$this->form_validation->set_rules('confpass','','matches[newpass]|trim');
			$this->form_validation->set_message('matches','Пароли не совпадают');
			$this->form_validation->set_message('min_length','Длина пароля должна быть не менее 6 символов');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->profile();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				if(empty($_POST['newpass'])):
					$_POST['newpass'] = $this->user['upassword'];
				else:
					$_POST['newpass'] = md5($_POST['newpass']);
				endif;
				$this->users->update_data($this->user['uid'],$_POST);
				$this->session->set_userdata('login_id',md5($_POST['login'].$_POST['newpass']));
				$this->session->set_userdata('saccessfull',TRUE);
				redirect($this->uri->uri_string());
			endif;
		endif;
		$saccessfull = $this->session->userdata('saccessfull');
		if($saccessfull):
			$this->session->unset_userdata('saccessfull');
			$pagevar['status'] = TRUE;
		endif;
		$this->load->view('admin_interface/profile',$pagevar);
	}

	function logout(){
	
		$this->session->sess_destroy();
		redirect('');
	}

	function booking(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Заявки",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> "Выберите зону отдыха",
					'books'			=> array(),
					'count'			=> 0,
					'pages'			=> '',
					'uri_string'	=> 'booking'
			);
			
		$pagevar['count'] = $this->booking->count_records();
		
		$config['base_url'] 		= $pagevar['baseurl'].'admin/booking/';
        $config['total_rows'] 		= $pagevar['count']; 
        $config['per_page'] 		= 5;
        $config['num_links'] 		= 4;
        $config['uri_segment'] 		= 3;
		$config['first_link']		= 'В начало';
		$config['last_link'] 		= 'В конец';
		$config['next_link'] 		= 'Далее &raquo;';
		$config['prev_link'] 		= '&laquo; Назад';
		$config['cur_tag_open']		= '<b>';
		$config['cur_tag_close'] 	= '</b>';
		$from = intval($this->uri->segment(3));
		$pagevar['books'] = $this->union->limit_all_zone_booking(5,$from);
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		$this->load->view('admin_interface/booking-all',$pagevar);
	}

	function zone_booking(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - ",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> "Сменить зону отдыха",
					'zone'			=> $this->regions->read_city($region),
					'books'			=> array(),
					'count'			=> 0,
					'pages'			=> '',
					'uri_string'	=> 'booking'
			);
		$pagevar['title'] .= $pagevar['zone'].', Заявки';
		
		$pagevar['count'] = $this->booking->count_region_records($region);
		
		$config['base_url'] 		= $pagevar['baseurl'].'admin/'.$this->uri->segment(2).'/booking/';
        $config['total_rows'] 		= $pagevar['count']; 
        $config['per_page'] 		= 5;
        $config['num_links'] 		= 4;
        $config['uri_segment'] 		= 4;
		$config['first_link']		= 'В начало';
		$config['last_link'] 		= 'В конец';
		$config['next_link'] 		= 'Далее &raquo;';
		$config['prev_link'] 		= '&laquo; Назад';
		$config['cur_tag_open']		= '<b>';
		$config['cur_tag_close'] 	= '</b>';
		$from = intval($this->uri->segment(4));
		$pagevar['books'] = $this->union->limit_zone_booking($region,5,$from);
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		
		$this->load->view('admin_interface/booking-zone',$pagevar);
	}

	function delete_zone_book(){
		
		$this->booking->delete_record($this->uri->segment(4));
		redirect('admin/'.$this->uri->segment(2).'/booking');
	}
	function delete_book(){
		
		$this->booking->delete_record($this->uri->segment(3));
		redirect('admin/booking');
	}
	
	/*********************************************************************************************************************/
	
	function operation_date($field){
			
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5 $nmonth \$1 г."; 
		return preg_replace($pattern, $replacement,$field);
	}

	function operation_date_slash($field){
		
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5/\$3/\$1"; 
		return preg_replace($pattern, $replacement,$field);
	}

	function operation_date_minus($field){
		
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5-\$3-\$1"; 
		return preg_replace($pattern, $replacement,$field);
	}
											
	function userfile_check($file){
		
		$tmpName = $_FILES['userfile']['tmp_name'];
		
		if($_FILES['userfile']['error'] == 4):
			$this->form_validation->set_message('userfile_check','Не указан файл');
			return FALSE;
		endif;
		if($_FILES['userfile']['error'] != 4):
			if(!$this->case_image($tmpName)):
				$this->form_validation->set_message('userfile_check','Формат не поддерживается');
				return FALSE;
			endif;
		endif;
		if($_FILES['userfile']['error'] == 1):
			$this->form_validation->set_message('userfile_check','Размер более 5 Мб!');
			return FALSE;
		endif;
		return TRUE;
	}
	
	function userfile_edit($file){
		
		$tmpName = $_FILES['userfile']['tmp_name'];
		
		/*if($_FILES['userfile']['error'] == 4):
			$this->form_validation->set_message('userfile_check','Не указан файл');
			return FALSE;
		endif;*/
		if($_FILES['userfile']['error'] != 4):
			if(!$this->case_image($tmpName)):
				$this->form_validation->set_message('userfile_check','Формат не поддерживается');
				return FALSE;
			endif;
		endif;
		if($_FILES['userfile']['error'] == 1):
			$this->form_validation->set_message('userfile_check','Размер более 5 Мб!');
			return FALSE;
		endif;
		return TRUE;
	}
	
	function resize_img($tmpName,$wgt,$hgt,$ratio){
			
		chmod($tmpName,0777);
		$img = getimagesize($tmpName);		
		$size_x = $img[0];
		$size_y = $img[1];
		$wight = $wgt;
		$height = $hgt; 
		if(($size_x < $wgt) or ($size_y < $hgt)):
			$this->resize_image($tmpName,$wgt,$hgt,FALSE);
			$image = file_get_contents($tmpName);
			return $image;
		endif;
		if($size_x > $size_y):
			$this->resize_image($tmpName,$size_x,$hgt,$ratio);
		else:
			$this->resize_image($tmpName,$wgt,$size_y,$ratio);
		endif;
		$img = getimagesize($tmpName);		
		$size_x = $img[0];
		$size_y = $img[1];
		switch ($img[2]){
			case 1: $image_src = imagecreatefromgif($tmpName); break;
			case 2: $image_src = imagecreatefromjpeg($tmpName); break;
			case 3:	$image_src = imagecreatefrompng($tmpName); break;
		}
		$x = round(($size_x/2)-($wgt/2));
		$y = round(($size_y/2)-($hgt/2));
		if($x < 0):
			$x = 0;	$wight = $size_x;
		endif;
		if($y < 0):
			$y = 0; $height = $size_y;
		endif;
		$image_dst = ImageCreateTrueColor($wight,$height);
		if($size_x > $size_y):
			imageCopy($image_dst,$image_src,0,0,$x,0,$wight,$height);
		else:
			imageCopy($image_dst,$image_src,0,0,$x,20,$wight,$height+20);
		endif;
		imagePNG($image_dst,$tmpName);
		imagedestroy($image_dst);
		imagedestroy($image_src);
		$image = file_get_contents($tmpName);
		return $image;
	}
													 				
	function resize_big_image($tmpName,$wgt,$hgt,$ratio){
			
		chmod($tmpName,0777);
		
		$img = getimagesize($tmpName);
		$this->resize_image($tmpName,$wgt,$img[1],$ratio);
		switch ($img[2]){
			case 1: $image_src = imagecreatefromgif($tmpName); break;
			case 2: $image_src = imagecreatefromjpeg($tmpName); break;
			case 3:	$image_src = imagecreatefrompng($tmpName); break;
		}
		
		$image_dst = ImageCreateTrueColor($wgt,$hgt);
		imageCopy($image_dst,$image_src,0,0,0,20,$wgt,$hgt);
		imagePNG($image_dst,$tmpName);
		imagedestroy($image_dst);
		imagedestroy($image_src);
		$image = file_get_contents($tmpName);
		return $image;
	}			
																		
	function resize_main_image($tmpName,$wgt,$hgt,$ratio){
			
		chmod($tmpName,0777);
		$img = getimagesize($tmpName);
		$this->load->library('image_lib');
		$this->image_lib->clear();
		$config['image_library'] 	= 'gd2';
		$config['source_image']		= $tmpName; 
		$config['create_thumb'] 	= FALSE;
		$config['maintain_ratio'] 	= $ratio;
		$config['quality'] 			= 100;
		$config['master_dim'] 		= 'width';
		$config['width'] 			= $wgt;
		$config['height'] 			= $hgt;
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		
		switch ($img[2]){
			case 1: $image_src = imagecreatefromgif($tmpName); break;
			case 2: $image_src = imagecreatefromjpeg($tmpName); break;
			case 3:	$image_src = imagecreatefrompng($tmpName); break;
		}
		$img = getimagesize($tmpName);
		$height = $img[1]-20;
		if($height>$hgt):
			$image_dst = ImageCreateTrueColor($wgt,$hgt);
		else:
			$image_dst = ImageCreateTrueColor($wgt,$img[1]-20);
		endif;
		imageCopy($image_dst,$image_src,0,0,0,20,$wgt,$img[1]+20);
		imagePNG($image_dst,$tmpName);
		imagedestroy($image_dst);
		imagedestroy($image_src);
		$image = file_get_contents($tmpName);
		return $image;
	}				

	function resize_image($image,$wgt,$hgt,$ratio){
	
		$this->load->library('image_lib');
		$this->image_lib->clear();
		$config['image_library'] 	= 'gd2';
		$config['source_image']		= $image; 
		$config['create_thumb'] 	= FALSE;
		$config['maintain_ratio'] 	= $ratio;
		$config['width'] 			= $wgt;
		$config['height'] 			= $hgt;
				
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}

	function resize_photo($tmpName,$wgt,$hgt,$ratio){
		
		chmod($tmpName,0777);
		$this->load->library('image_lib');
		$this->image_lib->clear();
		$config['image_library'] 	= 'gd2';
		$config['source_image']		= $tmpName; 
		$config['create_thumb'] 	= FALSE;
		$config['maintain_ratio'] 	= $ratio;
		$config['width'] 			= $wgt;
		$config['height'] 			= $hgt;
				
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		
		return file_get_contents($tmpName);
	}

	function case_image($file){
			
		$info = getimagesize($file);
		switch ($info[2]):
			case 1	: return TRUE;
			case 2	: return TRUE;
			case 3	: return TRUE;
			default	: return FALSE;	
		endswitch;
	}
}