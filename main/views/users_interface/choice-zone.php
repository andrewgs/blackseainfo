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
					<h2 class="font-replace"><img src="<?=$baseurl;?>images/left-arrow.png"/><?=$name;?></h2>
			<?php if(count($materials)):?>
				<?php for($i=0;$i<count($materials);$i++): ?>
					<div class="frames">
					<?php	
						switch ($uri_string):
							case 'resorts-photo' : 
								echo '<a href="#"><img src="'.$baseurl.'material/viewthumb/'.$materials[$i]['id'].'" alt="'.$materials[$i]['title'].'" title="'.$materials[$i]['title'].'"/></a>';
								break;
							case 'video' : 
								echo '<iframe src="'.$materials[$i]['link'].'" width="210" height="118" frameborder="0"></iframe>'; 
								break;
							case 'camers' :
								echo '<a href="#"><img src="'.$baseurl.'material/viewthumb/'.$materials[$i]['id'].'" alt="'.$materials[$i]['title'].'" title="'.$materials[$i]['title'].'"/></a>';
								break;
						endswitch;
					?>	
					</div>
				<?php endfor; ?>
			<?php endif; ?>	
				</div>
				<div class="list-sidebar">
				<?php if($userinfo['status']):?>
					<?=$this->load->view('admin_interface/sidebar-menu');?>
				<?php endif; ?>
				<?php if(count($news)):?>
					<h2 class="font-replace">Новости</h2>
					<div id="news-stream" class="widget">
					<?php for($i=0;$i<count($news);$i++):?>
						<strong><?=$news[$i]['title'];?></strong>
						<p><?=$news[$i]['text'];?><?=anchor('#','<nobr> Читать далее &raquo;</nobr>');?></p>
					<?php endfor;?>
					</div>
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