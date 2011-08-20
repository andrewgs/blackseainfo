<?php

class Admin_interface extends CI_Controller {

	var $user = array('uid'=>0,'uname'=>'','ulogin'=>'','upassword'=>'','status'=>FALSE);
	var $months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля",
						"05"=>"мая","06"=>"июня","07"=>"июля","08"=>"августа",
						"09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
	
	
	function __construct(){
	
		parent::__construct();
		
		$this->load->model('usermodel');
		$this->load->model('units');
		$this->load->model('emails');
		$cookieuid = $this->session->userdata('login_id');
		if(isset($cookieuid) and !empty($cookieuid)):
			$this->user['uid'] = $this->session->userdata('userid');
			if($this->user['uid']):
				$userinfo = $this->usermodel->read_info($this->user['uid']);
				if($userinfo):
					$this->user['uname']	 = $userinfo['uname'];
					$this->user['ulogin'] 	 = $userinfo['ulogin'];
					$this->user['upassword'] = $userinfo['upassword'];
					$this->user['uemail'] 	 = $userinfo['uemail'];
					$this->user['status'] 	 = TRUE;
				endif;
			endif;
			
			if($this->session->userdata('login_id') != md5($this->user['ulogin'].$this->user['upassword'])):
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
					'title'			=> 'Администрирование - Авторизация',
					'baseurl' 		=> base_url(),
					'menu'			=> TRUE,
					'position'		=> 'style="left: 630px;"',
					'error'			=> FALSE,
					'userinfo'		=> $this->user,
					'status'		=> FALSE
			);
			
		if($this->input->post('submit')):
			$this->form_validation->set_rules('name','"Имя"','required|htmlspecialchars|strip_tags|trim');
			$this->form_validation->set_rules('email','"E-mail"','valid_email|required|trim');
			$this->form_validation->set_rules('newpass','"Новый пароль"','required|trim|min_length[6]');
			$this->form_validation->set_rules('confpass','"Подтвердите пароль"','required|matches[newpass]|trim');
			$this->form_validation->set_message('matches','Пароли не совпадают');
			$this->form_validation->set_message('min_length','Длина пароля должна быть не менее 6 символов');
			$this->form_validation->set_error_delimiters('<div class="fvalid_error">','</div>');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->profile();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$this->usermodel->update_data($this->user['uid'],$_POST);
				$this->session->set_userdata('login_id',md5($this->user['ulogin'].md5($_POST['newpass'])));
				$pagevar['status'] = TRUE;
			endif;
		endif;
		
		$this->load->view('admin_interface/profile',$pagevar);
	}

	function unit_add(){
	
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'Администрирование - Добавление ',
					'baseurl' 		=> base_url(),
					'menu'			=> FALSE,
					'position'		=> '',
					'link'			=> '',
					'error'			=> FALSE,
					'userinfo'		=> $this->user,
					'status'		=> FALSE
			);
		$dress = 0;
		if($this->uri->segment(2) == 'dress-add'):
			$pagevar['link'] = 'dresses';
			$pagevar['title'] .= ' платья';
			$dress = 1;
		elseif($this->uri->segment(2) == 'accessories-add'):
			$pagevar['link'] = 'accessories';
			$pagevar['title'] .= ' аксессуара';
		endif;
		if($this->input->post('submit')):
			$this->form_validation->set_rules('title','"Название"','required|htmlspecialchars|trim');
			$this->form_validation->set_rules('model','"Номер модели"','required|trim');
			$this->form_validation->set_rules('note','"Описание"','required|strip_tags|trim');
			$this->form_validation->set_rules('userfile','','callback_userfile_check');
			$this->form_validation->set_error_delimiters('<div class="fvalid_error">','</div>');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->unit_add();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				if($_FILES['userfile']['error'] != 4):
					$file = $_FILES['userfile']['tmp_name'];
					$newfile1 = $file.'.bak1';
					$newfile2 = $file.'.bak2';
					copy($file,$newfile1);
					copy($file,$newfile2);
					$_POST['image'] = $this->resize_main_image($file,500,800,TRUE);
					$_POST['bimage'] = $this->resize_big_image($newfile1,264,137,TRUE);
					$_POST['simage'] = $this->resize_img($newfile2,153,129,TRUE);
					unlink($newfile1);
					unlink($newfile2);
				else:
					$_POST['image'] = '';
				endif;
				$_POST['dress'] = $dress;
				$this->units->insert_record($_POST);
				redirect($pagevar['link']);
			endif;
		endif;
		$this->load->view('admin_interface/unit_add',$pagevar);
	}
	
	function unit_edit(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'Администрирование - Редактирование ',
					'baseurl' 		=> base_url(),
					'menu'			=> FALSE,
					'position'		=> '',
					'link'			=> '',
					'error'			=> FALSE,
					'userinfo'		=> $this->user,
					'status'		=> FALSE,
					'unit'			=> array()
			);
		$dress = 0;
		if($this->uri->segment(2) == 'dress-edit'):
			$pagevar['link'] = 'dresses';
			$pagevar['title'] .= ' платья';
			$dress = 1;
		elseif($this->uri->segment(2) == 'accessories-edit'):
			$pagevar['link'] = 'accessories';
			$pagevar['title'] .= ' аксессуара';
		endif;
		if($this->input->post('submit')):
			$this->form_validation->set_rules('title','"Название"','required|htmlspecialchars|trim');
			$this->form_validation->set_rules('model','"Номер модели"','required|trim');
			$this->form_validation->set_rules('note','"Описание"','required|strip_tags|trim');
			$this->form_validation->set_rules('userfile','','callback_userfile_edit');
			$this->form_validation->set_error_delimiters('<div class="fvalid_error">','</div>');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->unit_edit();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				if($_FILES['userfile']['error'] != 4):
					$file = $_FILES['userfile']['tmp_name'];
					$newfile1 = $file.'.bak1';
					$newfile2 = $file.'.bak2';
					copy($file,$newfile1);
					copy($file,$newfile2);
					$_POST['image'] = $this->resize_main_image($file,500,800,TRUE);
					$_POST['bimage'] = $this->resize_big_image($newfile1,264,137,TRUE);
					$_POST['simage'] = $this->resize_img($newfile2,153,129,TRUE);
					unlink($newfile1);
					unlink($newfile2);
				else:
					$_POST['image'] = '';
				endif;
				$_POST['dress'] = $dress;
				$this->units->update_record($_POST);
				redirect($pagevar['link']);
			endif;
		endif;
		$pagevar['unit'] = $this->units->read_record($dress,$this->uri->segment(3));
		if(!$pagevar['unit']) show_404();
		$this->load->view('admin_interface/unit_edit',$pagevar);
	}
	
	function unit_delete(){
		
		$dress = 0;
		if($this->uri->segment(2) == 'dress-delete'):
			$link = 'dresses';
			$dress = 1;
		elseif($this->uri->segment(2) == 'accessories-delete'):
			$link = 'accessories';
		endif;
		
		$this->units->delete_record($dress,$this->uri->segment(3));
		redirect($link);
	}
	
	function pass_check($curpass){
	
		if($this->usermodel->user_exist('upassword',md5($curpass))):
			$this->form_validation->set_message('pass_check','Не верный пароль');
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	
	function shutdown(){
	
		$this->session->sess_destroy();
		redirect('');
	}

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