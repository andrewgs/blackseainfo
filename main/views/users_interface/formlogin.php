<?= form_open($this->uri->uri_string(),array('id'=>'subForm','class'=>'formular rounded-corners teaser')); ?>
	<h4 class="font-replace">Введите логин и пароль</h4>
	<?=validation_errors();?>
	<?php if($error):?>
		<h5 class="fvalid_error font-replace">Не верный логин или пароль</h5>
	<? else: ?>
		<h5 class="fvalid_error font-replace">Проверьте раскладку клавиатуры</h5>
	<? endif; ?>
	<div>
		<label title="Поле не может быть пустым" for="name">Логин:</label>
		<input name="login-name" id="name" placeholder="Имя" type="text"><br>
		<label title="Поле не может быть пустым" for="email">Пароль:</label>
		<input name="login-pass" id="phikyt-phikyt" placeholder="Почта" type="text"><br>
		<input value="ОК" id="submit" type="submit" name="submit">
	</div>
<?= form_close(); ?>