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
			<h2 class="font-replace"><?=$name;?></h2>
			<?php for($i=0;$i<count($catalog);$i++): ?>
			<?php $inf = $this->uri->uri_string()."/catalog/".$catalog[$i]['ctl_id']."/information";?>
			<?php $form = $this->uri->uri_string()."/type/".$catalog[$i]['ctl_type']."/catalog/".$catalog[$i]['ctl_id']."/book";?>
		<?php switch ($catalog[$i]['ctl_type']):
			case '1' : $title='Места отдыха';$link=anchor($inf.'#price','Все цены').anchor($inf,'Описание').anchor($form,'Забронировать');break;
			case '2' : $title='Экскурсии';$link=anchor($inf,'Описание экскурсии').anchor($form,'Оставить заявку');break;
			case '3' : $title='Развлечения';$link=anchor($inf,'Описание заведения').anchor($form,'Забронировать билеты');break;
			case '4' : $title='Такси';$link=anchor($inf,'Полный список такси').anchor($form,'Заказать такси');break;
		endswitch; ?>
					<div class="advertisment clearfix">
						<img src="<?=$baseurl;?>catalog/viewimage/<?=$catalog[$i]['ctl_id'];?>" alt="<?=$catalog[$i]['ctl_name'];?>" title="<?=$catalog[$i]['ctl_name'];?>"/>
						<div><?=$catalog[$i]['ctl_short'];?></div>
						<?=$link;?>
					</div>
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