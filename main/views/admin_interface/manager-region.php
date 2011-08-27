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
			<?php if(count($regions)): ?>
					<h2 class="font-replace"><?=$name;?></h2>
					<hr/>
					<h2 class="font-replace">Внимание! После изменения псевдонимов городов обновите страницу</h2>
					<div id="error-msg" class=""><?=validation_errors();?></div>
					<table summary="Зоны отдыха">
						<thead>
							<tr class="odd">
								<th scope="col" abbr="ID">ID</th>
								<th scope="col" abbr="ГОРОД">ГОРОД</th>	
								<th scope="col" abbr="ОБЛАСТЬ">ОБЛАСТЬ/РАЙОН/КРАЙ</th>
								<th scope="col" abbr="СТРАНА">СТРАНА</th>
								<th scope="col" abbr="ПСЕВДОНИМ">ПСЕВДОНИМ</th>
								<th scope="col" abbr="ПРИОРИТЕТ">ПРИОРИТЕТ</th>
								<th scope="col" abbr="ДЕЙСТВИЯ">&nbsp;</th>
							</tr>	
						</thead>
					    <tfoot>	
						 	&nbsp;
						</tfoot>
						<tbody>
						<?php for($i=0;$i<count($regions);$i++):?>
							<?php if($i % 2 !== 0): ?>
								<tr rID="<?=$i?>"> 
							<?php else: ?>
								<tr class="odd" rID="<?=$i?>"> 
							<?php endif; ?>
								<td rID="<?=$i?>"><?=$regions[$i]['reg_id'];?></td>
	<td><input placeholder="Введите значение" id="vName<?=$i?>" rID="<?=$i?> name="name" type="text" value="<?=$regions[$i]['reg_name'];?>"></td>
	<td><input placeholder="Введите значение" id="vArea<?=$i?>" rID="<?=$i?> name="area" type="text" value="<?=$regions[$i]['reg_area'];?>"></td>
	<td><input placeholder="Введите значение" style="width:80px;" id="vDistrict<?=$i?>" rID="<?=$i?> name="district" type="text" value="<?=$regions[$i]['reg_district'];?>"></td>
	<td><input placeholder="Введите значение" class="literal" id="vAlias<?=$i?>" rID="<?=$i?> name="alias" type="text" value="<?=$regions[$i]['reg_alias'];?>"></td>
	<td><input placeholder="Введите значение" class="digital" style="width:80px;" id="vPriority<?=$i?>" rID="<?=$i?> name="priority" type="text" value="<?=$regions[$i]['reg_priority'];?>"></td>
								<td>
									<div class="">
						<input type="image" title="Сохранить" class="BtnSave" class="" id="s<?=$i?>" rID="<?=$i?>" src="<?=$baseurl;?>images/buttons/save.png" />
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
					<?php $this->load->view('admin_interface/insert-region-form');?>
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
			if($("#district").val() == ''){err = true;$("#district").css('border-color','#ff0000');}
			if($("#alias").val() == ''){err = true;$("#alias").css('border-color','#ff0000');}
			if($("#priority").val() == ''){err = true;$("#priority").css('border-color','#ff0000');}
			if(err){event.preventDefault();msgerror('Пропущены обязательные поля');}
		});
		
		$("#valid-alias").click(function(event){
			if($("#alias").val() == ''){
				$("#alias").css('border-color','#ff0000');
				msgerror('Поле не может быть пустым');
				return false;
			}
			$.post("<?=$baseurl;?>admin/manager/regions/valid-alias",{'alias':$("#alias").val()},
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
			if(e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){return false;}
		});
		$(".literal").keypress(function(e){
			if(e.which!=8 && e.which!=0 && e.which!=45 && (e.which<97 || e.which>122)){return false;}
		});
		
		$(".BtnSave").click(function(){
			var err = false;
			var curID = $(this).attr("rID");
			var regID = $("td[rID='"+curID+"']").text();
			var objName = $("#vName"+curID);
			var objArea = $("#vArea"+curID);
			var objDistrict = $("#vDistrict"+curID);
			var objAlias = $("#vAlias"+curID);
			var objPriority = $("#vPriority"+curID);
			var valName = $(objName).val();
			var valArea = $(objArea).val();
			var valDistrict = $(objDistrict).val();
			var valAlias = $(objAlias).val();
			var valPriority = $(objPriority).val();
			$(objName).css('border-color','#D0D0D0');
			$(objArea).css('border-color','#D0D0D0');
			$(objDistrict).css('border-color','#D0D0D0');
			$(objAlias).css('border-color','#D0D0D0');
			$(objPriority).css('border-color','#D0D0D0');
			if(valName == ""){$(objName).css('border-color','#ff0000');err = true;}
			if(valDistrict == ""){$(objDistrict).css('border-color','#ff0000');err = true;}
			if(valAlias == ""){$(objAlias).css('border-color','#ff0000');err = true;}
			if(valPriority == ""){$(objPriority).css('border-color','#ff0000');err = true;}
			if(err){
				msgerror('Пропущены обязательные поля');return false;
			}else{
				$.post("<?=$baseurl;?>admin/manager/regions/save",
				{'id':regID,'name':valName,'area':valArea,'distr':valDistrict,'alias':valAlias,'priority':valPriority},
				function(data){
					if(data.status){
						$(objName).val(data.name);$(objArea).val(data.area);
						$(objDistrict).val(data.distr);$(objAlias).val(data.alias);
						$(objPriority).val(data.priority);
						$(objName).css('border-color','#00ff00');$(objArea).css('border-color','#00ff00');
						$(objDistrict).css('border-color','#00ff00'); $(objAlias).css('border-color','#00ff00');
						$(objPriority).css('border-color','#00ff00');
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