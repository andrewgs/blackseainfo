<?= form_open($this->uri->uri_string(),array('id'=>'reserve-form','class'=>'content-form')); ?>
	<div id="book-form">
		<div id="error-msg" class=""></div>
	<?php if(isset($visible)):?>
		<label>Объект: <span class="" title="Поле не может быть пустым">*</span></label>
		<select name="catalog" placeholder="Выберите значение">
		<?php for($i=0;$i<count($catalog);$i++): ?>
	<option value="<?=$catalog[$i]['ctl_id'];?>" <?=set_select('catalog',$catalog[$i]['ctl_id'],TRUE);?>><?=$catalog[$i]['ctl_name'];?></option>
		<?php endfor; ?>
		</select>
	<?php else: ?>
		<?=form_hidden('catalog',FALSE);?>
	<?php endif; ?>
		<label>Ф.И.О.: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="cust-fio" name="fio" value="<?=set_value('fio');?>" maxlength="100" placeholder="Введите ФИО" />
		<label>E-mail: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="cust-email" name="email" value="<?=set_value('email');?>" maxlength="100" placeholder="Введите адрес E-mail" />
		<label>Телефон: <span class="" title="Поле не может быть пустым">*</span></label>
		<input type="text" class="inpvalue" id="cust-phone" name="phone" value="<?=set_value('phone');?>" maxlength="100" placeholder="Введите номер телефона" />
		<label>Текст сообщения: <span class="" title="Поле не может быть пустым">*</span></label>
		<textarea placeholder="Введите текст в поле" id="cust-info" class="inpvalue" name="note"><?=set_value('note');?></textarea>
		<input class="" id="btnsubmit" type="submit" name="submit" value="Отправить"/>
	</div>
<?= form_close(); ?>