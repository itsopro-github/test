<?php echo $html->css(array('styleiframe')); ?>
<?php echo $javascript->link(array('scriptpath','jquery','scripts','jquery.tools.min.js')); ?>
<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('timepicker')); ?>

<div class="block" style="background:white;">
	<?php __($form->create('Signinghistory',array('id'=>'odrstatus','url'=>array('controller'=>'signinghistories','action'=>'add')))); ?>
		<div class="fieldblock">
			<p>
				<table border="0" cellspacing="0" cellpadding="0" class="tableview">
					<tr>
						<th width="20%"><label class="form_label"><?php __('Borrower'); ?></label></th>
						<td><?php __($order['Order']['first_name'].' '.$order['Order']['last_name']); ?></td>
						<th width="20%"><label class="form_label"><?php  __('File Number'); ?></label></th>
						<td><?php echo $order['Order']['file']; ?></td>
					</tr>
					<tr>
						<th width="20%"><label class="form_label"><?php __('Date of Signing'); ?></label></th>
						<td><?php echo $counter->formatdate('nsdate',$order['Order']['date_signing']); ?></td>
						<th width="20%"><label class="form_label"><?php __('City, State'); ?></label></th>
						<td><?php echo $order['Order']['sa_city'].', '.$order['Order']['sa_state']; ?></td>
					</tr>
					<tr>
						<th width="20%"><label class="form_label"><?php __('Zip Code'); ?></label></th>
						<td colspan="3"><?php echo $order['Order']['sa_zipcode'];  ?></td>
					</tr>
				</table>
			</p>
		</div>
<?php
	if($Orderstatusid <> '7') {
?>
<script type="text/javascript">$(function(){$('#AppointmentTime').timepicker({ampm:true});});$(document).ready(function(){if($('#OrderStatus').val()==4){$('#ApptTime').css('display','block');}});</script>
		<div class="form_block">
			<p style="font-size:12px;"><label class="form_label">Status</label>
				<div class="input select"><?php __($form->input('Signinghistory.orderstatus_id',array('error'=>false,'label'=>false,'onchange'=>'showAppttime()','div'=>false,'id'=>'OrderStatus','options'=>$Orderstatus,'selected'=>$order['Order']['orderstatus_id'], 'class'=>'select_box'))); ?></div>
			</p>
		</div>
<?php __($form->input('Signinghistory.cur_orderstatus_id',array('type'=>'hidden','value'=>$Orderstatusid))); ?>
		<div class="form_block">
			<div id="ApptTime" <?=(@$order['Order']['orderstatus_id']=='4') ? 'style="display:block;"' : 'style="display:none;"'?>>	
				<p style="font-size:12px;"><label class="form_label">Appointment Time<span class="mandatory">*</span></label>
<?php
					$start = strtotime('12:00 AM');
					$end = strtotime('11:30 PM');
					$crntapttime = (isset($crntapttime)=='') ? '8:00 am' : $crntapttime;
					echo '<select name="data[Signinghistory][appointment_time]" id="AppointmentTime" class="select_box">';
						for ($i = $start; $i <= $end; $i += 1800) {
							if(date('g:i a', $i) != $crntapttime) {
								echo '<option value="'.date('g:i a', $i).'">'.date('g:i a', $i).'</option>';
							} else {
								echo '<option value="'.date('g:i a', $i).'" selected="selected">'.$crntapttime.'</option>';
							}
						}
					echo '</select>';
?>
				</p>
			</div>
			<div id="Track1" style="display:none"  width="100%">	
				<p style="font-size:12px;" width="50%"><label class="form_label">Shipping Info</label>
					<?php echo $form->input('track_shipping_info', array('class'=>'select_box', 'error'=>false,'id'=>'ShippingInfo', 'label'=>false, 'div'=>false, 'options'=>$shipoptions)); ?>
				</p>
				<p style="font-size:12px;" width="50%"><label class="form_label" style="color:#ff0000"><b>Tracking #</b></label>
					<div style="height:10px;" class="input text" >	<?php __($form->input('tracking_no',array('error'=>false,'label'=>false,'id'=>'Tracking','class'=>'text_box', 'label'=>false, 'div'=>false,))); ?></div>
				</p>
			</div>
		</div>
<?php
		} else { 
?>
		<div class="form_block">
			<?php __($form->input('Signinghistory.orderstatus_id',array('type'=>'hidden','name'=>'data[Signinghistory][orderstatus_id]','value'=>$Orderstatusid))); ?>
			<input type="hidden"  name="data[Signinghistory][order_name]" value="<?php echo Inflector::slug($order['Order']['first_name'].' '.$order['Order']['last_name']);?>" />
			<div>
				<p style="font-size:12px;"><label class="form_label">Shipping Info</label>
					<?php echo $form->input('track_shipping_info', array('class'=>'select_box', 'error'=>false,'id'=>'ShippingInfo', 'label'=>false, 'div'=>false, 'options'=>$shipoptions)); ?>
				</p>
				<p style="font-size:12px;"><label class="form_label" style="color:#ff0000"><b>Tracking #</b></label>
					<?php __($form->input('tracking_no',array('error'=>false,'label'=>false,'id'=>'Tracking','class'=>'text_box required', 'label'=>false, 'div'=>false))); ?>
				</p>
			</div>
		</div>
<?php
		}
?>
		<div class="form_block">
			<p style="font-size:12px;"><label class="form_label">Notes</label>
				<div id="notesdiv" class="input textarea"><?php __($form->input('Signinghistory.notes',array('style'=>'width:600px;','cols'=>'76','rows'=>'5','error'=>false,'label'=>false,'div'=>false,'id'=>'Notes','class'=>'text_area'))); ?></div>
			</p>
		</div>
		<input type="hidden"  name="data[Signinghistory][order_id]" value="<?php echo $Orderid;?>" />
<?php 	
	__($form->submit('Submit',array('div'=>false,'class'=>'submitbtn fleft')));
	__($form->submit('Cancel', array('div'=>false,'type'=>'reset','class'=>'submitbtn fleft','onclick'=>"hideBlocks('upddiv','cstatdiv');")));
	__($form->end());
?>
</div>
<script>function showAppttime(){if(document.getElementById('OrderStatus').value =='4'){document.getElementById('ApptTime').style.display="block";document.getElementById('Track1').style.display="none";$("div#notesdiv").removeClass("input textarea required");}else{document.getElementById('Track1').style.display="none";if(document.getElementById('OrderStatus').value=='7'){$("div#notesdiv").removeClass("input textarea required");document.getElementById('ApptTime').style.display="none";document.getElementById('Track1').style.display="block";}else{$("div#notesdiv").addClass("input textarea required");}document.getElementById('ApptTime').style.display="none";document.getElementById('AppointmentTime').value=' ';}}function hideBlocks(divid,id2){$(document).ready(function(){$('#'+id2).hide();$('#'+divid).slideToggle("slow");return false;});}</script>