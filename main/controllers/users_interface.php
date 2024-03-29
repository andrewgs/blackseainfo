<?php
class Users_interface extends CI_Controller {

	var $user = array('uid'=>0,'uname'=>'','upassword'=>'','uemail'=>'','status'=>FALSE);
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
		$this->load->model('materials');
		$this->load->model('union');
		$this->load->model('booking');
		$this->load->model('images');
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
					'slide'			=> $this->materials->main_slide(10,1),
					'regions'		=> $this->regions->read_records(),
					'reviews'		=> $this->reviews->read_reviews(2),
					'uri_string'	=> ''
			);
		$this->load->view('users_interface/index',$pagevar);
	}
	
	function zone_content(){
	
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - ".$this->regions->read_city($region),
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'catalog'		=> $this->catalog->read_catalog_zone($region),
					'regions'		=> $this->regions->read_records(),
					'slide'			=> $this->materials->read_limit_records($region,5,1),
					'video'			=> $this->materials->read_limit_records($region,1,2),
					'subtype'		=> $this->union->zone_subtype($region),
					'news'			=> $this->news->read_news(2,$region),
					'uri_string'	=> ''
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
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$unit = $this->catalog->unit_exist($this->uri->segment(3),$region);
		if(!$unit) show_404();
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - ",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'unit'			=> $this->catalog->read_unit($unit),
					'regions'		=> $this->regions->read_records(),
					'slide'			=> $this->materials->read_limit_records($region,5,1),
					'video'			=> $this->materials->read_limit_records($region,1,2),
					'news'			=> $this->news->read_news(2,$region),
					'name'			=> $this->regions->read_city($region).'<br/>'.$this->catalog->read_name($unit),
					'images'		=> $this->images->read_records($unit),
					'uri_string'	=> ''
			);
		$pagevar['title'] .= $pagevar['unit']['ctl_name'].", ".$this->regions->read_city($region);
		$this->load->view('users_interface/unit_information',$pagevar);
	}
	
	function unit_book(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$unit = $this->catalog->unit_exist($this->uri->segment(3));
		if(!$unit) show_404();
		$type = $this->uri->segment(4);
		if(!$this->types->type_idexist($type)) show_404();
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'BlackSeaInfo.ru - ',
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'unit'			=> $this->catalog->read_unit($unit),
					'regions'		=> $this->regions->read_records(),
					'slide'			=> $this->materials->read_limit_records($region,5,1),
					'video'			=> $this->materials->read_limit_records($region,1,2),
					'news'			=> $this->news->read_news(2,$region),
					'name'			=> $this->regions->read_city($region).', '.$this->catalog->read_name($unit),
					'uri_string'	=> ''
			);
		if($this->input->post('submit')):
			$this->form_validation->set_rules('fio','','required|trim');
			$this->form_validation->set_rules('email','','required|valid_email|trim');
			$this->form_validation->set_rules('phone','','required|trim');
			$this->form_validation->set_rules('note','','required|strip_tags|trim');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->unit_book();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$_POST['catalog'] = $unit;
				$this->booking->insert_record($region,$type,$_POST);
				$this->session->set_userdata('saccessfull',TRUE);
				redirect($this->uri->uri_string());
			endif;
		endif;
		switch ($type):
			case '1' : $pagevar['name'] .= '<br/>Бронирование места:'; break;
			case '2' : $pagevar['name'] .= '<br/>Оставить заявку на участие:'; break;
			case '3' : $pagevar['name'] .= '<br/>Бронирование билетов:'; break;
			case '4' : $pagevar['name'] .= '<br/>Заказ такси:'; break;
			default	 : show_404();
		endswitch;
		
		$pagevar['title'] .= $pagevar['unit']['ctl_name'].", ".$this->regions->read_city($region);
		$saccessfull = $this->session->userdata('saccessfull');
		if($saccessfull):
			$this->session->unset_userdata('saccessfull');
			$this->load->view('users_interface/thanks',$pagevar);
			return TRUE;
		endif;
		$this->load->view('users_interface/unit_book',$pagevar);
	}
	
	function zone_subcontent(){
	
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		
		$type = $this->types->type_exist($this->uri->segment(3));
		if(!$type) show_404();
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - ".$this->regions->read_city($region),
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'catalog'		=> $this->catalog->read_subtype_zone($region,$type),
					'regions'		=> $this->regions->read_records(),
					'slide'			=> $this->materials->read_limit_records($region,5,1),
					'video'			=> $this->materials->read_limit_records($region,1,2),
					'subtype'		=> $this->union->zone_subtype($region),
					'news'			=> $this->news->read_news(2,$region),
					'uri_string'	=> ''
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
	
	function payment(){
	
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Способы оплаты",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,0),
					'uri_string'	=> ''
			);
		$this->load->view('users_interface/payment',$pagevar);
	}
	
	function choice_zone(){
		
		$uri = $this->uri->uri_string();
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Выбор зоны отдыха",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,0),
					'name'			=> "Выберите зону отдыха",
					'materials'		=> array(),
					'uri_string'	=> $uri
			);
		switch ($uri):
			case 'resorts-photo' : $pagevar['materials'] = $this->materials->no_zone_records(6,1); break;
			case 'video' : $pagevar['materials'] = $this->materials->no_zone_records(4,2); break;
			case 'camers' : $pagevar['materials'] = $this->materials->no_zone_records(4,3); break;
		endswitch;
		
		$this->load->view('users_interface/choice-zone',$pagevar);
	}
	
	function order(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$regname = $this->regions->read_city($region);
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'BlackSeaInfo.ru - '.$regname,
					'baseurl' 		=> base_url(),
					'visible'		=> TRUE,
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'slide'			=> $this->materials->read_limit_records($region,5,1),
					'video'			=> $this->materials->read_limit_records($region,1,2),
					'catalog'		=> $this->catalog->read_catalog_zone($region),
					'news'			=> $this->news->read_news(2,$region),
					'name'			=> $regname.'<br/>Бронирование:',
					'uri_string'	=> ''
			);
			
		if($this->input->post('submit')):
			$this->form_validation->set_rules('catalog','','required|trim');
			$this->form_validation->set_rules('fio','','required|trim');
			$this->form_validation->set_rules('email','','required|valid_email|trim');
			$this->form_validation->set_rules('phone','','required|trim');
			$this->form_validation->set_rules('note','','required|strip_tags|trim');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->order();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$this->booking->insert_record($region,0,$_POST);
				$this->session->set_userdata('saccessfull',TRUE);
				redirect($this->uri->uri_string());
			endif;
		endif;
		$saccessfull = $this->session->userdata('saccessfull');
		if($saccessfull):
			$this->session->unset_userdata('saccessfull');
			$this->load->view('users_interface/thanks',$pagevar);
			return TRUE;
		endif;
		$this->load->view('users_interface/unit_book',$pagevar);
		
	}
	
	function resorts_photo(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$regname = $this->regions->read_city($region);
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'BlackSeaInfo.ru - '.$regname,
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'unit'			=> array(),
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,$region),
					'name'			=> $regname.'<br/>Фотографии курортов:',
					'images'		=> $this->materials->read_records($region,1),
					'uri_string'	=> ''
			);
		$this->load->view('users_interface/resorts-photo',$pagevar);
	}
	
	function video(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$regname = $this->regions->read_city($region);
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'BlackSeaInfo.ru - '.$regname,
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'unit'			=> array(),
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,$region),
					'video'			=> $this->materials->read_records($region,2),
					'name'			=> $regname.'<br/>Видео материалы:',
					'uri_string'	=> ''
			);
		$this->load->view('users_interface/video',$pagevar);
	}
	
	function camers(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$regname = $this->regions->read_city($region);
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'BlackSeaInfo.ru - '.$regname,
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'unit'			=> array(),
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,$region),
					'camers'		=> $this->materials->read_records($region,3),
					'name'			=> $regname.'<br/>Веб-камеры на пляжах:',
					'uri_string'	=> ''
			);
		$this->load->view('users_interface/camers',$pagevar);
	}
	
	function map(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Карта города Сочи",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,0),
					'uri_string'	=> ''
			);
		$this->load->view('users_interface/map',$pagevar);
	}
	
	function contacts(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Контакты",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,0),
					'uri_string'	=> ''
			);
		$this->load->view('users_interface/contacts',$pagevar);
	}

	function reviews(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Отзывы клиентов",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'name'			=> 'Отзывы клиентов:',
					'reviews'		=> array(),
					'news'			=> $this->news->read_news(2,0),
					'count'			=> 0,
					'pages'			=> '',
					'uri_string'	=> ''
			);
		
		$pagevar['count'] = $this->reviews->count_records();
		
		$config['base_url'] 		= $pagevar['baseurl'].'reviews/';
        $config['total_rows'] 		= $pagevar['count']; 
        $config['per_page'] 		= 5;
        $config['num_links'] 		= 4;
        $config['uri_segment'] 		= 2;
		$config['first_link']		= 'В начало';
		$config['last_link'] 		= 'В конец';
		$config['next_link'] 		= 'Далее &raquo;';
		$config['prev_link'] 		= '&laquo; Назад';
		$config['cur_tag_open']		= '<b>';
		$config['cur_tag_close'] 	= '</b>';
		$from = intval($this->uri->segment(2));
		$pagevar['reviews'] = $this->reviews->read_limit_records(5,$from);
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		$this->load->view('users_interface/reviews',$pagevar);
	}
	
	function weather(){
	
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Погода на побережье",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,0),
					'uri_string'	=> ''
			);
		$this->load->view('users_interface/weather',$pagevar);
	}
	
	function zone_news(){
		
		$region = $this->regions->region_exist($this->uri->segment(2));
		if(!$region) show_404();
		$regname = $this->regions->read_city($region);
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> 'BlackSeaInfo.ru - '.$regname,
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'unit'			=> array(),
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,0),
					'slide'			=> $this->materials->read_limit_records($region,5,1),
					'video'			=> $this->materials->read_limit_records($region,1,2),
					'zonenews'		=> array(),
					'name'			=> $regname.'<br/>Новости:',
					'count'			=> 0,
					'pages'			=> '',
					'uri_string'	=> ''
			);
		
		$pagevar['count'] = $this->news->count_records($region);
		
		$config['base_url'] 		= $pagevar['baseurl'].'resort/'.$this->uri->segment(2).'/news';
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
		$pagevar['zonenews'] = $this->news->read_limit_records($region,5,$from);
		for($i=0;$i<count($pagevar['zonenews']);$i++):
			$pagevar['zonenews'][$i]['date'] = $this->operation_date($pagevar['zonenews'][$i]['date']);
		endfor;
		$this->pagination->initialize($config);
		$pagevar['pages'] = $this->pagination->create_links();
		
		$this->load->view('users_interface/zone-news',$pagevar);
	}

	function read_news(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Читать новость",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,0),
					'content'		=> $this->news->read_record($this->uri->segment(2)),
					'uri_string'	=> ''
			);
		$pagevar['content']['date'] = $this->operation_date($pagevar['content']['date']);
		$this->load->view('users_interface/read-news',$pagevar);
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

	function project(){
	
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Участие в проекте",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'news'			=> $this->news->read_news(2,0),
					'uri_string'	=> ''
			);
		$this->load->view('users_interface/project',$pagevar);
	}
	
	function admin_login(){
		
		$pagevar = array(
					'description'	=> '',
					'author'		=> '',
					'title'			=> "BlackSeaInfo.ru - Авторизация",
					'baseurl' 		=> base_url(),
					'userinfo'		=> $this->user,
					'regions'		=> $this->regions->read_records(),
					'uri_string'	=> ''
			);
		if($this->user['status']):
			redirect('');
		endif;
		if($this->input->post('submit')):
			$this->form_validation->set_rules('login','','required|trim');
			$this->form_validation->set_rules('pass','','required|trim');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->admin_login();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$user = $this->users->auth_user($_POST['login'],$_POST['pass']);
				if($user):
					$this->session->set_userdata('login_id',md5($user['uemail'].$user['upassword']));
					$this->session->set_userdata('userid',$user['uid']);
					redirect('');
				endif;
			endif;
		endif;
		$this->load->view('users_interface/admin-login',$pagevar);
	}

	/*********************************************************************************************************************/
	
	function email_check($email){
	
		if($this->emails->exist($email)):
			$this->form_validation->set_message('email_check','E-mail существует');
			return FALSE;
		endif;
	}
	
	function viewimage(){
		
		$section = $this->uri->segment(1);
		$id = $this->uri->segment(3);
		switch ($section){
			case 'catalog' 	: $image = $this->catalog->get_image($id); break;
			case 'material'	: $image = $this->materials->get_image($id); break;
			case 'photo'	: $image = $this->images->get_image($id); break;
		}
		header('Content-type: image/gif');
		echo $image;
	}

	function viewthumb(){
	
		$section = $this->uri->segment(1);
		$id = $this->uri->segment(3);
		switch ($section){
			case 'material'	: $image = $this->materials->get_thumb($id); break;
			case 'photo'	: $image = $this->images->get_thumb($id); break;
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