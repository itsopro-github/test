<?php 
	echo $html->css(array('ui.all'));
 	echo $html->css(array('ui.core'));
	echo $html->css(array('jquery-ui-1.7.2.custom'));
	e($javascript->link('jquery-ui-1.7.2.custom.min'));
	e($javascript->link('timepicker'));
?>
<script type="text/javascript">$(function(){$('#AppointmentTime').timepicker({ampm:true});});$(document).ready(function(){if($('#OrderStatus').val()==4){$('#ApptTime').css('display','block');}});</script>
 <div class="mainBox subBoxborder" style="width:98%;">
	<div class="header"><h3>Update Order</h3></div>
	<div class="content">
		<?php __($form->create('Signinghistory',array('id'=>'odrstatus','url'=>array('controller'=>'signinghistories','action'=>'add')))); 
		 __($form->input('Signinghistory.order_id',array('type'=>'hidden','value'=>$order['Order']['id'])));
?>
		<table border="0" cellspacing="0" cellpadding="0">
<?php
			if(in_array($order['Orderstatus']['id'], array('2','3','4','5'))) { 
				if(($order['Order']['attended_by']=='0')){
					__($this->element('nobox', array('displaytext'=>'Please accept the order to update status.')));
				} elseif(($order['Order']['attended_by']!='0') and ($admindata['Admin']['id']!=$order['Order']['attended_by'])) {
					__($form->hidden('Signinghistory.orderstatus_id',array('value'=>$order['Order']['orderstatus_id'])));
					__($this->element('nobox', array('displaytext'=>'You do not have permission to update order.')));
				} elseif($admindata['Admin']['id'] == $order['Order']['attended_by']) {
?>
				<tr>
					<td width="25%"><label class="form_label">Status<span class="mandatory">*</span></label></td>
					<td><div class="input select required"><?php __($form->input('Signinghistory.orderstatus_id',array('error'=>false,'label'=>false,'div'=>false,'id'=>'OrderStatus','onchange'=>'showAppttime()','options'=>$Orderstatus,'selected'=>$order['Order']['orderstatus_id'], 'class'=>'select_box fleft', 'empty'=>'Select Status'))); ?></div></td>
				</tr>
				<tr>
					<td style="border:0px !important; padding: 0px 2px;" colspan="2">
						<div id="ApptTime" style="display:none;">
							<table border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25%"><label class="form_label">Appointment time<span class="mandatory">*</span></label></td>
<?php
									$start = strtotime('12:00am');
									$end = strtotime('11:30pm');
									$crntapttime = (isset($crntapttime)=='') ? '8:00 am' : $crntapttime;
									echo '<td><select name="data[Signinghistory][appointment_time]" id="AppointmentTime" class="select_box">';
									for ($i = $start; $i <= $end; $i += 1800) {
										if(date('g:i a', $i) != $crntapttime) {
											echo '<option value="'.date('g:i a', $i).'">'.date('g:i a', $i).'</option>';
										} else {
											echo '<option value="'.date('g:i a', $i).'" selected="selected">'.$crntapttime.'</option>';
										}
									}
									echo '</select></td>';
?>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="border:0px !important; padding: 0px 2px;">
						<div id="Track1" style="display:none">
							<table border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25%"><label class="form_label">Shipping info</label></td>
									<td width="25%"><?php echo $form->input('track_shipping_info', array('class'=>'select_box', 'error'=>false,'id'=>'ShippingInfo', 'label'=>false, 'div'=>false, 'options'=>$shipoptions)); ?></td>
									<td width="25%"><label class="form_label">Tracking #</label></td>
									<td width="25%"><div  class="input text"><?php __($form->input('tracking_no',array('error'=>false,'label'=>false,'id'=>'Tracking','class'=>'text required'))); ?></div></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
<?php 
				}
			} else {
				if(in_array($order['Orderstatus']['id'], array('6','8','9','10'))) { 
?>
				<div class="mandatory">[ To see notary details or change notary, select the NOTARY DETAILS tab above. To ADD NOTES to file, enter in Notes field below and click SUBMIT ]</div>
<?php
					if(in_array($order['Orderstatus']['id'], array('6','9','10')))
					__($html->link('Re-activate', array('controller'=>'signinghistories','action'=>'reactivate',$order['Order']['id']),array('div'=>false,'class'=>'normalbutton_len fright'))); 
				} 
?>
				<input type="hidden"  name="data[Signinghistory][orderstatus_id]" value="<?php echo $order['Order']['orderstatus_id'];?>"/>
<?php
				if($order['Order']['orderstatus_id'] == '7' and $order['Order']['tracking_no'] == '' ) {
?>
					<tr>
						<td colspan="2" style="border:0px !important; padding: 0px 2px;">
							<div>
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="25%"><label class="form_label">Shipping info</label></td>
										<td width="25%"><?php echo $form->input('track_shipping_info', array('class'=>'select_box fleft', 'error'=>false,'id'=>'ShippingInfo', 'label'=>false, 'div'=>false, 'options'=>$shipoptions)); ?></td>
										<td width="25%"><label class="form_label">Tracking #</label></td>
										<td width="25%"><div  class="input text "><?php __($form->input('tracking_no',array('error'=>false,'label'=>false,'id'=>'Tracking','div'=>false,'class'=>'text fleft'))); ?></div></td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
<?php 
				}					
			}
?>
			<tr>
				<td width="25%"><label class="form_label">Notes</label></td>
				<td><div id="notesdiv" class="input textarea"><?php __($form->input('Signinghistory.notes',array('style'=>'width:98%','rows'=>'5','error'=>false,'label'=>false,'div'=>false,'id'=>'Notes','class'=>'text_area fleft'))); ?></div></td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="noborder"><?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
				<?php __($html->link('Cancel',array('controller'=>'orders', 'action'=>'view',$order['Order']['id']),array('class'=>'normalbutton fleft'))); ?></td>
			</tr>
		</table>
<?php
		__($form->end());
?>		
	</div>
</div>
<script>function showAppttime(){if(document.getElementById('OrderStatus').value =='4'){document.getElementById('ApptTime').style.display="block";document.getElementById('Track1').style.display="none";$("div#notesdiv").removeClass("input textarea required");}else if(document.getElementById('OrderStatus').value=='2'){document.getElementById('ApptTime').style.display="none";document.getElementById('Track1').style.display="none";document.getElementById('AppointmentTime').value=' ';$("div#notesdiv").removeClass("input textarea required");}else{document.getElementById('Track1').style.display="none";if(document.getElementById('OrderStatus').value=='7'){$("div#notesdiv").removeClass("input textarea required");document.getElementById('ApptTime').style.display="none";document.getElementById('Track1').style.display="block";}else{$("div#notesdiv").addClass("input textarea required");}document.getElementById('ApptTime').style.display="none";document.getElementById('AppointmentTime').value=' ';}}</script>