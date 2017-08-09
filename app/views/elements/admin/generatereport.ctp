<div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3><?php __($reporttitle); ?></h3></div>
	<div class="content">
		<?php echo $form->create('Orders', array('action'=>'generatedreport')); ?>
		<table border="0" cellspacing="0" cellpadding="0">
<?php
		if($search=='5'){
			if($notary=='yes'){
?>
		<tr>
				<td width="6%">Mistakes</td>
				<td width="34%"><?php echo $form->input('mistakes', array('id'=>'notary', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box  addlengthy fleft','options'=>$nmstk,'empty'=>'--Select--')); ?></td>
				<input type="hidden" id="orderstatus_id" name="data[Orders][orderstatus_id]" value="<?php echo $status;?>"/>
				<input type="hidden" id="search_type" name="data[Orders][search_type]" value="<?php echo $searchtype;?>"/>
				<input type="hidden" id="osearch" name="data[Orders][osearch]" value="<?php echo $search;?>"/>
				<td  width="38%"></td>
				<td width="27%" colspan="3"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
			</tr>
<?php 
			}
	 	}else{
			if($search=='1'){
?>
			<tr><td colspan="12" class="head"><h4><?php __("Hourly Report"); ?></h4></td></tr>
			<tr>
<?php 
				if($hour=='yes'){
?>
				<td  width="6%">From</td>
				<td width="14%">
<?php 
				$start = strtotime('12:00am');
				$end = strtotime('11:30pm');
				echo '<select name="data[Orders][time1]" id="OTime1" class="select_box small">';
				for ($i = $start; $i <= $end; $i += 1800) {
					if(date('g:i a', $i)=='8:00 am'){
						echo '<option selected="selected">' . date('g:i a', $i);
					}else{
						echo '<option>' . date('g:i a', $i);
					}
				}
				echo '</select>';
?>
				</td>
				<td  width="6%">&nbsp;&nbsp;To</td>
				<td  width="14%">
<?php 
				$start = strtotime('12:00am');
				$end = strtotime('11:30pm');
				echo '<select name="data[Orders][time2]" id="OTime2" class="select_box small">';
				for ($i = $start; $i <= $end; $i += 1800) {
					if(date('g:i a', $i)=='8:00 am'){
						echo '<option selected="selected">' . date('g:i a', $i);
					} else {
						echo '<option>' . date('g:i a', $i);
					}
				}
				echo '</select>';
?>
				</td>
				<input type="hidden" id="ohsearch" name="data[Orders][ohsearch]" value="<?php echo $search."0";?>"/>
				<td width="6%">Date </td>
				<td  width="14%"><?php echo $form->input('odate', array('class' => 'text medium', 'error' => false, 'label' => false, 'div' => false, 'id' => 'Date0'.$search ,'readonly'=>true));?></td>						
				<?php }
				
				if($company=='yes'){?>
				<td  width="6%">Company </td>
				<td  width="14%"><?php echo $form->input('company', array('class'=>'text medium', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false));?></td>
				<?php } ?>
				<? if($notary=='yes'){?>
				<td  width="6%">&nbsp;Notary</td>
				<td  width="24%"><?php echo $form->input('notary', array('id'=>'notary', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$notaryList,'empty'=>'--Select--')); ?></td>
				<?php }if($notarytype=='yes'){?>
				<td  width="6%">&nbsp;&nbsp;Type</td>
				<td  width="24%"><?php echo $form->input('notarytype', array('id'=>'notarytype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$ntyoptions,'empty'=>'--All--')); ?></td>
				<?php }if($howhear=='yes'){?>
				<td  width="6%">Hear</td>
				<td width="25%"><?php echo $form->input('heartype', array('id'=>'heartype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hearoptions,'empty'=>'--Select--')); ?></td>
				<?php }if($howheartype=='yes'){?>
				<td  width="6%">Type</td>
				<td width="20%"><?php echo $form->input('type', array('id'=>'type', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hhtype,'empty'=>'--Both--')); ?></td>
				<?php }?>
				<input type="hidden" id="orderstatus_id" name="data[Orders][orderstatus_id]" value="<?php echo $status;?>"/>
				<input type="hidden" id="search_type" name="data[Orders][search_type]" value="<?php echo $searchtype;?>"/>
				<input type="hidden" id="osearch" name="data[Orders][osearch]" value="<?php echo $search;?>"/>
				<?php if($howheartype=='yes'){?>
				<td colspan="2" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<?php }else{?>
				<td colspan="4" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<?php }?>
			</tr>
			<?php }?>
		</table>
		<?php echo $form->hidden('reporttype', array('value'=>$reporttype)); ?>
		<?php echo $form->end(); ?>		
			
		<?php echo $form->create('Orders', array('action'=>'generatedreport')); ?>
		<table border="0" cellspacing="0" cellpadding="0" class="search_box">
			<tr><td colspan="10" class="head"><h4><?php __("Daily Report"); ?></h4></td></tr>
			<tr>
			<?php if($date=='yes'){?>
				<td width="6%">Date </td>
				<td  width="34%"><?php echo $form->input('date', array('class' => 'text medium', 'error' => false, 'label' => false, 'div' => false, 'id' => 'Date'.$search ,'readonly'=>true));?></td>						
				<?php }if($company=='yes'){?>
				<td  width="6%">Company </td>
				<td  width="24%"><?php echo $form->input('company', array('class'=>'text', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false));?></td>
				<?php }?>
				<? if($notary=='yes'){?>
				<td  width="6%">&nbsp;Notary</td>
				<td  width="24%"><?php echo $form->input('notary', array('id'=>'notary', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$notaryList,'empty'=>'--Select--')); ?></td>
				<?php }if($notarytype=='yes'){?>
				<td  width="6%">&nbsp;&nbsp;Type</td>
				<td  width="24%"><?php echo $form->input('notarytype', array('id'=>'notarytype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$ntyoptions,'empty'=>'--All--')); ?></td>
				<?php }if($howhear=='yes'){?>
				<td  width="6%">Hear</td>
				<td width="25%"><?php echo $form->input('heartype', array('id'=>'heartype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hearoptions,'empty'=>'--Select--')); ?></td>
				<?php }if($howheartype=='yes'){?>
				<td  width="6%">Type</td>
				<td width="20%"><?php echo $form->input('type', array('id'=>'type', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hhtype,'empty'=>'--Both--')); ?></td>
				<?php }?>
				<input type="hidden" id="orderstatus_id" name="data[Orders][orderstatus_id]" value="<?php echo $status;?>"/>
				<input type="hidden" id="search_type" name="data[Orders][search_type]" value="<?php echo $searchtype;?>"/>
				<input type="hidden" id="osearch" name="data[Orders][osearch]" value="<?php echo $search;?>"/>
				<?php if($howheartype=='yes'){?>
				<td colspan="2" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<? }else{?>
				<td colspan="4" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<? }?></tr>
		</table>
		<?php echo $form->hidden('reporttype', array('value'=>$reporttype)); ?>
		<?php echo $form->end(); ?>
		
		<?php echo $form->create('Orders', array('action'=>'generatedreport')); ?>
		<table border="0" cellspacing="0" cellpadding="0" class="search_box">
		<tr><td colspan="10" class="head"><h4><?php __("Weekly Report"); ?></h4></td></tr>
			<tr>
			<?php if($from=='yes'){?>
				<td  width="6%">From </td>
				<td width="14%"><?php echo $form->input('from_date', array('class' => 'text small', 'error' => false, 'label' => false, 'div' => false, 'id' => 'Fromdate'.$search ,'readonly'=>true));?></td>						
				<?php }if($to=='yes'){?>
				<td  width="6%">&nbsp;&nbsp;To </td>
				<td  width="14%"><?php echo $form->input('to_date', array('class' => 'text small', 'error' => false, 'label' => false, 'div' => false,'id'=>'Todate'.$search,'readonly'=>true));?></td>
				<?php }
				
				if($company=='yes'){?>
				<td  width="6%">Company </td>
				<td  width="24%"><?php echo $form->input('company', array('class'=>'text', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false));?></td>
				<?php } ?>
				<? if($notary=='yes'){?>
				<td  width="6%">&nbsp;Notary</td>
				<td  width="24%"><?php echo $form->input('notary', array('id'=>'notary', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$notaryList,'empty'=>'--Select--')); ?></td>
				<?php }if($notarytype=='yes'){?>
				<td  width="6%">&nbsp;&nbsp;Type</td>
				<td  width="24%"><?php echo $form->input('notarytype', array('id'=>'notarytype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$ntyoptions,'empty'=>'--All--')); ?></td>
				<?php }if($howhear=='yes'){?>
				<td  width="6%">Hear</td>
				<td width="25%"><?php echo $form->input('heartype', array('id'=>'heartype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hearoptions,'empty'=>'--Select--')); ?></td>
				<?php }if($howheartype=='yes'){?>
				<td  width="6%">Type</td>
				<td width="20%"><?php echo $form->input('type', array('id'=>'type', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hhtype,'empty'=>'--Both--')); ?></td>
				<?php }?>
				<input type="hidden" id="orderstatus_id" name="data[Orders][orderstatus_id]" value="<?php echo $status;?>"/>
				<input type="hidden" id="search_type" name="data[Orders][search_type]" value="<?php echo $searchtype;?>"/>
				<input type="hidden" id="osearch" name="data[Orders][osearch]" value="<?php echo $search;?>"/>
				<?php if($howheartype=='yes'){?>
				<td colspan="2" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<?php }else{?>
				<td colspan="4" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<?php }?>
			</tr>
			
		</table>
		<?php echo $form->hidden('reporttype', array('value'=>$reporttype)); ?>
		<?php echo $form->end(); ?>
		<?php echo $form->create('Orders', array('action'=>'generatedreport')); ?>
		<table border="0" cellspacing="0" cellpadding="0" class="search_box">
				<tr><td colspan="10" class="head"><h4><?php __("Monthly Report"); ?></h4></td></tr>
			<tr>
			<?php if($month=='yes'){?>
			
				<td  width="6%">&nbsp;Month</td>
				<td width="14%"><?php echo $form->month('',@$_SESSION['search']['params']['month'],array('class'=>'select_box small', 'empty'=>'--Month--'));?></td>
			<?php }if($year=='yes'){?>
			
				<td  width="6%">&nbsp;Year</td>
				<td width="14%"> <?php echo $form->year('', 2010, date('Y')+1, @$_SESSION['search']['params']['year'], array('class'=>'select_box small', 'empty'=>'--Year--')); ?></td>
<?php 
			}
			if($company=='yes') {
?>
				<td  width="6%">Company </td>
				<td width="24%"><?php echo $form->input('company', array('class'=>'text', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false));?></td>
				<?php }
				 if($notary=='yes'){?>
				<td  width="6%">&nbsp;Notary</td>
				<td width="24%"><?php echo $form->input('notary', array('id'=>'notary', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$notaryList,'empty'=>'--Select--')); ?></td>
				<?php }if($notarytype=='yes'){?>
				<td  width="6%">&nbsp;&nbsp;Type</td>
				<td  width="24%"><?php echo $form->input('notarytype', array('id'=>'notarytype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$ntyoptions,'empty'=>'--All--')); ?></td>
				<?php }if($howhear=='yes'){?>
				<td  width="6%">Hear</td>
				<td width="25%"><?php echo $form->input('heartype', array('id'=>'heartype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hearoptions,'empty'=>'--Select--')); ?></td>
				<?php }if($howheartype=='yes'){?>
				<td  width="6%">Type</td>
				<td width="20%"><?php echo $form->input('type', array('id'=>'type', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hhtype,'empty'=>'--Both--')); ?></td>
				<?php }?>
				<input type="hidden" id="orderstatus_id" name="data[Orders][orderstatus_id]" value="<?php echo $status;?>"/>
				<input type="hidden" id="search_type" name="data[Orders][search_type]" value="<?php echo $searchtype;?>"/>
				<input type="hidden" id="osearch" name="data[Orders][osearch]" value="<?php echo $search;?>"/>
				<?php if($howheartype=='yes'){?>
				<td colspan="2" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<?php }else{?>
				<td colspan="4" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<?php }?>
				</tr>
		</table>
		<?php echo $form->hidden('reporttype', array('value'=>$reporttype)); ?>
		<?php echo $form->end(); ?>
		<?php echo $form->create('Orders', array('action'=>'generatedreport')); ?>
		<table border="0" cellspacing="0" cellpadding="0" class="search_box">
				<tr><td colspan="8" class="head"><h4><?php __("Yearly Report"); ?></h4></td></tr>
			<tr>
			<?php if($year=='yes'){?>
			
				<td width="6%">Year</td>
				<td width="34%"><?php echo $form->year('', 2010, date('Y')+1, @$_SESSION['search']['params']['year'], array('class'=>'select_box medium', 'empty'=>'--Year--')); ?></td>
					<?php }if($company=='yes'){?>
				<td  width="6%">Company </td>
				<td width="24%"><?php echo $form->input('company', array('class'=>'text', 'maxlength'=>'50', 'error'=>false, 'label'=>false, 'div'=>false));?></td>
				<?php }?>
				<?php if($notary=='yes'){?>
				<td  width="6%">&nbsp;Notary</td>
				<td width="24%"><?php echo $form->input('notary', array('id'=>'notary', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$notaryList,'empty'=>'--Select--')); ?></td>
				<?php }if($notarytype=='yes'){?>
				<td  width="6%">&nbsp;&nbsp;Type</td>
				<td width="24%"><?php echo $form->input('notarytype', array('id'=>'notarytype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$ntyoptions,'empty'=>'--All--')); ?></td>
				<?php }if($howhear=='yes'){?>
				<td  width="6%">Hear</td>
				<td width="25%"><?php echo $form->input('heartype', array('id'=>'heartype', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hearoptions,'empty'=>'--Select--')); ?></td>
				<?php }if($howheartype=='yes'){?>
				<td  width="6%">Type</td>
				<td width="20%"><?php echo $form->input('hhtype', array('id'=>'type', 'error'=>false, 'label'=>false, 'div'=>false,'class'=>'select_box','options'=>$hhtype,'empty'=>'--Both--')); ?></td>
				<?php }?>
				<input type="hidden" id="orderstatus_id" name="data[Orders][orderstatus_id]" value="<?php echo $status;?>"/>
				<input type="hidden" id="search_type" name="data[Orders][search_type]" value="<?php echo $searchtype;?>"/>
				<input type="hidden" id="osearch" name="data[Orders][osearch]" value="<?php echo $search;?>"/>
				<?php if($howheartype=='yes'){?>
				<td colspan="2" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<?php }else{?>
				<td colspan="4" width="25%"><?php __($form->submit('Generate', array('div' => false, 'class' => 'submit small fleft'))); ?></td>
				<?php }?>
			</tr>
			<?php }?>
			<?php echo $form->hidden('reporttype', array('value'=>$reporttype)); ?>
		</table>
		<?php echo $form->end(); ?>
		
	</div>
</div>
