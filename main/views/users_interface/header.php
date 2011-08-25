<header class="clearfix">
	<div id="logo"></div>
	<nav id="main-nav">
		<ul>
			<li><?=anchor('','Главная');?></li>
			<li><?=anchor('project','Участие в проекте');?></li>
			<li><?=anchor('news','Новостная лента');?></li>
			<li><?=anchor('contacts','Контакты');?></li>
		<?php if($userinfo['status']):?>
			<li><?=anchor('admin/logout','Завершить сеанс');?></li>
		<?php endif; ?>
		</ul>
	</nav>
	<div class="top-phone">
		<a href="http://twitter.com/#!/realitygroup_ru">Следуйте за нами!</a>
	</div>
	<div class="social-links">
		<a class="rss" title="Подшитесь на новости через RSS" href="http://blackseainfo.ru/rss">Подшитесь на новости через RSS</a>
		<a class="vk" title="Вступайте в нашу группу в Вконтакте" href="http://vk.com">Вступайте в нашу группу в Вконтакте</a>
		<a class="facebook" title="Станьте нашим поклонником на Facebook" href="http://facebook.com">Станьте нашим поклонником на Facebook</a>
	</div>
</header>