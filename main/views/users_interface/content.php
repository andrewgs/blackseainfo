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
			<?php for($i=0;$i<count($catalog);$i++): ?>
			<?php switch ($catalog[$i]['ctl_type']):
				case '1' : $title='Места отдыха.';$link=anchor('#','Все цены').anchor('#','Описание').anchor('#','Забронировать');break;
				case '2' : $title='Экскурсии.';$link=anchor('#','Описание экскурсии').anchor('#','Оставить заявку');break;
				case '3' : $title='Развлечения.';$link=anchor('#','Описание заведения').anchor('#','Забронировать билеты');break;
				case '4' : $title='Такси.';$link=anchor('#','Полный список такси').anchor('#','Заказать такси');break;
			endswitch; ?>
				<?php $cur_type = $catalog[$i]['ctl_type']; ?>
				<?php if($type != $cur_type):?>
					<h2 class="font-replace"><?=$title;?></h2>
				<?php $type = $cur_type; ?>
				<?php endif; ?>
					<div class="advertisment clearfix">
						<img src="<?=$baseurl;?>catalog/viewimage/<?=$catalog[$i]['ctl_id'];?>" alt="" title=""/>
						<div><?=$catalog[$i]['ctl_short'];?></div>
						<?=$link;?>
					</div>
				<?php endfor;?>
		<?php else: ?>
					<h2 class="font-replace">Информация отсутствует</h2>
		<?php endif; ?>
				</div>
				<div class="list-sidebar">
					<h2 class="font-replace">Погода.</h2>
					<div id="weather" class="widget clearfix">
						<img width="45px" src="http://www.google.com/ig/images/weather/cloudy.gif" />
						<div class="broadcast">
							<strong class="temperature">27 <sup>o</sup>C</strong>
							<strong>Переменная облачность</strong>
							Влажность: 32% Ветер: 3м/с 
						</div>
					</div>
					<h2 class="font-replace">Фотопленка.</h2>
					<div id="photo-stream" class="widget">
						<img alt="" title="" src="<?=$baseurl;?>images/slide-sidebar.jpg"/>
					 </div>
					<h2 class="font-replace">Видео.</h2>
					<div id="video-stream" class="widget">
						<iframe src="http://player.vimeo.com/video/27786807?title=0&amp;byline=0&amp;portrait=0" width="210" height="118" frameborder="0"></iframe>
					 </div>
				<?php if(count($news)):?>
					<h2 class="font-replace">Новости.</h2>
					<div id="news-stream" class="widget">
					<?php for($i=0;$i<count($news);$i++):?>
						<strong><?=$news[$i]['title'];?></strong>
						<p><?=$news[$i]['text'];?><?=anchor('#',' <nobr>Читать далее &raquo;</nobr>');?></p>
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