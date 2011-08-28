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
		<?php if(count($catalog)): ?>
			<?php $type = ""; ?>
			<?php $count = 0; ?>
			<?php for($i=0;$i<count($catalog);$i++): ?>
			<?php $inf = "resort/".$this->uri->segment(2)."/".$catalog[$i]['ctl_alias']."/information";?>
			<?php $form = "resort/".$this->uri->segment(2)."/".$catalog[$i]['ctl_alias']."/".$catalog[$i]['ctl_type']."/book";?>
		<?php switch ($catalog[$i]['ctl_type']):
			case '1' : $title='Места отдыха';
					   $link=anchor($inf.'#price','Все цены').anchor($inf,'Описание').anchor($form,'Забронировать',array('class'=>'book'));break;
			case '2' : $title='Экскурсии';$link=anchor($inf,'Описание экскурсии').anchor($form,'Оставить заявку',array('class'=>'book'));break;
			case '3' : $title='Развлечения';
					   $link=anchor($inf,'Описание заведения').anchor($form,'Забронировать билеты',array('class'=>'book'));break;
			case '4' : $title='Такси';$link=anchor($inf,'Полный список такси').anchor($form,'Заказать такси',array('class'=>'book'));break;
		endswitch; ?>
				<?php $cur_type = $catalog[$i]['ctl_type']; ?>
				<?php if($type != $cur_type):?>
					<h2 class="font-replace"><?=$title;?></h2>
				<?php $type = $cur_type; ?>
				<?php $count = 0; ?>
				<?php endif; ?>
				<?php if($count < 3): ?>
					<div class="advertisment clearfix">
						<h3 class="font-replace"><?=$catalog[$i]['ctl_name'];?></h3>
						<img src="<?=$baseurl;?>catalog/viewimage/<?=$catalog[$i]['ctl_id'];?>" alt="<?=$catalog[$i]['ctl_name'];?>" title="<?=$catalog[$i]['ctl_name'];?>"/>
						<div><?=$catalog[$i]['ctl_short'];?></div>
						<?=$link;?>
					</div>
				<?php endif; ?>
				<?php $count++; ?>
				<?php endfor;?>
		<?php else: ?>
					<h2 class="font-replace">Информация отсутствует</h2>
		<?php endif; ?>
				</div>
				<?=$this->load->view('users_interface/sidebar');?>
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