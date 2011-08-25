<?= form_open($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="book-form">
		<div id="error-msg" class=""><?=validation_errors();?></div>
		<label>Логин: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="login" name="login" value="<?=set_value('login');?>" maxlength="100" placeholder="Введите логин" />
		<label>Пароль: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="password" class="inpvalue" id="pass" name="pass" value="" placeholder="Введите пароль" />
		<div>&nbsp;</div>
		<input class="" id="btnsubmit" type="submit" name="submit" value="Авторизироватся"/>
	</div>
<?= form_close(); ?>