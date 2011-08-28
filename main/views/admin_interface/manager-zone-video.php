<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?=$this->load->view('users_interface/head-pirobox');?>
<body>
<div id="container">
	<?=$this->load->view('users_interface/header');?>
	<div id="main" role="main" class="clearfix">
		<?=$this->load->view('admin_interface/regions');?>
		<div id="content">
			<div id="information" class="white-texture rounded clearfix">
				<div class="list-main wide clearfix">
					<h2 class="font-replace">
						<img src="<?=$baseurl;?>images/left-arrow.png"/><?=anchor($this->session->userdata('uripath'),'Вернуться назад');?>
					</h2>
					<hr/>
					<h2 class="font-replace"><?=$name;?></h2>
					<div id="error-msg" class=""><?=validation_errors();?></div>
					<div id="frmInsert" style="display:none; margin-left:5px;">
						<?php $this->load->view('admin_interface/insert-video-form');?>
					</div>
					<button id="btnInsert" style="height:2.5em; margin:10px 0px 10px 5px; min-width: 130px;">
						<img src="<?=$baseurl;?>images/buttons/plus.png"><font size="3"> Добавить</font>
					</button>
					<div id="photo-frames">
				<?php for($i=0;$i<count($video);$i++): ?>
						<div class="frames" id="vd<?=$i?>">
							<div id="id<?=$i?>" style="display:none;"><?=$video[$i]['id'];?></div>
							<iframe src="<?=$video[$i]['link'];?>" width="210" height="118" frameborder="0"></iframe>
							<br/>
							<div style="float:right;">
							<input type="image" title="Удалить" class="VideoDel" nID="<?=$i;?>" src="<?=$baseurl;?>images/buttons/delete.png"/>
							</div>
						</div>
				<?php endfor; ?>
					</div>
				</div>
			</div>			
		</div>
	</div>
	<?=$this->load->view('users_interface/footer');?>
</div> <!--! end of #container -->
<?=$this->load->view('users_interface/scripts');?>
<script type="text/javascript" src="<?=$baseurl;?>js/pirobox.min.js"></script>
<script type="text/javascript" src="<?=$baseurl;?>js/jquery.blockUI.js"></script>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
<script type="text/javascript">
	$(document).ready(function() {
		$().piroBox({my_speed: 400,bg_alpha: 0.1,slideShow : true,slideSpeed : 4,close_all : '.piro_close,.piro_overlay'});
		
		$("#btnInsert").click(function(){
			if($("#frmInsert").is(":hidden")){
				$("#btnInsert").html('<img src="<?=$baseurl;?>images/buttons/arrow-curve.png"><font size="3"> Отменить</font>');
				$("#frmInsert").slideDown("slow");
			}else{
				$("#frmInsert").slideUp("slow",function(){
					$("#frmInsert").hide();
					$("#error-msg").text('');
					$("#btnInsert").html('<img src="<?=$baseurl;?>images/buttons/plus.png"><font size="3"> Добавить</font>');
					$("#reserve-form .inpvalue").val('');
					$("#reserve-form .inpvalue").css('border-color','#D0D0D0');
				 });
			}
		});
		
		$("#addItem").click(function(event){
			$("#reserve-form .inpvalue").css('border-color','#D0D0D0');
			if($("#link").val() == ''){
				$("#link").css('border-color','#ff0000');
				event.preventDefault();
				msgerror('Пропущено обязательное поле');
			}
		});
		
		$(".VideoDel").click(function(){
				var curID = $(this).attr("nID");
				var VideoID = $("#id"+curID).text();
				$.post(
					"<?=$baseurl;?>admin/<?=$this->uri->segment(2);?>/manager/delete-video",
					{'id':VideoID},
					function(data){
						if(data.status){
							$("#vd"+curID).fadeOut("slow",function(){
								$("#vd"+curID).remove();
								if($(".frames").size() == 0) window.location="<?=$baseurl.$this->uri->uri_string();?>";
							});
						}else
							msgerror(data.message);
					},"json");
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