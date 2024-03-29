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
					<h2 class="font-replace"><?=$name;?></h2>
					<hr/>
					<div class="">
						<?php $region = $this->uri->segment(2);?>
						<?=anchor('admin/'.$region.'/manager/resorts-photo','Фотографии');?>
						<?=anchor('admin/'.$region.'/manager/video','Видео материалы');?>
						<?=anchor('admin/'.$region.'/manager/camers','Веб-камеры');?>
					</div>
					<hr/>
					<?php $this->load->view('admin_interface/select-class-form');?>
					<div>&nbsp;</div>
					<hr/>
					<h2 class="font-replace"><?=$classname;?></h2>
					<div id="frmInsert" style="display:none;">
						<?php $this->load->view('admin_interface/insert-unit-form');?>
					</div>
					<button id="btnInsert" style="height:2.5em; margin-top:5px; min-width: 130px;">
						<img src="<?=$baseurl;?>images/buttons/plus2.png"><font size="3"> Добавить</font>
					</button>
					<div>&nbsp;</div>
				<?php if(count($catalog)): ?>
					<?php for($i=0;$i<count($catalog);$i++): ?>
					<div class="advertisment clearfix">
						<h3 class="font-replace"><?=$catalog[$i]['ctl_name'];?></h3>
						<img src="<?=$baseurl;?>catalog/viewimage/<?=$catalog[$i]['ctl_id'];?>" alt="<?=$catalog[$i]['ctl_name'];?>" title="<?=$catalog[$i]['ctl_name'];?>"/>
						<div><?=$catalog[$i]['ctl_short'];?></div>
						<?=anchor('admin/'.$this->uri->segment(2).'/manager/view-unit/'.$catalog[$i]['ctl_alias'],'Просмотреть');?>
						<?=anchor('','Редактировать');?>
						<?=anchor('','Фотографии');?>
						<?=anchor('','Удалить');?>
					</div>
				<?php endfor;?>
			<?php else: ?>
						<h2 class="font-replace">Информация отсутствует</h2>
			<?php endif; ?>
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

<script type="text/javascript">
	$(document).ready(function(){
		
		$("#btnInsert").click(function(){
			if($("#frmInsert").is(":hidden")){
				$("#btnInsert").html('<img src="<?=$baseurl;?>images/buttons/arrow-curve.png"><font size="3"> Отменить</font>');
				$("#frmInsert").slideDown("slow");
				$("html, body").animate({scrollTop:'350px'},"slow");
			}else{
				$("#frmInsert").slideUp("slow",function(){
					$("#frmInsert").hide();
					$("#error-msg").text('');
					$("#btnInsert").html('<img src="<?=$baseurl;?>images/buttons/news-plus.png"><font size="3"> Добавить</font>');
					$("#insert-unit .inpvalue").val('');
					$("#userfile").val('');
					$("#insert-unit .inpvalue").css('border-color','#D0D0D0');
					$("html, body").animate({scrollTop:'0px'},"slow");
				 });
			}
		});
		
		$("#addItem").click(function(event){
			var err = false;
			 $("#insert-unit .inpvalue").css('border-color','#D0D0D0');
			 $("#insert-unit .inpvalue").each(function(){
			 	if($(this).val() == ''){
					err = true;
					$(this).css('border-color','#ff0000');
				}
			 });
			if(err){event.preventDefault();msgerror('Пропущены обязательные поля');}
			if($("#userfile").val() == ''){event.preventDefault();msgerror('Не указан файл');}
		});
		
		$("#valid-alias").click(function(event){
			if($("#alias").val() == ''){
				$("#alias").css('border-color','#ff0000');
				msgerror('Поле не может быть пустым');
				return false;
			}
			$.post("<?=$baseurl;?>admin/manager/unit/valid-alias",
				{'alias':$("#alias").val(),'region':'<?=$this->uri->segment(2);?>'},
					function(data){
						if(data.status){
							$("#alias").css('border-color','#00ff00');msgerror(data.message);
						}else{
							$("#alias").css('border-color','#ff0000');msgerror(data.message);
						}
					},"json");
			event.preventDefault();
		});
		
		$(".digital").keypress(function(e){
			if(e.which!=8 && e.which!=0 && (e.which<49 || e.which>52)){return false;}
		});
		$(".literal").keypress(function(e){
			if(e.which!=8 && e.which!=0 && e.which!=45 && (e.which<97 || e.which>122)){return false;}
		});
		
		$(".BtnSave").click(function(){
			var err = false;
			var curID = $(this).attr("rID");
			var regID = $("td[rID='"+curID+"']").text();
			var objName = $("#vName"+curID);
			var objGroup = $("#vGroup"+curID);
			var objAlias = $("#vAlias"+curID);
			var valName = $(objName).val();
			var valGroup = $(objGroup).val();
			var valAlias = $(objAlias).val();
			$(objName).css('border-color','#D0D0D0');
			$(objGroup).css('border-color','#D0D0D0');
			$(objAlias).css('border-color','#D0D0D0');
			if(valName == ""){$(objName).css('border-color','#ff0000');err = true;}
			if(valAlias == ""){$(objAlias).css('border-color','#ff0000');err = true;}
			if(err){
				msgerror('Пропущены обязательные поля');return false;
			}else{
				$.post("<?=$baseurl;?>admin/manager/class/save",
				{'id':regID,'name':valName,'group':valGroup,'alias':valAlias},
				function(data){
					if(data.status){
						$(objName).val(data.name);$(objGroup).val(data.group);$(objAlias).val(data.alias);						
						$(objName).css('border-color','#00ff00');$(objGroup).css('border-color','#00ff00');
						$(objAlias).css('border-color','#00ff00');						
					}else{
						if(data.alias) $(objAlias).css('border-color','#ff0000');
						msgerror(data.message);
					}
				},"json");
			};
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

<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
</body>
</html>