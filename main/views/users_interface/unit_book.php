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
			<?php if(count($unit)): ?>
				<h2 class="font-replace"><?=$name;?></h2>
				<div class="advertisment clearfix">
				<?=$this->load->view('users_interface/book-form');?>
				</div>
			<?php endif; ?>
				</div>
				<?=$this->load->view('users_interface/sidebar');?>
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
			 $(".inpvalue").css('border-color','#D0D0D0');
			 $("#error-msg").text('');
			if($("#unit-title").val() == ''){
				err = true;
				$("#unit-title").css('border-color','#ff0000');
			}
			if($("#cust-email").val() == ''){
				err = true;
				$("#cust-email").css('border-color','#ff0000');
			}
			if($("#cust-info").val() == ''){
				err = true;
				$("#cust-info").css('border-color','#ff0000');
			}
			if(err){
				event.preventDefault();
				$("#error-msg").html('<font size="2" color="#FF0000"><b>Пропущены обязательные поля</font>');
			}else if(!isValidEmailAddress($("#cust-email").val())){
				event.preventDefault();
				$("#error-msg").html('<font size="2" color="#FF0000"><b>Не верный E-mail</b></font>');
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