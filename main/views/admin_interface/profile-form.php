<?= form_open($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="book-form">
		<div id="error-msg" class=""><?=validation_errors();?></div>
		<label>Логин (E-mail): <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="login" name="login" value="<?=$userinfo['uemail']?>" maxlength="100" placeholder="Введите логин" />
		<label>Ф.И.О.: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="name" name="name" value="<?=$userinfo['uname']?>" maxlength="100" placeholder="Введите ФИО" />
		<label>Новый пароль: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="password" class="inpvalue" id="newpass" name="newpass" value="" placeholder="Новый пароль" />
		<label>Подтвердите пароль: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="password" class="inpvalue" id="confpass" name="confpass" value="" placeholder="Подтвердите пароль" />
		<div>&nbsp;</div>
		<input class="" id="btnsubmit" type="submit" name="submit" value="Сохранить"/>
	</div>
<?= form_close(); ?>