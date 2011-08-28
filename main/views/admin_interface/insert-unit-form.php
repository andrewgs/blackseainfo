<?= form_open_multipart($this->uri->uri_string(),array('id'=>'insert-unit','class'=>'content-form')); ?>
	<div id="unit-form">
		<input type="hidden" name="type" value="<?=$curtype;?>"/> 
		<input type="hidden" name="class" value="<?=$curclass;?>"/>
		<label>Название: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="name" name="name" value="<?=set_value('name');?>" placeholder="Введите название"/>	
		<div>&nbsp;</div>
		<input class="text-form-input" id="userfile" type="file" name="userfile">
		<div>Поддерживаемые форматы: JPG, GIF, PNG</div>
		<div>&nbsp;</div>
		<label>Короткое описание:</label>
		<textarea placeholder="Введите текст" id="short" class="inpvalue" name="short"><?=set_value('short');?></textarea>
		<label>Полное описание:</label>
		<textarea placeholder="Введите текст" id="note" class="inpvalue" name="note"><?=set_value('note');?></textarea>
		<label>Цены:</label>
		<textarea placeholder="Введите текст" id="price" class="inpvalue" name="price"><?=set_value('price');?></textarea>
		<label>Псевдоним: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue literal" id="alias" name="alias" value="<?=set_value('alias');?>" maxlength="100" placeholder="Введите псевдоним"/>
		<button id="valid-alias">Проверить</button>
		<div>&nbsp;</div>
		<input class="" id="addItem" type="submit" name="addunit" value="Добавить"/>
	</div>
<?= form_close(); ?>