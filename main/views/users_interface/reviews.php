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
		<?=$this->load->view('users_interface/regions');?>
		<div id="content">
			<div id="information" class="white-texture rounded clearfix">
				<div class="list-main">
			<?php if(count($reviews)): ?>
					<h2 class="font-replace"><?=$name;?></h2>
				<?php for($i=0;$i<count($reviews);$i++): ?>
					<div class="comment">
						<div class=""><?=$reviews[$i]['rew_note'];?></div>
						<div class=""><?=$reviews[$i]['rew_author'];?></div>
					</div>
				<?php endfor;?>
				<?php if($pages): ?>
					<?=$pages;?>
				<?php endif;?>
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