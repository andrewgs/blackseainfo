<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?=$this->load->view('users_interface/head');?>
<body>
<div id="container">
	<?=$this->load->view('users_interface/header');?>
	<div id="main" role="main" class="clearfix">
		<?=$this->load->view('users_interface/regions');?>
		<div id="content">
			<div id="information" class="white-texture rounded clearfix">
				<div class="list-main">
					<h2 class="font-replace">Профиль</h2>
					<div class="advertisment clearfix">
					<?=$this->load->view('admin_interface/profile-form');?>
					<?php if($status): ?>
						<div class="">Данные сохранены</div>
					<?php endif; ?>
					</div>
				</div>
				<div class="list-sidebar">
				<?=$this->load->view('admin_interface/sidebar-menu');?>
				</div>
			</div>			
		</div>
	</div>
	<?=$this->load->view('users_interface/footer');?>
</div> <!--! end of #container -->
<?=$this->load->view('users_interface/scripts');?>
<script type="text/javascript">
	$(document).ready(function(){
	
		$("#btnsubmit").click(function(event){
			var err = false;
			var pass = $('#newpass').val();
			var confpass = $('#confpass').val();
			 $(".inpvalue").css('border-color','#D0D0D0');
			 $("#error-msg").text('');
			if($("#login").val() == ''){
				err = true;
				$("#login").css('border-color','#ff0000');
			}
			if($("#name").val() == ''){
				err = true;
				$("#name").css('border-color','#ff0000');
			}
			if(err){
				event.preventDefault();
				$("#error-msg").html('<font size="2" color="#FF0000"><b>Пропущены обязательные поля</font>');
			}else if(!isValidEmailAddress($("#login").val())){
				event.preventDefault();
				$("#error-msg").html('<font size="2" color="#FF0000"><b>Не верный логин</b></font>');
			}else if((pass.length > 0) && (pass.length < 6)){
				$("#newpass").css('border-color','#ff0000');
				event.preventDefault();
				$("#error-msg").html('<font size="2" color="#FF0000"><b>Длина пароля должна быть не менее 6 символов</b></font>');
			}else if((pass != '') && (pass != confpass)){
				$("#newpass").css('border-color','#ff0000');
				$("#confpass").css('border-color','#ff0000');
				event.preventDefault();
				$("#error-msg").html('<font size="2" color="#FF0000"><b>Пароли не совпадают</b></font>');
			}
		});
		function isValidEmailAddress(emailAddress){
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		};
	});
</script>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
</body>
</html>