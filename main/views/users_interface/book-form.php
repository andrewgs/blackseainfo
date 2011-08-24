<?= form_open($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="book-form">
		<div id="error-msg" class=""></div>
		<label>Объект: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="unit-title" name="title" value="<?=$unit['ctl_name']?>" maxlength="200" placeholder="Введите название объекта" />
		<label>E-mail: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="cust-email" name="email" value="<?=set_value('email');?>" maxlength="100" placeholder="Введите адрес E-mail" />
		<label>Контактная информация: <span class="" title="Поле не может быть пустым">*</span></label>
		<textarea placeholder="Введите текст в поле" id="cust-info" class="inpvalue" name="note"><?=set_value('note');?></textarea>
		<input class="" id="btnsubmit" type="submit" name="submit" value="Отправить"/>
	</div>
	<div>&nbsp;</div>
<?= form_close(); ?>