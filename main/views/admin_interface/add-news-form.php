<?= form_open($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="book-form">
		<label>Название новости: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="title" name="title" value="<?=set_value('title');?>" maxlength="100" placeholder="Введите название"/>
		<label>Дата новости: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="date" readonly="readonly" name="date" value="<?=set_value('date');?>" maxlength="100" placeholder="Укажите дату"/>
		<label>Текст новости:</label>
		<textarea placeholder="Введите текст" id="text" class="inpvalue" name="text"><?=set_value('text');?></textarea>
		<div>&nbsp;</div>
		<input class="" id="addItem" type="submit" name="submit" value="Добавить"/>
	</div>
<?= form_close(); ?>