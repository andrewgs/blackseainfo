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
			<?php if(count($books)): ?>
					<h2 class="font-replace"><img src="<?=$baseurl;?>images/left-arrow.png"/><?=$name;?></h2>
					<hr/>
				<?php for($i=0;$i<count($books);$i++): ?>
					<div class="comment">
					<?php $uri_zone = 'resort/'.$books[$i]['reg_alias'];?>
						<div class=""><?=$books[$i]['date'];?></div>
						<div class=""><?=$books[$i]['fio'];?></div>
						<div class=""><?=$books[$i]['email'];?></div>
						<div class=""><?=$books[$i]['phone'];?></div>
					<div class=""><?=anchor($uri_zone,$books[$i]['reg_district'].', '.$books[$i]['reg_name']);?></div>
					<div class=""><?=anchor($uri_zone.'/'.$books[$i]['ctl_alias'].'/information',$books[$i]['ctl_name']);?></div>
					<img src="<?=$baseurl;?>catalog/viewimage/<?=$books[$i]['ctl_id'];?>" alt="<?=$books[$i]['ctl_name'];?>" title="<?=$books[$i]['ctl_name'];?>"/>
						<div class=""><?=$books[$i]['note'];?></div>
						<?=anchor('admin/delete-book/'.$books[$i]['id'],'Удалить заявку');?>
						<hr/>
					</div>
				<?php endfor;?>
				<?php if($pages): ?>
					<?=$pages;?>
				<?php endif;?>
			<?php else: ?>
					<h2 class="font-replace">Информация отсутствует</h2>
			<?php endif; ?>
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