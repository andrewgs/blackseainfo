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
					<hr/>
					<h2 class="font-replace">Общие новости</h2>
					<?=anchor('admin/manager/add-news','Добавить новость');?>
				<?php if(count($news)): ?>
					<?php for($i=0;$i<count($news);$i++): ?>
					<div class="comment">
						<div class=""><?=$news[$i]['date'];?></div>
						<div class=""><?=$news[$i]['title'];?></div>
						<div class=""><?=$news[$i]['text'];?></div>
					</div>
					<div class="">
						<?=anchor('admin/manager/edit-news/'.$news[$i]['id'],'Редактировать');?>
						<?=anchor('admin/manager/delete-news/'.$news[$i]['id'],'Удалить');?>
					</div>
					<?php endfor;?>
				<?php else: ?>
					<h2 class="font-replace">Информация отсутствует</h2>
				<?php endif; ?>
					<?php if($pages): ?>
						<?=$pages;?>
					<?php endif;?>
				</div>
				<div class="list-sidebar">
				<?=$this->load->view('admin_interface/sidebar-menu');?>
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