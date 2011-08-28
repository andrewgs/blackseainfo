<?= form_open_multipart($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="type-form">
		<label>Название: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="name" name="name" value="<?=set_value('name');?>" maxlength="100" placeholder="Введите название"/>	
		<label>Группа: <span class="" title="Поле не может быть пустым">*</span></label>
		<select placeholder="Выберите значение" name="group" class="inpvalue">
			<option value="1" <?=set_select('group','1',TRUE);?> selected="selected">1. Места отдыха</option>
			<option value="2" <?=set_select('group','2');?>>2. Экскурсии</option>
			<option value="3" <?=set_select('group','3');?>>3. Развлечения</option>
			<option value="4" <?=set_select('group','4');?>>4. Такси</option>
		</select>
		<label>Псевдоним: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue literal" id="alias" name="alias" value="<?=set_value('alias');?>" maxlength="100" placeholder="Введите псевдоним"/>
		<button id="valid-alias">Проверить</button>
		<div>&nbsp;</div>
		<input class="" id="addItem" type="submit" name="submit" value="Добавить"/>
	</div>
<?= form_close(); ?>