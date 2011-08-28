<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?=$this->load->view('users_interface/head');?>
<body>
<div id="container">
	<?=$this->load->view('users_interface/header');?>
	<div id="main" role="main" class="clearfix">
		<?=$this->load->view('admin_interface/regions');?>
		<div id="content">
			<div id="information" class="white-texture rounded clearfix">
				<div class="list-main">
				<h2 class="font-replace"><img src="<?=$baseurl;?>images/left-arrow.png"/><?=$name;?></h2>
			<?php if(count($unit)): ?>
				<div class="advertisment clearfix">
					<h2 class="font-replace"><?=$unit['ctl_name'];?></h2>
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
			<?php else: ?>
					<h2 class="font-replace">Информация отсутствует</h2>
			<?php endif; ?>
				</div>
			</div>			
		</div>
	</div>
	<?=$this->load->view('users_interface/footer');?>
</div> <!--! end of #container -->
<?=$this->load->view('users_interface/scripts');?>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
</body>
</html>