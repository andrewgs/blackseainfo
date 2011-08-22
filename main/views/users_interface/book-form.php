<?= form_open($this->uri->uri_string()); ?>
	<div id="book-form">
		<div id="error-msg" class=""></div>
		<label class="label-input">Объект: <span class="necessarily" title="Поле не может быть пустым">*</span></label>
		<div>&nbsp;</div>
		<?= form_error('title'); ?>
		<input class="inpvalue" id="unit-title" name="title" type="text" value="<?=$unit['ctl_name']?>" maxlength="200"/>
		<div>&nbsp;</div>
		<label class="label-input">Контактная информация: <span class="necessarily" title="Поле не может быть пустым">*</span></label>
		<div>&nbsp;</div>
		<?= form_error('info'); ?>
		<textarea class="inpvalue" name="info" id="cust-info" cols="73" rows="10"></textarea>
		<div>&nbsp;</div>
		<input class="btn-action" id="btnsubmit" type="submit" name="submit" value="Забронировать"/>
	</div>
	<div>&nbsp;</div>
<?= form_close(); ?>