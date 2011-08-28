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
			<?php if(count($class)): ?>
					<h2 class="font-replace"><?=$name;?></h2>
					<hr/>
					<h2 class="">Для справок! Существует 4 группы.</h2>
					<ul>
						<li>Код "1" - Места отдыха (готели, гостиницы)</li>
						<li>Код "2" - Экскурсии</li>
						<li>Код "3" - Развлечения (ночные клубы, гостиницы и т.д.) </li>
						<li>Код "4" - Такси</li>
					</ul>
					<div id="error-msg" class=""><?=validation_errors();?></div>
					<table summary="Классы услуг">
						<thead>
							<tr class="odd">
								<th scope="col" abbr="ID">ID</th>
								<th scope="col" abbr="НАЗВАНИЕ">НАЗВАНИЕ</th>	
								<th scope="col" abbr="ГРУППА">ГРУППА</th>
								<th scope="col" abbr="ПСЕВДОНИМ">ПСЕВДОНИМ</th>
								<th scope="col" abbr="ДЕЙСТВИЯ">&nbsp;</th>
							</tr>	
						</thead>
					    <tfoot>	
						 	&nbsp;
						</tfoot>
						<tbody>
						<?php for($i=0;$i<count($class);$i++):?>
							<?php if($i % 2 !== 0): ?>
								<tr rID="<?=$i?>"> 
							<?php else: ?>
								<tr class="odd" rID="<?=$i?>"> 
							<?php endif; ?>
								<td rID="<?=$i?>"><?=$class[$i]['tps_id'];?></td>
	<td><input placeholder="Введите название" id="vName<?=$i?>" rID="<?=$i?> name="name" type="text" value="<?=$class[$i]['tps_name'];?>"></td>
	<td><input placeholder="Укажите группу" class="digital" maxlength="1" style="width:50px;" id="vGroup<?=$i?>" rID="<?=$i?> name="group" type="text" value="<?=$class[$i]['tps_group'];?>"></td>
	<td><input placeholder="Введите превдоним" class="literal" id="vAlias<?=$i?>" rID="<?=$i?> name="alias" type="text" value="<?=$class[$i]['tps_alias'];?>"></td>
								<td>
									<div class="">
						<input type="image" title="Сохранить" class="BtnSave" id="s<?=$i?>" rID="<?=$i?>" src="<?=$baseurl;?>images/buttons/save.png" />
									</div>
								</td> 
							</tr>
							<?php endfor; ?>	
						</tbody>
					</table>
			<?php else: ?>
					<h2 class="font-replace">Информация отсутствует</h2>
			<?php endif; ?>
					<div id="frmInsert" style="display:none;">
						<?php $this->load->view('admin_interface/insert-types-form');?>
					</div>
					<button id="btnInsert" style="height:2.5em; margin-top:15px; min-width: 130px;">
						<img src="<?=$baseurl;?>images/buttons/news-plus.png"><font size="3"> Добавить</font>
					</button>
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
				var height = ($(window).height()*$("tr").size())/30;
				$("html, body").animate({scrollTop:height+'px'},"slow");
			}else{
				$("#frmInsert").slideUp("slow",function(){
					$("#frmInsert").hide();
					$("#error-msg").text('');
					$("#btnInsert").html('<img src="<?=$baseurl;?>images/buttons/news-plus.png"><font size="3"> Добавить</font>');
					$("#reserve-form .inpvalue").val('');
					$("#reserve-form .inpvalue").css('border-color','#D0D0D0');
				 });
			}
		});
		
		$("#addItem").click(function(event){
			var err = false;
			 $("#reserve-form .inpvalue").css('border-color','#D0D0D0');
			if($("#name").val() == ''){err = true;$("#name").css('border-color','#ff0000');}
			if($("#alias").val() == ''){err = true;$("#alias").css('border-color','#ff0000');}
			if(err){event.preventDefault();msgerror('Пропущены обязательные поля');}
		});
		
		$("#valid-alias").click(function(event){
			if($("#alias").val() == ''){
				$("#alias").css('border-color','#ff0000');
				msgerror('Поле не может быть пустым');
				return false;
			}
			$.post("<?=$baseurl;?>admin/manager/class/valid-alias",{'alias':$("#alias").val()},
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