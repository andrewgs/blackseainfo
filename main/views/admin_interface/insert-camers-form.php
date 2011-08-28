<?= form_open_multipart($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="book-form">
		<label>Название: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="title" name="title" value="<?=set_value('title');?>" maxlength="100" placeholder="Введите название"/>	
		<div>&nbsp;</div>
		<input class="text-form-input inpvalue" id="userfile" type="file" name="userfile">
		<div>Поддерживаемые форматы: JPG, GIF, PNG</div>
		<label>Описание:</label>
		<textarea placeholder="Введите описание" id="note" class="inpvalue" name="note"><?=set_value('note');?></textarea>
		
		<div>&nbsp;</div>
		<input class="" id="addItem" type="submit" name="submit" value="Добавить"/>
	</div>
<?= form_close(); ?>