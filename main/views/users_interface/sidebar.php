<div class="list-sidebar">
<?php if(isset($subtype)): ?>	
	<h2 class="font-replace">Подразделы</h2>
	<div id="subtype" class="widget clearfix">
		<ul class="region-list">
		<?php for($i=0;$i<count($subtype);$i++): ?>
			<li><?=anchor('zone/'.$this->uri->segment(2).'/type/'.$subtype[$i]['tps_id'],$subtype[$i]['tps_name']);?></li>
		<?php endfor; ?>
		</ul>
	</div>
<?php endif; ?>	
	<h2 class="font-replace">Погода</h2>
	<div id="weather" class="widget clearfix">
		<img width="45px" src="http://www.google.com/ig/images/weather/cloudy.gif" />
		<div class="broadcast">
			<strong class="temperature">27 <sup>o</sup>C</strong>
			<strong>Переменная облачность</strong>
			Влажность: 32% Ветер: 3м/с 
		</div>
	</div>
	<h2 class="font-replace">Фотопленка</h2>
	<div id="photo-stream" class="widget">
		<img alt="" title="" src="<?=$baseurl;?>images/slide-sidebar.jpg"/>
	 </div>
	<h2 class="font-replace">Видео</h2>
	<div id="video-stream" class="widget">
		<iframe src="http://player.vimeo.com/video/27786807?title=0&amp;byline=0&amp;portrait=0" width="210" height="118" frameborder="0"></iframe>
	 </div>
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