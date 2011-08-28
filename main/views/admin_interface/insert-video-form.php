<?= form_open($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="book-form">
		<label>Ссылка на видео материал:</label>
		<textarea placeholder="Введите ссылку" id="link" class="inpvalue" name="link"><?=set_value('link');?></textarea>
		<div>&nbsp;</div>
		<input class="" id="addItem" type="submit" name="submit" value="Добавить"/>
	</div>
<?= form_close(); ?>