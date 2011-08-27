<div class="list-sidebar">
<?php if($userinfo['status']):?>
	<?=$this->load->view('admin_interface/sidebar-menu');?>
<?php endif; ?>
<?php if(isset($subtype)): ?>	
	<h2 class="font-replace">Подразделы</h2>
	<div id="subtype" class="widget clearfix">
		<ul class="region-list">
		<?php for($i=0;$i<count($subtype);$i++): ?>
			<li><?=anchor('resort/'.$this->uri->segment(2).'/'.$subtype[$i]['tps_alias'],$subtype[$i]['tps_name']);?></li>
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
<?php if(count($slide)):?>
	<?=anchor('resort/'.$this->uri->segment(2).'/resorts-photo','<h2 class="font-replace">Фотопленка</h2>');?>
	<div id="photo-stream" class="widget">
	<?php for($i=0;$i<count($slide);$i++): ?>
		<img src="<?=$baseurl;?>material/viewimage/<?=$slide[$i]['id'];?>" alt="<?=$slide[$i]['title'];?>" title="<?=$slide[$i]['title'];?>" width="210" height="157"/>
	<?php endfor; ?>
	 </div>
<?php endif; ?>
<?php if(count($video)):?>
	<?=anchor('resort/'.$this->uri->segment(2).'/video','<h2 class="font-replace">Видео</h2>');?>
	<div id="video-stream" class="widget">
	<?php for($i=0;$i<count($video);$i++): ?>
		<iframe src="<?=$video[$i]['link'];?>" width="210" height="118" frameborder="0"></iframe>
	<?php endfor; ?>
	 </div>
<?php endif; ?>
<?php if(count($news)):?>
	<?=anchor('resort/'.$this->uri->segment(2).'/news','<h2 class="font-replace">Новости</h2>');?>
	<div id="news-stream" class="widget">
	<?php for($i=0;$i<count($news);$i++):?>
		<strong><?=$news[$i]['title'];?></strong>
		<p><?=$news[$i]['text'];?><?=anchor('read-news/'.$news[$i]['id'],'<nobr> Читать далее &raquo;</nobr>');?></p>
	<?php endfor;?>
	</div>
<?php endif; ?>
</div>