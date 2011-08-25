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
		<?=$this->load->view('users_interface/regions');?>
		<div id="content">
			<div id="information" class="white-texture rounded clearfix">
				<div class="list-main">
			<?php if(count($unit)): ?>
				<div class="advertisment clearfix">
					<h2 class="font-replace"><?=$name;?></h2>
				<img src="<?=$baseurl;?>catalog/viewimage/<?=$unit['ctl_id'];?>" alt="<?=$unit['ctl_name'];?>" title="<?=$unit['ctl_name'];?>"/>
					<div><?=$unit['ctl_note'];?></div>
					<a name="price"></a>
					<div><?=$unit['ctl_price'];?></div>
					
					<div id="photo-frames">
				<?php for($i=0;$i<count($images);$i++): ?>
					<div class="frames">
						<?php $link = $baseurl.'photo/viewimage/'.$images[$i]['id']; ?>
						<?php $text = '<img src="'.$baseurl.'photo/viewthumb/'.$images[$i]['id'].'" 
									alt="'.$images[$i]['title'].'" '.'title="'.$images[$i]['title'].'"/>'; ?>
						<?php $attr = array('class'=>'pirobox','title'=>$images[$i]['title']); ?>
						<?= anchor($link,$text,$attr); ?>
					</div>
				<?php endfor; ?>
					</div>
				</div>
			<?php endif; ?>
				</div>
				<?=$this->load->view('users_interface/sidebar');?>
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