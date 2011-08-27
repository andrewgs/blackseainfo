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
		<?=$this->load->view('admin_interface/regions');?>
		<div id="content">
			<div id="information" class="white-texture rounded clearfix">
				<div class="list-main">
					<h2 class="font-replace"><img src="<?=$baseurl;?>images/left-arrow.png"/><?=$name;?></h2>
					<h2 class="font-replace">Добавление новости</h2>
					<?=$this->load->view('admin_interface/add-news-form');?>
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
<script type="text/javascript" src="<?=$baseurl;?>js/jquery.blockUI.js"></script>
<?=$this->load->view('admin_interface/datepacker');?>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
<script type="text/javascript">
	$(document).ready(function(){
		$("#addItem").click(function(event){
			var err = false;
			 $("#reserve-form .inpvalue").css('border-color','#D0D0D0');
			if($("#title").val() == ''){err = true;$("#title").css('border-color','#ff0000');}
			if($("#date").val() == ''){err = true;$("#date").css('border-color','#ff0000');}
			if($("#text").val() == ''){err = true;$("#text").css('border-color','#ff0000');}
			if(err){event.preventDefault();msgerror('Пропущены обязательные поля');}
		});
		function msgerror(msg){
			$.blockUI({
				message: msg,
				css:{border:'none',padding:'15px', size:'12.0pt',backgroundColor:'#000',color:'#fff',opacity:'.8','-webkit-border-radius': '10px','-moz-border-radius': '10px'}
			});
			window.setTimeout($.unblockUI,1000);
			return false;
		}
	});
</script>
</body>
</html>