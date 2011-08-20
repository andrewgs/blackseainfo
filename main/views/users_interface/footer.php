<footer class="white-texture rounded clearfix">
	<div class="clearfix">
		<div class="column first">
			<h3>О компании</h3>
			<ul>
				<li><?=anchor('#','Отзывы клиентов');?></li>
				<li><?=anchor('#','Бронирование онлайн');?></li>
				<li><?=anchor('#','Способы оплаты');?></li>
			</ul>
		</div>
		<div class="column">
			<h3>Развлечения</h3>
			<ul>
			<?php for($i=0;$i<count($fun);$i++): ?>
				<li><?=anchor('fun/'.$fun[$i]['tps_id'],$fun[$i]['tps_name']);?></li>
			<?php endfor; ?>
			</ul>
		</div>
		<div class="column">
			<h3>Наши услуги</h3>
			<ul>
				<li><?=anchor('#','Фотографии курортов');?></li>
				<li><?=anchor('#','Видео материалы');?></li>
				<li><?=anchor('#','Веб-камеры на пляжах');?></li>
				<li><?=anchor('#','Новости');?></li>
			</ul>
		</div>
		<div class="column">
			<h3>Прочее</h3>
			<ul>
				<li><?=anchor('#','Погода на побережье');?></li>
				<li><?=anchor('#','Карта города Сочи');?></li>
			</ul>
		</div>
		<div class="column last">
			<h3>Наши услуги</h3>
			<ul>
				<li><?=anchor('#','Контакты');?></li>
				<li><?=anchor('#','info@blackseainfo.ru');?></li>
				<li><?=anchor('#','sales@blackseainfo.ru');?></li>
				<li><?=anchor('#','blackseainfo (skype)');?></li>
			</ul>
		</div>
	</div>
	<div class="clearfix">
		<div class="phone">
			<strong>8-918-591-33-37</strong>
			Copyright &copy; 2011 BlackSeaInfo. Все права защищены. Сделано в <a href="http://realitygroup.ru">RealityGroup</a>.
		</div>
		<div class="icons">
			<a class="rss" href="#">RSS</a>
			<a class="ok" href="#">Одноклассники</a>
			<a class="facebook" href="#">Facebook</a>
			<a class="vk" href="#">Вконтакте</a>
			<a class="twitter" href="#">Twitter</a>
		</div>
	</div>		
</footer>