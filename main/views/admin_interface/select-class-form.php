<?= form_open($this->uri->uri_string(),array('id'=>'select-class-form','class'=>'content-form')); ?>
	<div id="select-form">
		<input type="hidden" name="cclass" value="<?=$curclass;?>" id="hClass" /> 
		<select placeholder="Выберите значение" name="class" id="select-class" class="inpvalue">
		<?php for($i=0;$i<count($class);$i++): ?>
			<option value="<?=$class[$i]['tps_id'];?>"><?=$class[$i]['tps_name'];?></option>
		<?php endfor; ?>
		</select>
		<input class="" type="submit" name="sclass" value="Показать"/>
	</div>
<?= form_close(); ?>