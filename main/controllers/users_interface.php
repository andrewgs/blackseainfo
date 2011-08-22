<?php
class Users_interface extends CI_Controller {

	var $user = array('uid'=>0,'uname'=>'','ulogin'=>'','upassword'=>'','uemail'=>'','status'=>FALSE);
	var $months = array("01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля",
						"05"=>"мая","06"=>"июня","07"=>"июля","08"=>"августа",
						"09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
	
	function __construct(){
	
		parent::__construct();
		
		$this->load->model('users');
		$this->load->model('regions');
		$this->load->model('types');
		$this->load->model('catalog');
		$this->load->model('reviews');
		$this->load->model('news');
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
			endif;
		endif;
	}
	
	/* ----------------------------------------	users menu ---------------------------------------------------*/
	
	function index(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'BlackSeaInfo.ru - Главная',
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'fun'			=> $this->types->read_group(3),
					'reviews'		=> $this->reviews->read_reviews(2)
			);
		$this->load->view('users_interface/index',$pagevar);
	}
	
	function zone_content(){
	
		$region = $this->uri->segment(2);
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - ".$this->regions->read_city($region),
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'catalog'		=> $this->catalog->read_catalog_zone($region),
					'regions'		=> $this->regions->read_records(),
					'fun'			=> $this->types->read_group(3),
					'news'			=> $this->news->read_news(2,$region)
			);
		
		for($i = 0;$i < count($pagevar['news']); $i++):
			if(mb_strlen($pagevar['news'][$i]['text'],'UTF-8') > 270):									
				$pagevar['news'][$i]['text'] = mb_substr($pagevar['news'][$i]['text'],0,270,'UTF-8');	
				$pos = mb_strrpos($pagevar['news'][$i]['text'],' ',0,'UTF-8');
				$pagevar['news'][$i]['text'] = mb_substr($pagevar['news'][$i]['text'],0,$pos,'UTF-8');
				$pagevar['news'][$i]['text'] .= ' ... ';
			endif;
		endfor;
		$this->load->view('users_interface/content',$pagevar);
	}
	
	function unit_information(){
		
		$region = $this->uri->segment(2);
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - ",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'unit'			=> $this->catalog->read_unit($this->uri->segment(4)),
					'regions'		=> $this->regions->read_records(),
					'fun'			=> $this->types->read_group(3),
					'news'			=> $this->news->read_news(2,$region),
			);
		$pagevar['title'] .= $pagevar['unit']['ctl_name'].", ".$this->regions->read_city($region);
		$this->load->view('users_interface/unit_information',$pagevar);
	}
	
	function unit_book(){
		
		$region = $this->uri->segment(2);
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - ",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'unit'			=> $this->catalog->read_unit($this->uri->segment(4)),
					'regions'		=> $this->regions->read_records(),
					'fun'			=> $this->types->read_group(3),
					'news'			=> $this->news->read_news(2,$region),
					'name'			=> ""
			);
		$pagevar['name'] = 'Забронировать '.$pagevar['unit']['ctl_name'];
		$pagevar['title'] .= $pagevar['name'].", ".$this->regions->read_city($region);
		$this->load->view('users_interface/unit_book',$pagevar);
	}
	
	function payment(){
		
	}
	
	function choice_zone(){
		
	}
	
	function map_of_sochi(){
		
	}
	
	function contacts(){
		
	}
	
	function insert_email(){
		
		if($this->input->post('addemail')):
			$this->form_validation->set_rules('cm-name','"Имя"','required|htmlspecialchars|trim');
			$this->form_validation->set_rules('cm-email','"Почта"','required|valid_email|callback_email_check|trim');
			if(!$this->form_validation->run()):
				redirect('');
			else:
				$this->emails->insert_record($_POST);
				redirect('thanks');
			endif;
		else:
			show_404();
		endif;
	}
	
	/*********************************************************************************************************************/
	
	function email_check($email){
	
		if($this->emails->exist($email)):
			$this->form_validation->set_message('email_check','E-mail существует');
			return FALSE;
		endif;
	}
	
	function admin_login(){
	
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'LoveSonnet.ru - Авторизация',
					'baseurl' 		=> base_url(),
					'menu'			=> FALSE,
					'position'		=> '',
					'error'			=> FALSE,
					'userinfo'		=> $this->user
			);
		if($this->user['status']):
			redirect('');
		endif;
		if($this->input->post('submit')):
			$this->form_validation->set_rules('login-name','"Логин"','required|trim');
			$this->form_validation->set_rules('login-pass','"Пароль"','required');
			$this->form_validation->set_error_delimiters('<div class="fvalid_error">','</div>');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->admin_login();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$user = $this->usermodel->auth_user($_POST['login-name'],$_POST['login-pass']);
				if($user):
					$this->session->set_userdata('login_id',md5($user['ulogin'].$user['upassword']));
					$this->session->set_userdata('userid',$user['uid']);
					redirect('');
				endif;
				$pagevar['error'] = TRUE;
			endif;
		endif;
		$this->load->view('users_interface/admin-login',$pagevar);
	}
	
	function viewimage(){
		
		$section = $this->uri->segment(1);
		$id = $this->uri->segment(3);
		switch ($section){
			case 'catalog' 	: $image = $this->catalog->get_image($id); break;
			case 'unit' 	: $image = $this->images->get_bimage($id); break;
		}
		header('Content-type: image/gif');
		echo $image;
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
											
	function sendmail($email,$msg,$subject,$from){
		
		$config['smtp_host'] = 'localhost';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from($from,'NSP-DON');
		$this->email->to($email);
		$this->email->bcc('');
		$this->email->subject($subject);
		$this->email->message(strip_tags($msg));
		if(!$this->email->send()):
			return FALSE;
		endif;
		return TRUE;
	}			
}