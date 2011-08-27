<?= form_open($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="book-form">
		<label>Название новости: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="title" name="title" value="<?=$news['title'];?>" maxlength="100" placeholder="Введите название"/>
		<label>Дата новости: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="date" readonly="readonly" name="date" value="<?=$news['date'];?>" maxlength="100" placeholder="Укажите дату"/>
		<label>Текст новости:</label>
		<textarea placeholder="Введите текст" id="text" class="inpvalue" name="text"><?=$news['text'];?></textarea>
		<div>&nbsp;</div>
		<input class="" id="addItem" type="submit" name="submit" value="Сохранить"/>
	</div>
<?= form_close(); ?>