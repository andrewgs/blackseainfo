<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?=$this->load->view('users_interface/head-pirobox');?>
<body>
<div id="container">
	<?=$this->load->view('users_interface/header');?>
	<div id="main" role="main" class="clearfix">
		<?=$this->load->view('admin_interface/regions');?>
		<div id="content">
			<div id="information" class="white-texture rounded clearfix">
				<div class="list-main wide clearfix">
					<h2 class="font-replace">
						<img src="<?=$baseurl;?>images/left-arrow.png"/><?=anchor($this->session->userdata('uripath'),'Вернуться назад');?>
					</h2>
					<hr/>
					<h2 class="font-replace"><?=$name;?></h2>
					<?php $region = $this->uri->segment(2);?>
					<?=anchor('admin/'.$region.'/manager/add-video','Добавить ссылку на видеофайл');?>
					<div id="photo-frames">
				<?php for($i=0;$i<count($video);$i++): ?>
						<div class="frames">
							<iframe src="<?=$video[$i]['link'];?>" width="210" height="118" frameborder="0"></iframe>
						</div>
				<?php endfor; ?>
					</div>
				</div>
			</div>			
		</div>
	</div>
	<?=$this->load->view('users_interface/footer');?>
</div> <!--! end of #container -->
<?=$this->load->view('users_interface/scripts');?>
<script type="text/javascript" src="<?=$baseurl;?>js/pirobox.min.js"></script>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
<script type="text/javascript">
	$(document).ready(function() {
		$().piroBox({my_speed: 400,bg_alpha: 0.1,slideShow : true,slideSpeed : 4,close_all : '.piro_close,.piro_overlay'});
	});
</script>
</body>
</html>