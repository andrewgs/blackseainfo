<footer class="white-texture rounded clearfix">
	<div class="clearfix">
		<div class="column first">
			<h3>О компании</h3>
			<ul>
				<li><?=anchor('reviews','Отзывы клиентов');?></li>
				<li><?=anchor('book','Бронирование онлайн');?></li>
				<li><?=anchor('payment','Способы оплаты');?></li>
			</ul>
		</div>
		<div class="column">
			<h3>Наши услуги</h3>
			<ul>
				<li><?=anchor('resorts-photo','Фотографии курортов');?></li>
				<li><?=anchor('video','Видео материалы');?></li>
				<li><?=anchor('camers','Веб-камеры на пляжах');?></li>
				<li><?=anchor('news','Новости');?></li>
			</ul>
		</div>
		<div class="column">
			<h3>Прочее</h3>
			<ul>
				<li><?=anchor('weather','Погода на побережье');?></li>
				<li><?=anchor('map-of-sochi','Карта города Сочи');?></li>
			</ul>
		</div>
	<?php if($userinfo['status']):?>
		<div class="column">
			<h3>Админ-панель</h3>
			<ul>
				<li><?=anchor('admin/booking','Заявки');?></li>
				<li><?=anchor('admin/profile','Профиль');?></li>
				<li><?=anchor('admin/logout','Завершить сеанс');?></li>
			</ul>
		</div>
	<?php endif; ?>
		<div class="column last">
			<h3>Наши услуги</h3>
			<ul>
				<li><?=anchor('contacts','Контакты');?></li>
				<li><?=safe_mailto('info@blackseainfo.ru','info@blackseainfo.ru');?></li>
				<li><?=safe_mailto('sales@blackseainfo.ru','sales@blackseainfo.ru');?></li>
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