<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#Expiration').datepicker({changeMonth: true,changeYear: true,yearRange: '2010:2022'});});$(function(){$('#Enddate').datepicker({changeMonth: true,changeYear: true,yearRange: '2010:2022'});});</script>	
<?php $html->addCrumb(ucfirst($this->params['type']), array('controller'=>'users','type'=>$this->params['type'],'action'=>'index'));?>
<?php $html->addCrumb("Add new ".Inflector::singularize($this->params['type']), array());?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
	<div class="header"><h1 class="fleft"><?php __('Add new '.Inflector::singularize($this->params['type']));?></h1>
		<ul>
	      	<li><?php echo $html->link(__('Back to '.$this->params['type'].' List', true), array('controller'=>'users','action'=>'index','type'=>$this->params['type'])); ?></li>
       </ul>
   	</div>
	<div class="block_content"><?php __($form->create('User', array('url'=>array('action'=>'add','type'=>$this->params['type']),'id'=>'signupFrm'))); ?><div>
		<p>
			<table class="formtable">
	<?php
	if($this->params['type'] == 'clients') {	
	?>
		<input type="hidden" name="adm_falg" value="1" id="adm_falg" >
		<input type="hidden" name="p_falg" value="1" id="p_falg" >
		<input type="hidden" name="cp_falg" value="0" id="cp_falg" >
		<input type="hidden" name="c_falg" value="1" id="c_falg" >
				<tr><th>Account Details</th></tr>
				<tr><th colspan="4"><hr /></th></tr>
				<tr>
					<td width="25%"><label>Company<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('Client.company', array('id'=>'Company', 'error'=>false,'label'=>false, 'class'=>'text')));?></td>
					<td width="25%"><label>Division</label></td>
					<td width="25%"><?php __($form->input('Client.division', array('id'=>'Division', 'error'=>false,'label'=>false, 'class'=>'text')));?></td>
				</tr>
				<tr>
					<td><label>First name<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.first_name', array('id'=>'FirstName','label'=>false, 'error'=>false, 'class'=>'text')));?></td>
					<td><label>Last name<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.last_name', array('id'=>'LastName','label'=>false, 'error'=>false, 'class'=>'text')));?></td>
				</tr>
				<tr>
					<td><label>Email address<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.email', array('id'=>'EmailAddress','label'=>false,'error'=>false, 'class'=>'text')));?></td>
		<?php if($admindata['Admin']['type']!='E') { ?>
					<td><label>Signing fees (<?php __(Configure::read('currency')); ?>)<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.fees', array('id'=>'Fees', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
		<?php } ?>
				</tr>
				<tr>
					<td><label>Company phone<span class="mandatory">*</span></label></td>
					<td>
						<?php __($form->input('Client.company_phone1', array('maxlength'=>'3', 'id'=>'CompanyPhone1','label'=>false,'error'=>false,'class'=>'text tiny fleft')));?>
						<?php __($form->input('Client.company_phone2', array('maxlength'=>'3', 'id'=>'CompanyPhone2','label'=>false,'error'=>false,'class'=>'text tiny fleft')));?>
						<?php __($form->input('Client.company_phone3', array('maxlength'=>'4', 'id'=>'CompanyPhone3','label'=>false,'error'=>false,'class'=>'text tiny')));?>
					</td>
					<td><label>Company fax</label></td>
					<td>
						<?php __($form->input('Client.company_fax1', array('maxlength'=>'3','id'=>'CompanyFax1', 'error'=>false,'label'=>false, 'class'=>'text tiny fleft')));?>
						<?php __($form->input('Client.company_fax2', array('maxlength'=>'3','id'=>'CompanyFax2', 'error'=>false,'label'=>false, 'class'=>'text tiny fleft')));?>
						<?php __($form->input('Client.company_fax3', array('maxlength'=>'4','id'=>'CompanyFax3', 'error'=>false,'label'=>false, 'class'=>'text tiny')));?>
					</td>
				</tr>
				<tr>
					<td><label>How did you hear about us?</label></td>
					<td><?php echo $form->input('Client.how_hear', array('class'=>'select_box','error'=>false,'id'=>'how_did_u_hear', 'onchange'=>'showtxtb()','label'=>false,'div'=>false,'options'=>$hearoptions));?></td>
					<td colspan="2"><div style="display: <?=($this->data['Client']['how_hear']=="R") ? 'block':'none';?>;" id="ref"><div class="form_block" id="divrow" style="margin-left:3px;"><p class="fleft" style="width:50%;"><label>Referred by</label></p><div class="fleft" style="width:50%;"><?php echo $form->input('Client.how_hear_ref',array('id'=>'how_hear_ref', 'error'=>false,'label'=>false,'class'=>'text')); ?></div></div></div></td>
				</tr>
				<tr>
					<td><label>Shipping carrier</label></td>
					<td><?php  echo $form->input('Client.shipping_carrier',array('id'=>'Shipping_Carrier', 'error'=>false,'label'=>false,'class'=>'select_box','options'=>$clientscdata, 'onchange'=>'showtxtother()','empty'=>'Select')); ?></td>
					<td colspan="2"><div style="display: <?=($this->data['Client']['shipping_carrier']=="O") ? 'block':'none';?>;" id="other"><div class="form_block" id="divrow" style="margin-left:3px;"><p class="fleft" style="width:50%;"><label>Shipping carrier(Other)</label></p><div class="fleft" style="width:50%;"><?php echo $form->input('Client.shipping_carrier_other',array('id'=>'how_hear_ref', 'error'=>false,'div'=>false,'label'=>false,'class'=>'text','maxlength'=>20)); ?></div></div></div></td>
				</tr>
				<tr>
					<td width="25%"><label>Shipping account #</label></td>
					<td><?php __($form->input('Client.shipping_account', array('id'=>'Shipping_Account','div'=>false, 'error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
				<tr>
<?php if(isset($this->data['User']['astatus']) == '2') { ?>
					<td><label>Approve</label></td>
					<td><?php echo $form->input('astatus', array('class'=>'select_box','label'=>false,'error'=>false,'div'=>false,'options'=>$statusoptns));?></td>
<?php } else { ?>
					<td width="25%"><label>Status</label></td>
					<td width="25%"><?php echo $form->input('status', array('class'=>'select_box','label'=>false,'error'=>false,'div'=>false,'options'=>$statusoptions));?></td>
<?php } ?>
				</tr>
			</table>
			<table class="formtable">
				<tr><th>Office Address</th></tr>
				<tr><th colspan="4"><hr /></th></tr>			
				<tr>
					<td width="25%"><label>Street address<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('Client.of_street_address', array('id'=>'OfficeAddress', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
					<td width="25%"><label>City<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('Client.of_city', array('id'=>'OfficeCity', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
				<tr>
					<td><label>State<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.of_state', array('id'=>'OfficeState', 'error'=>false,'label'=>false,'class'=>'select_box','options'=>$states, 'empty'=>'--Select--')));?></td>
					<td><label>Zip code<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.of_zip', array('id'=>'OfficeZipcode', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="3"><p><input type="checkbox" value="1" id="terms" onchange='showval()' name="data[User][terms]">Click if return document address is the same as office address</p></td>
				</tr>
				<tr><th>Return Document Address</th></tr>
				<tr><th colspan="4"><hr /></th></tr>
				<tr>
					<td ><label>Street address<span class="mandatory">*</span></label></td>
					<td ><?php __($form->input('Client.rd_street_address', array('id'=>'ReturnAddress', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
				
					<td><label>City<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.rd_city', array('id'=>'ReturnCity', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
				<tr  >
					<td><label>State<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.rd_state', array('id'=>'ReturnState', 'error'=>false,'label'=>false,'options'=>$states,'class'=>'select_box', 'empty'=>'--Select--')));?></td>
				
					<td><label>Zip code<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.rd_zip', array('id'=>'ReturnZipcode', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
			</table>
			<table>
				<tr><th><?php __($html->tag('h4', 'Client Requirements'));?></th></tr>
				<tr><th colspan="4"><hr /></th></tr>
				<tr>
					<td width="25%">
						<div id="upload_container">
							<div class="form_block" id="divrow1">
								<p class="fleft" style="margin-right:5px;margin-bottom:2px;width:25%;"><label>Client requirement 1<span class="mandatory">*</span></label></p>
								<textarea rows="4" style="width:71%" id="Creq1" class="text" name="data[ClientRequirements][requirements][]"></textarea>
							</div>	
						</div>
						<div style="display:block;" id="fileid" class="addtracks">
							<p><a href="javascript:void(0)" onclick="javascript:add_rows();" id='addMore' class="fright">Add another requirement</a></p>
							<input type="hidden" id="upload_count" name="upload_count" value="<?php echo $cnt_total;?>"/>
						</div>
					</td>
				</tr>
			</table>
		</p>
	</div>
	<?php 
	}
	if($this->params['type'] == 'notaries') {	
	?>
	<div>
		<p>
		<input type="hidden" name="adm_falg" value="1" id="adm_falg" >
		<input type="hidden" name="p_falg" value="1" id="p_falg" >
		<input type="hidden" name="cp_falg" value="0" id="cp_falg" >
	<?php
	$ctype = 'notaries';
	$utype = 'N';
	?>
	<table  class="formtable">
		<tr>
			<th colspan="4">Personal Details</th>
			<tr><th colspan="4"><hr /></th></tr>
		</tr>
		<tr>
			<td width="25%"><label>First name<span class="mandatory">*</span></label></td>
			<td width="25%"><?php __($form->input('Notary.first_name', array('id'=>'FirstName', 'error'=>false,'label'=>false, 'class'=>'text')));?></td>
			<td width="25%"><label>Last name<span class="mandatory">*</span></label></td>
			<td width="25%"><?php __($form->input('Notary.last_name', array('id'=>'LastName', 'error'=>false,'label'=>false, 'class'=>'text')));?></td>
		</tr>
		<tr>
			<td><label>Email address<span class="mandatory">*</span></label></td>
			<td><?php echo $form->input('Notary.email', array('id'=>'EmailAddress', 'error'=>false,'label'=>false, 'class'=>'text'));?></td>
			<td><label>Twitter account</label></td>
			<td><?php __($form->input('Notary.twitter', array('id'=>'Twitter', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
		</tr>
		<tr>
			<td><label>Cell phone<span class="mandatory">*</span></label></td>
			<td>
				<?php echo $form->input('Notary.cell_phone1', array('maxlength'=>'3','id'=>'CellPhone1','label'=>false,'error'=>false,'class'=>'text tiny fleft'));?>
				<?php echo $form->input('Notary.cell_phone2', array('maxlength'=>'3','id'=>'CellPhone2','label'=>false,'error'=>false,'class'=>'text tiny fleft'));?>
				<?php echo $form->input('Notary.cell_phone3', array('maxlength'=>'4','id'=>'CellPhone3','label'=>false,'error'=>false,'class'=>'text tiny fleft'));?>
			</td>
			<td><label>Day phone</label></td>
			<td>
				<?php echo $form->input('Notary.day_phone1', array('maxlength'=>'3','id'=>'DayPhone1','label'=>false,'error'=>false,'class'=>'text tiny fleft'));?>
				<?php echo $form->input('Notary.day_phone2', array('maxlength'=>'3','id'=>'DayPhone2','label'=>false,'error'=>false,'class'=>'text tiny fleft'));?>
				<?php echo $form->input('Notary.day_phone3', array('maxlength'=>'4','id'=>'DayPhone3','label'=>false,'error'=>false,'class'=>'text tiny fleft'));?>
			</td>
		</tr>
		<tr>
			<td><label>Evening phone</label></td>
			<td>
				<?php echo $form->input('Notary.evening_phone1', array('maxlength'=>'3','id'=>'EveningPhone1','label'=>false,'error'=>false,'class'=>'text tiny fleft'));?>
				<?php echo $form->input('Notary.evening_phone2', array('maxlength'=>'3','id'=>'EveningPhone2','label'=>false,'error'=>false,'class'=>'text tiny fleft'));?>
				<?php echo $form->input('Notary.evening_phone3', array('maxlength'=>'4','id'=>'EveningPhone3','label'=>false,'error'=>false,'class'=>'text tiny fleft'));?>
			</td>
			<td><label>Fax</label></td>
			<td>
				<?php echo $form->input('Notary.fax1', array('maxlength'=>'3','id'=>'Fax1', 'error'=>false,'label'=>false,'class'=>'text tiny fleft'));?>
				<?php echo $form->input('Notary.fax2', array('maxlength'=>'3','id'=>'Fax2', 'error'=>false,'label'=>false,'class'=>'text tiny fleft'));?>
				<?php echo $form->input('Notary.fax3', array('maxlength'=>'4','id'=>'Fax3', 'error'=>false,'label'=>false,'class'=>'text tiny fleft'));?>
			</td>
		</tr>
		<tr>
			<td><label>Languages</label></td>
			<td><?php echo $form->input('Notary.languages',array('id'=>'Languages', 'error'=>false,'label'=>false,'class'=>'select_box nobg','options'=>$langoptions,'multiple'=>'true', 'size'=>'5','empty'=>'N/A')); ?><span class="mandatory">[ To select multiple languages: push the CTRL button when clicking additional languages ]</span></td>
			<td><label>Notes</label></td>
			<td><?php echo $form->input('Notary.notes',array('id'=>'Notes', 'error'=>false,'label'=>false,'div'=>false,'class'=>'text', 'style'=>'width:90%','rows'=>'3')); ?></td>
		</tr>
		<tr>
			<td><label>How did you hear about us?</label></td>
			<td><?php echo $form->input('Notary.how_hear', array('class'=>'select_box','error'=>false,'id'=>'how_did_u_hear', 'onchange'=>'showtxtb()','label'=>false,'div'=>false,'options'=>$hearoptions));?></td>
			<td colspan="2"><div style="display: <?=($this->data['Notary']['how_hear']=="R") ? 'block':'none';?>;" id="ref"><div class="form_block" id="divrow" style="margin-left:3px;"><p class="fleft" style="width:50%;"><label>Referred by</label></p><div class="fleft" style="width:50%;"><?php echo $form->input('Notary.how_hear_ref',array('id'=>'how_hear_ref', 'error'=>false,'label'=>false,'class'=>'text')); ?></div></div></div></td>
		</tr>
		<tr>
		<?php
		if($this->data['User']['status']=='2') {
		?>
			<td><label>Approve</label></td>
			<td><?php echo $form->input('astatus', array('class'=>'select_box','label'=>false,'error'=>false,'div'=>false,'options'=>$statusoptns));?></td>
		<?php
		} else {
		?>
			<td width="25%"><label>Status</label></td>
			<td width="25%"><?php echo $form->input('status', array('class'=>'select_box','label'=>false,'error'=>false,'div'=>false,'options'=>$statusoptions));?></td>
		<?php
		}
		?>
		</tr>
		<tr><th colspan="4">Document Delivery Address</th></tr>
		<tr><th colspan="4"><hr /></th></tr>
		<tr>
			<td><label>Street address<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.dd_address', array('id'=>'DocumentAddress', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
			<td><label>City<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.dd_city', array('id'=>'DocumentCity', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
		</tr>
		<tr>
			<td><label>State<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.dd_state', array('id'=>'DocumentState', 'error'=>false,'label'=>false,'class'=>'select_box','options'=>$states, 'empty'=>'--Select--')));?></td>
			<td><label>Zip code<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.dd_zip', array('id'=>'DocumentZipcode', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="3"><p><input type="checkbox" value="1" id="terms" onchange='showvals()' name="data[User][terms]">Click if payment aAddress is the same as document delivery address</p></td>
		</tr>
		<tr><th>Payment Address</th></tr>
		<tr><th colspan="4"><hr /></th></tr>
		<tr>
			<td><label>Street address<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.p_address', array('id'=>'PaymentAddress', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
			<td><label>City<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.p_city', array('id'=>'PaymentCity', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
		</tr>
		<tr>
			<td><label>State<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.p_state', array('id'=>'PaymentState', 'error'=>false,'label'=>false,'class'=>'select_box','options'=>$states, 'empty'=>'--Select--')));?></td>
			<td><label>Zip code<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.p_zip', array('id'=>'PaymentZipcode', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
		</tr>
		<tr><th>Professional Details</th></tr>
		<tr><th colspan="4"><hr /></th></tr>
		<tr>
			<td><label>Type</label></td>
			<td><?php echo $form->input('Notary.userstatus', array('class'=>'select_box','id'=>'notarytype','label'=>false,'error'=>false,'div'=>false,'options'=>$notaryoptions, 'onchange'=>'showtype()'));?></td>
			<td><label>Commission<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.commission', array('id'=>'Commission','label'=>false,'error'=>false,'class'=>'text')));?></td>
		</tr>
	</table>
	<div <?=(@$this->data['Notary']['userstatus']=='P') ? 'style="display:display;"' : 'style="display:none;"'?> id="paytype">
		<div class="form_block" id="divrow1" style="margin-left:4px;">
			<div class="fleft" style="width:50%;">
				<p class="fleft" style="width:50%;"><label>Payment option<span class="mandatory">*</span></label></p><?php echo $form->input('Notary.payment', array('class'=>'select_box','error'=>false,'label'=>false,'style'=>'width:46%;','div'=>false,'options'=>$payoptions));?>
			</div>
			<div class="fleft" style="width:50%;">
				<p class="fleft" style="width:50%;"><label>Paid<span class="mandatory">*</span></label></p><?php echo $form->input('Notary.paid', array('class'=>'select_box','error'=>false,'label'=>false,'div'=>false,'style'=>'width:46%;','options'=>$paidoptions));?>
			</div>
			<div class="fleft" style="width:50%;">
				<p class="fleft" style="width:50%;"><label>Account end date<span class="mandatory">*</span></label></p><?php echo $form->input('Notary.enddate',array('id'=>'Enddate','label'=>false,'class'=>'text','style'=>'width:44%;','type'=>'text','readonly'=>true,'value'=> $counter->formatdate('nsdate',$this->data['Notary']['enddate'])));?>
			</div>
		</div>
	</div>
	<table class="formtable">
		<tr>
			<td width="25%"><label>What year did you receive your notary license?</label></td>
			<td width="25%"><?php __($form->input('Notary.year', array('id'=>'Year', 'error'=>false,'label'=>false,'class'=>'text')));?></td>
			<td width="25%"><label>Expiration<span class="mandatory">*</span></label></td>
			<td width="25%"><?php echo $form->input('Notary.expiration',array('id'=>'Expiration','label'=>false,'class'=>'text','type'=>'text','readonly'=>true, 'value'=>$counter->formatdate('nsdate', $this->data['Notary']['expiration']))); ?>
			</td>
		</tr>
		<tr>
			<td><label>Fees (<?php __(Configure::read('currency')); ?>)<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.fees', array('id'=>'Fees', 'error'=>false,'label'=>false, 'class'=>'text')));?></td>
			<td><label>Notify via</label></td>
			<td>
			<?php echo $form->input('Notary.notify', array('class'=>'select_box','id'=>'Notify', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$notifyoptions,'empty'=>'--Select--')); ?>
			</td>
		</tr>
		<tr>
			<td><label>Laser printer</label></td>
			<td><?php echo $form->input('Notary.print', array('class'=>'select_box','error'=>false,'label'=>false,'div'=>false,'options'=>$ynoptions, 'empty'=>'--Select--'));?></td>
			<td><label>E-signing</label></td>
			<td><?php echo $form->input('Notary.esigning', array('class'=>'select_box','error'=>false,'label'=>false,'div'=>false,'options'=>$ynoptions, 'empty'=>'--Select--'));?></td>
		</tr>
		<tr>
			<td><label>Wireless card</label></td>
			<td><?php echo $form->input('Notary.wireless_card', array('class'=>'select_box','error'=>false,'label'=>false,'div'=>false,'options'=>$ynoptions, 'empty'=>'--Select--'));?></td>
			<td><label>Attorney/work with attorney?</label></td>
			<td><?php echo $form->input('Notary.work_with', array('class'=>'select_box','error'=>false,'label'=>false,'div'=>false,'options'=>$ynoptions, 'empty'=>'--Select--'));?></td>
		</tr>
		
	</table>
	</p>
</div>
<div style="display: none;" id="ref">
	<div class="form_block" id="divrow"><p class="fleft" style="width:25%;"><label>Referred by</label></p><div class="fleft" style="width:25%;"><?php echo $form->input('Notary.how_hear_ref',array('id'=>'how_hear_ref', 'error'=>false,'label'=>false,'class'=>'text')); ?></div></div>
</div>
<div>
	<p>
		<div id="upload_container_zip">
			<div class="form_block required" id="divrowzip1" style="margin-bottom:3px;padding:5px;"><p class="fleft" style="width:25%;"><label>Zip code covered 1<span class="mandatory">*</span></label></p><div class="fleft" style="width:25%;"><input type="text" maxlength="50" class="text" id="Zipcode1" name="data[Notary][zipcode][]"></div></div>	
		</div>
		<div style="display:block;" id="fileid" class="addtracks"><p><a href="javascript:void(0)" onclick="javascript:add_rows_zip();" id='addMore' class="fright">Add another zip code covered</a></p><input type="hidden" id="upload_count_zip" name="upload_count_zip" value="<?php echo $cnt_total;?>"/></div>	
	</p>
</div>
<?php
	}
?>
<div>
	<p>
		<table class="formtable">
			<tr>
				<th colspan="4"><?php echo $html->tag('h4', 'Login Information');?></th>
			</tr>
			<tr><th colspan="4"><hr /></th></tr>
			<tr>
				<td width="25%"><label>Username<span class="mandatory">*</span></label></td>
				<td width="25%"><?php echo $form->input('username', array('id'=>'Username','error'=>false,'label'=>false, 'class'=>'text'));?></td>
				<td width="25%"><label>Password<span class="mandatory">*</span></label></td>
				<td width="25%"><?php echo $form->input('confirmpassword',array('id'=>'Password','type'=>'password','error'=>false,'label'=>false,'class'=>'text','maxlength'=>'25','div'=>false, 'value'=>@$this->data['User']['confirmpassword']));?></td>
			</tr>
			<tr>
				<td colspan="4"><hr />
				<?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
				<?php __($html->link('Cancel',array('controller'=>'users','type'=>$this->params['type'],'action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft'))); ?>
				</td>
			</tr>
			<input type="hidden" name="a_falg" value="1" id="a_falg" >
		</table>
	</p>
</div>
<?php echo $form->end();?>
</div>
</div>
</div>
<script>$("#CompanyPhone").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#CompanyPhone").val();test = test.replace('-','').replace('-','');$("#CompanyPhone").val(test);}});$("#CompanyFax").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#CompanyFax").val();test = test.replace('-','').replace('-','');$("#CompanyFax").val(test);}});$("#DayPhone").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#DayPhone").val();test = test.replace('-','').replace('-','');$("#DayPhone").val(test);}});$("#EveningPhone").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#EveningPhone").val();test = test.replace('-','').replace('-','');$("#EveningPhone").val(test);}});$("#CellPhone").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#CellPhone").val();test = test.replace('-','').replace('-','');$("#CellPhone").val(test);}});$("#Fax").keydown(function(e){var keycode =  e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#Fax").val();test = test.replace('-','').replace('-','');$("#Fax").val(test);}});function showval() {document.getElementById('ReturnAddress').value = document.getElementById("OfficeAddress").value;document.getElementById('ReturnCity').value = document.getElementById("OfficeCity").value;document.getElementById('ReturnState').value = document.getElementById("OfficeState").value;document.getElementById('ReturnZipcode').value = document.getElementById("OfficeZipcode").value;}function showvals() {document.getElementById('PaymentAddress').value=document.getElementById('DocumentAddress').value;document.getElementById('PaymentState').value = document.getElementById('DocumentState').value;document.getElementById('PaymentCity').value = document.getElementById('DocumentCity').value;document.getElementById('PaymentZipcode').value = document.getElementById('DocumentZipcode').value;}function showtxtb(){if(document.getElementById('how_did_u_hear').value =='R'){document.getElementById('ref').style.display="block";}else{document.getElementById('ref').style.display="none";}}function showtxtother(){if(document.getElementById('Shipping_Carrier').value =='O'){document.getElementById('other').style.display="block";}else{document.getElementById('other').style.display="none";}}$('#EmailAddress').focusout(function() {var un= $('#EmailAddress').val();$("#Username").val(un);});$('#LastName').focusout(function() {var ln= $('#LastName').val();$("#Password").val(ln);});function showtype(){if(document.getElementById('notarytype').value =='P'){document.getElementById('paytype').style.display="block";}else{document.getElementById('paytype').style.display="none";}}</script>