<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?=$this->load->view('users_interface/head');?>
<body>
<div id="container">
	<?=$this->load->view('users_interface/header');?>
	<div id="main" role="main">
		<?=$this->load->view('users_interface/regions');?>
		<div id="content">
			<div id="slideshow">
				<div class="slide-wrapper">
					<div id="slides">
						<div class="slide-single">
							<a class="slide-link" href="#">
								<img src="<?=$baseurl;?>images/slide-1.jpg" alt="" />						
							</a>
							<div class="slide-desc">
								<h2>Курортный поселок Лазаревское</h2>
								<p>
									Идеальное место для спокойного, но интересного и насыщенного отдыха. Лазаревское 
									это самый северный курорт Сочи. Древняя благодатная земля, окаймленная теплым 
									морем и живописными отрогами Северного Кавказа, призывно влечет к себе.
								</p>
							</div>							
						</div>
						<div class="slide-single">
							<a class="slide-link" href="#">
								<img src="<?=$baseurl;?>images/slide-2.jpg" alt="" />						
							</a>
							<div class="slide-desc">
								<h2>Анапа</h2>
								<p>
									Преимущество курортной Анапы перед своими российскими и крымскими конкурентами 
									курортами на Черном море – это прекраснейшие песчаные пляжи, протянувшиеся воль 
									побережья почти на 40 километров.
								</p>
							</div>							
						</div>
						<div class="slide-single">
							<a class="slide-link" href="#">
								<img src="<?=$baseurl;?>images/slide-3.jpg" alt="" />						
							</a>
							<div class="slide-desc">
								<h2>Абрау-Дюрсо</h2>
								<p>
									Жемчужиной редкой красоты, уникального достоинства называют Абрау-Дюрсо, заповедное 
									место на Северном Кавказе в окрестностях города Новороссийска. Вокруг поселка и в долине 
									реки Дюрсо расположены виноградники.
								</p>
							</div>							
						</div>
					</div>
					<a id="slide-prev" href="#">Пред.</a>
					<a id="slide-next" href="#">След.</a>					
				</div>
			</div>
			<div id="company-services" class="white-texture rounded">
				<div class="service-node">
					<h2 class="font-replace"><?=anchor('news','Новости');?></h2>
					<p>
						Освещение наиболее значимых социальных новостей из жизни прибрежных 
						городов, проводимых мероприятий и происходящих событий. Каждый 
						участникпроекта имеет возможность поделиться с нами новостями и 
						анонсировать предстоящие события.
					</p>
				</div>
				<div class="service-node">
					<h2 class="font-replace"><?=anchor('resorts-photo','Фотопленка');?></h2>
					<p>
						Фотоальбом с наиболее яркими фотографиями и описаниями достопримечательностей
						курортов Краснодарского края. Коллекция фотографий регулярно пополняется и 
						обновляется усилиями наших специалистов и другими участниками проекта.
					</p>
				</div>
				<div class="service-node">
					<h2 class="font-replace"><?=anchor('camers','Прямой эфир');?></h2>
					<p>
						Уникальная возможность увидеть в режиме онлайн морские волны, услышать шум 
						южных ветров и почувствовать курортное настроение. Наши веб-камеры постоянно 
						ведут потоковое вещание в сети Интернет. Мы всегда рады новым участникам.
					</p>
				</div>
				<div class="service-node">
					<h2 class="font-replace"><?=anchor('#','Обновления');?></h2>
					<p>
						Мы постоянно обновляем нашу базу данных гостиниц, парков, ресторанов, пансинонатов,
						служб такси и проводимых экскурсионных туров. В виду постоянного сотрудничества с
						ведущими операторами отдыха на черноморском побережье мы всегда предоставляем только
						достоверную и актуальную информацию.
					</p>
				</div>
				<div class="service-node">
					<h2 class="font-replace"><?=anchor('#','Сотрудничество');?></h2>
					<p>
						Мы всегда рады новым партнерам и участниками проекта. Если вы являетесь представителем или
						владельцем гостиницы, парка развлечений, службы такси или другой курортной службы, вы 
						всегда можете связаться с нами и разместить свою информацию на нашем веб-сайте.
					</p>
				</div>
				<div class="service-node">
					<h2 class="font-replace"><?=anchor('contacts','Контакты');?></h2>
					<p>
						Вы можете встретиться с нами по следующему адресу:<br/> 
						г.Новороссийск,<br/>
						ул.Тимирязева, д.45 оф.15
					</p>
					<p>
						По телефонам:<br/>
						+7 (863) 245-45-45<br/>
						+7 (918) 547-12-74
					</p>
					<p>
						По электронной почте:<br/>
						info@blackseainfo.ru
					</p>
				</div>
			</div>			
		</div>
		<div class="clear"></div>
		<div id="testimonials" class="white-texture rounded clearfix">
			<div class="clearfix">
				<div class="section-desc">
					<h2 class="font-replace">Отзывы клиентов.</h2>
				</div>
				<div class="sprite"> </div>				
			</div>
		<?php for($i=0;$i<count($reviews);$i++):?>
			<div class="comment">
				<?=$reviews[$i]['rew_note'];?>
				<div class="author"><?=$reviews[$i]['rew_author'];?></div>
			</div>
		<?php endfor; ?>
		</div>
	</div>
	<?=$this->load->view('users_interface/footer');?>
</div> <!--! end of #container -->
<?=$this->load->view('users_interface/scripts');?>
<script>
	var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']]; // Change UA-XXXXX-X to be your site's ID
	( function(d,t) {
		var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.async=1;
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)
	}(document,'script'));
</script>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
</body>
</html>
