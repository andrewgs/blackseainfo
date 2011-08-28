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
		$this->load->model('news');
		$this->load->model('materials');
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
	
	function manager_region(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Управление зонами отдыха",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> "Список зон отдыха",
					'uri_string'	=> ''
			);
			
		if($this->input->post('submit')):
			$this->form_validation->set_rules('name','','required|htmlspecialchars|strip_tags|trim');
			$this->form_validation->set_rules('area','','trim');
			$this->form_validation->set_rules('district','','required|trim');
			$this->form_validation->set_rules('alias','','required|trim|callback_region_alias');
			$this->form_validation->set_rules('priority','','required|trim');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->manager_region();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$this->regions->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view('admin_interface/manager-region',$pagevar);
	}

	function save_region(){
	
		$statusval = array('status'=>FALSE,'alias'=>FALSE,'message'=>'Данные не изменились','name'=>'','area'=>'','distr'=>'','alias'=>'','priority'=>'');
		$rid = $this->input->post('id');
		$name = trim($this->input->post('name'));
		$area = trim($this->input->post('area'));
		$distr = trim($this->input->post('distr'));
		$alias = trim($this->input->post('alias'));
		$priority = trim($this->input->post('priority'));
		if(!$rid || !$name || !$distr || !$alias || !$priority) show_404();
		if(!$area) $area = '';
		
		$region = $this->regions->region_exist($alias);
		if($region && ($region != $rid)):
			$statusval['status'] = FALSE;
			$statusval['alias'] = TRUE;
			$statusval['message'] = 'Псевдоним уже существует';
		else:
			$success = $this->regions->save_region($rid,$name,$area,$distr,$alias,$priority);
			if($success):
				$statusval['status'] = TRUE;
				$statusval['name'] = $name;
				$statusval['area'] = $area;
				$statusval['distr'] = $distr;
				$statusval['alias'] = $alias;
				$statusval['priority'] = $priority;
			endif;
		endif;
		echo json_encode($statusval);
	}
	
	function valid_region_alias(){
	
		$statusval = array('status'=>FALSE,'message'=>'Псевдоним уже существует');
		$alias = trim($this->input->post('alias'));
		if(!$alias) show_404();
		$success = $this->regions->region_exist($alias);
		if(!$success):
			$statusval['status'] = TRUE;
			$statusval['message'] = 'Псевдоним свободен';
		endif;
		echo json_encode($statusval);
	}
	
	function choice_zone(){
	
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Выбор зоны отдыха",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> "Выберите зону отдыха",
					'uri_string'	=> 'manager'
			);
			
		$this->load->view('admin_interface/choice-zone',$pagevar);
	}
	
	function manager_zone(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Управление зоной отдыха",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> $this->regions->read_city($region).'<br/>Управление:',
					'uri_string'	=> 'manager'
			);
		$this->session->set_userdata('uripath',$this->uri->uri_string());
		$this->load->view('admin_interface/manager-zone',$pagevar);
	}
	
	function manager_news(){
	
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Управление новостями",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> "Выберите зону отдыха",
					'news'			=> array(),
					'count'			=> 0,
					'pages'			=> '',
					'uri_string'	=> 'news'
			);
		
		$pagevar['count'] = $this->news->count_records(0);
		
		$config['base_url'] 		= $pagevar['baseurl'].'admin/manager/news';
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
		$pagevar['news'] = $this->news->read_limit_records(0,5,$from);
		for($i=0;$i<count($pagevar['news']);$i++):
			$pagevar['news'][$i]['date'] = $this->operation_date($pagevar['news'][$i]['date']);
		endfor;
		$this->session->set_userdata('uripath',$this->uri->uri_string());
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		$this->load->view('admin_interface/manager-news',$pagevar);
	}

	function manager_zone_news(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$regname = $this->regions->read_city($region);
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Управление новостями",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> $regname.'<br/>Новости:',
					'news'			=> array(),
					'count'			=> 0,
					'pages'			=> '',
					'uri_string'	=> 'news'
			);
		
		$pagevar['count'] = $this->news->count_records($region);
		
		$config['base_url'] 		= $pagevar['baseurl'].'admin/'.$this->uri->segment(2).'/news';
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
		$pagevar['news'] = $this->news->read_limit_zone($region,5,$from);
		for($i=0;$i<count($pagevar['news']);$i++):
			$pagevar['news'][$i]['date'] = $this->operation_date($pagevar['news'][$i]['date']);
		endfor;
		$this->session->set_userdata('uripath',$this->uri->uri_string());
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		$this->load->view('admin_interface/manager-zone-news',$pagevar);
	}
	
	function view_news(){
	
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Просмотр новости",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> anchor($this->session->userdata('uripath'),'Вернуться к списку'),
					'news'			=> $this->news->read_record($this->uri->segment(4)),
					'uri_string'	=> 'news'
			);
		$this->load->view('admin_interface/view-news',$pagevar);
	}
	
	function add_news(){
		
		$segment = $this->uri->segment(2);
		if($segment != 'manager'):
			$region = $this->regions->region_exist($segment);
			if(!$region): 
				show_404(); 
			endif;
		else:
			$region = 0;
		endif;
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Добавление новости",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> anchor($this->session->userdata('uripath'),'Вернуться назад'),
					'uri_string'	=> 'news'
			);
		
		if($this->input->post('submit')):
			$this->form_validation->set_rules('title','','required|htmlspecialchars|strip_tags|trim');
			$this->form_validation->set_rules('date','','required|trim');
			$this->form_validation->set_rules('text','','required|strip_tags|trim');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->add_news();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
				$replacement = "\$3-\$2-\$1";
				$_POST['date'] = preg_replace($pattern,$replacement,$_POST['date']);
				$_POST['region'] = $region;
				$news = $this->news->insert_record($_POST);
				redirect('admin/manager/view-news/'.$news);
			endif;
		endif;
		
		$this->load->view('admin_interface/add-news',$pagevar);
	}
	
	function edit_news(){
		
		$newsid = $this->uri->segment(4);
		$segment = $this->uri->segment(2);
		if($segment != 'manager'):
			$region = $this->regions->region_exist($segment);
			if(!$region): 
				show_404(); 
			endif;
		else:
			$region = 0;
		endif;
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Редактирование новости",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> anchor($this->session->userdata('uripath'),'Вернуться назад'),
					'news'			=> $this->news->read_record($newsid),
					'uri_string'	=> 'news'
			);
		
		if($this->input->post('submit')):
			$this->form_validation->set_rules('title','','required|htmlspecialchars|strip_tags|trim');
			$this->form_validation->set_rules('date','','required|trim');
			$this->form_validation->set_rules('text','','required|strip_tags|trim');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->edit_news();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
				$replacement = "\$3-\$2-\$1";
				$_POST['date'] = preg_replace($pattern,$replacement,$_POST['date']);
				$_POST['region'] = $region;
				$this->news->update_record($newsid,$_POST);
				redirect('admin/manager/view-news/'.$newsid);
			endif;
		endif;
		$pagevar['news']['date'] = $this->operation_date_slash($pagevar['news']['date']);
		$this->load->view('admin_interface/edit-news',$pagevar);
	}
	
	function delete_news(){
	
		$this->news->delete_record($this->uri->segment(4));
		redirect($this->session->userdata('uripath'));
	}
	
	function zone_photo(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Управление зоной отдыха",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> $this->regions->read_city($region).'<br/>Фотографии:',
					'images'		=> $this->materials->read_records($region,1),
					'uri_string'	=> 'manager'
			);
		
		if($this->input->post('submit')):
			$this->form_validation->set_rules('title','','required|htmlspecialchars|strip_tags|trim');
			$this->form_validation->set_rules('note','','required|trim');
			$this->form_validation->set_rules('userfile','','callback_userfile_check');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->zone_photo();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				if($_FILES['userfile']['error'] != 4):
					$_POST['image'] = $this->resize_image($_FILES['userfile']['tmp_name'],540,360,TRUE);
					$_POST['thumb'] = $this->resize_image($_FILES['userfile']['tmp_name'],150,140,TRUE);
				endif;
				$_POST['region'] = $region;	$_POST['link'] = ''; $_POST['type'] = 1; 
				$news = $this->materials->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view('admin_interface/manager-zone-photo',$pagevar);
	}
	
	function delete_photo(){
	
		$statusval = array('status'=>FALSE,'message'=>'Ошибка при удалении');
		$id = trim($this->input->post('id'));
		if(!$id) show_404();
		$success = $this->materials->delete_record($id);
		if($success) $statusval['status'] = TRUE;
		echo json_encode($statusval);
	}
	
	function zone_video(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Управление зоной отдыха",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> $this->regions->read_city($region).'<br/>Видео материалы:',
					'video'			=> $this->materials->read_records($region,2),
					'uri_string'	=> 'manager'
			);
			
		$this->load->view('admin_interface/manager-zone-video',$pagevar);
	}
	
	function zone_add_video(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Управление зоной отдыха",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> $this->regions->read_city($region).'<br/>Добавление фотографии:',
					'uri_string'	=> 'manager'
			);
			
		$this->load->view('admin_interface/manager-zone-addphoto',$pagevar);
	}
	
	function zone_camers(){
		
	}
	
	/*********************************************************************************************************************/
	
	function region_alias($alias){
		if($this->regions->region_exist($alias)):
			$this->form_validation->set_message('region_alias','Псевдоним уже существует');
			return FALSE;
		endif;
		return TRUE;
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
											
	function resize_image($tmpName,$wgt,$hgt,$ratio){
			
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
		$image_dst = ImageCreateTrueColor($wgt,$img[1]);
		imageCopy($image_dst,$image_src,0,0,0,0,$wgt,$img[1]);
		imagePNG($image_dst,$tmpName);
		imagedestroy($image_dst);
		imagedestroy($image_src);
		$image = file_get_contents($tmpName);
		return $image;
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