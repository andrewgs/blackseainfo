<div id="sidebar" class="white-texture rounded">
	<div class="region-wrapper scroll-pane">
		<ul class="region-list">
		<?php $country = -1; ?>
		<?php $area = ""; ?>
	<?php for($i=0;$i<count($regions);$i++):?>
		<?php $cur_country = $regions[$i]['reg_priority']; ?>
		<?php if($country != $cur_country):?>
			<li><?=anchor('#',$regions[$i]['reg_district'],array('class'=>'country'));?></li>
		<?php $country = $cur_country; ?>
		<?php endif; ?>
		<?php $cur_area = $regions[$i]['reg_area']; ?>
		<?php if($cur_area != "none"): ?>
			<?php if($area != $cur_area):?>
				<li><?=anchor('#',$regions[$i]['reg_area'],array('class'=>'region'));?></li>
			<?php $area = $cur_area; ?>
			<?php endif; ?>
		<?php endif; ?>
			<li><?=anchor('zone/'.$regions[$i]['reg_id'].'/',$regions[$i]['reg_name']);?></li>
	<?php endfor; ?>
		</ul>				
	</div>
</div>