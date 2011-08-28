<?= form_open($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="region-form">
		<label>Город: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="name" name="name" value="<?=set_value('name');?>" maxlength="100" placeholder="Введите город"/>
		<label>Область/район/край:</label>
		<input type="text" class="inpvalue" id="area" name="area" value="<?=set_value('area');?>" maxlength="100" placeholder="Введите область"/>
		<label>Страна: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="district" name="district" value="<?=set_value('district');?>" maxlength="100" placeholder="Введите страну"/>
		<label>Псевдоним: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue literal" id="alias" name="alias" value="<?=set_value('alias');?>" maxlength="100" placeholder="Введите псевдоним"/>
		<button id="valid-alias">Проверить</button>
		<label>Приоритет: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue digital" id="priority" name="priority" value="<?=set_value('priority');?>" maxlength="100" placeholder="Введите приоритет"/>
		<div>&nbsp;</div>
		<input class="" id="addItem" type="submit" name="submit" value="Добавить"/>
	</div>
<?= form_close(); ?>