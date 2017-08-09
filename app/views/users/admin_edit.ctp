<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#Expiration').datepicker({changeMonth: true,changeYear: true,yearRange: '2010:2022'});});$(function(){$('#Enddate').datepicker({changeMonth: true,changeYear: true,yearRange: '2010:2022'});});</script>	
<?php
$html->addCrumb(ucfirst($type), array('controller'=>'users', 'type'=>$type, 'action'=>'index'));
if($usertype == 'clients') { 
	$html->addCrumb($this->data[$model]['company'], array());
} else {
	$html->addCrumb($this->data[$model]['first_name'], array());
}
$ustatus = isset($this->data['User']['status'])=='' ? $this->data['User']['astatus'] : $this->data['User']['status'];
$style = $ustyle="";
if($ustatus == '2'){
	$style="display:none;";
} else {
	$ustyle="display:none;";
}
?>
<div class="mainBox mainBoxborder curveEdges">
	<div class="block">
		<div class="header">
<?php 
		if($usertype == 'clients') { 
?>
        	<h1 class="fleft"><?php __('Edit '.$model.' ['.$this->data[$model]['company'].']');?></h1>
<?php
		} else { 
?>
         	<h1 class="fleft"><?php __('Edit '.$model.' ['.$this->data[$model]['first_name'].']');?></h1>
<?php 	
		}
?>
			<ul>
		      	<li><?php __($html->link(__('Back to '.$usertype.' list', true), array('controller'=>'users','action'=>'index','type'=>$usertype))); ?></li>
		      	<li><?php __($html->link(__('Delete this '.Inflector::singularize($usertype), true), array('controller'=>'users','action'=>'delete','type'=>$usertype,'id'=>$this->data['User']['id']),array('title'=>'Delete', 'alt'=>'Delete'),sprintf('Are you sure you want to delete \''.$this->data[$model]['first_name'].'\'?'))); ?></li>
	       </ul>
       	</div>
		<div class="block_content">
<?php
	if(isset($id) && $id<>""){
		__($form->create('User',array('action'=>$type.'/edit/'.$id,'id'=>'signupFrm')));
	} else {
		__($form->create('User',array('action'=>$type.'/edit/','id'=>'signupFrm')));
	}
	__($form->hidden('userid',array('name'=>'data[User][id]','value'=>$this->data['User']['id'])));
?>	
		<div>
			<p>
			<table class="formtable">
<?php
			if($type == 'clients') {
?>
		<input type="hidden" name="adm_falg" value="1" id="adm_falg">
		<input type="hidden" name="p_falg" value="1" id="p_falg">
		<input type="hidden" name="cp_falg" value="0" id="cp_falg">
		<input type="hidden" name="c_falg" value="1" id="c_falg">
		<input type="hidden" name="pswd_falg" value="0" id="pswd_falg">
		<input type="hidden" name="a_falg" value="1" id="adm_falg">
		<?php
		// clients
		$ctype = 'clients';
		$utype = 'C';
?>
				<tr><th>Account Details</th></tr>
				<tr><th colspan="4"><hr /></th></tr>
				</tr>	
					<tr>
					<td width="25%"><label>Company<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('Client.company', array('id'=>'Company','error'=>false,'label'=>false, 'class'=>'text')));?></td>
					<td width="25%"><label>Division</label></td>
					<td width="25%"><?php __($form->input('Client.division', array('id'=>'Division','error'=>false,'label'=>false, 'class'=>'text')));?></td>
				</tr>
				<tr>
					<td width="20%"><label>First name<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.first_name', array('id'=>'FirstName','error'=>false,'label'=>false, 'class'=>'text')));?></td>
					<td width="20%"><label>Last name<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.last_name', array('id'=>'LastName','error'=>false,'label'=>false, 'class'=>'text')));?></td>
				</tr>
				<tr>
					<td><label>Email address<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.email', array('id'=>'EmailAddress','label'=>false, 'class'=>'text')));?></td>
<?php if($admindata['Admin']['type']!='E'){?>
					<td><label>Signing fees (<?php __(Configure::read('currency')); ?>)<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.fees', array('id'=>'Fees','error'=>false,'label'=>false,'class'=>'text')));?></td>
<?php }?>
				</tr>
				<tr>
					<td><label>Company phone<span class="mandatory">*</span></label></td>
					<td>
						<?php __($form->input('Client.company_phone1', array('maxlength'=>'3','id'=>'CompanyPhone1','error'=>false,'label'=>false,'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Client']['company_phone'], 0, 3))));?>
						<?php __($form->input('Client.company_phone2', array('maxlength'=>'3','id'=>'CompanyPhone2','error'=>false,'label'=>false,'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Client']['company_phone'], 3, 3))));?>
						<?php __($form->input('Client.company_phone3', array('maxlength'=>'4','id'=>'CompanyPhone3','error'=>false,'label'=>false,'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Client']['company_phone'], 6, 4))));?>
					</td>
					<td><label>Company fax</label></td>
					<td>
						<?php __($form->input('Client.company_fax1', array('maxlength'=>'3','id'=>'CompanyFax1','error'=>false,'label'=>false,'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Client']['company_fax'], 0, 3))));?>
						<?php __($form->input('Client.company_fax2', array('maxlength'=>'3','id'=>'CompanyFax2','error'=>false,'label'=>false,'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Client']['company_fax'], 3, 3))));?>
						<?php __($form->input('Client.company_fax3', array('maxlength'=>'4','id'=>'CompanyFax3','error'=>false,'label'=>false,'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Client']['company_fax'], 6, 4))));?>
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
					<td><?php __($form->input('Client.shipping_account', array('id'=>'Shipping_Account','error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
				<tr>
<?php if($ustatus=='2') { ?>
					<td width="25%"><label>Approve</label></td>
					<td><?php echo $form->input('astatus', array('class'=>'select_box','error'=>false,'label'=>false,'error'=>false,'div'=>false,'options'=>$statusoptns));?></td>
<?php } else { ?>
					<td width="25%"><label>Status</label></td>
					<td><?php echo $form->input('status', array('class'=>'select_box','label'=>false,'error'=>false,'div'=>false,'options'=>$statusoptions));?></td>
<?php } ?>
				</tr>
			</table>
		</p>
	</div>
	<div>
		<p>
			<table>
				<tr><th>Office Address</th></tr>
				<tr><th colspan="4"><hr /></th></tr>
				<tr>
					<td width="25%"><label>Street address<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('Client.of_street_address', array('id'=>'OfficeAddress','error'=>false,'label'=>false,'class'=>'text')));?></td>
					<td width="25%"><label>City<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('Client.of_city', array('id'=>'OfficeCity','error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
				<tr>
					<td><label>State<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.of_state', array('id'=>'OfficeState','error'=>false,'label'=>false,'options'=>$states,'class'=>'select_box', 'empty'=>'--Select--')));?></td>
					<td><label>Zip code<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.of_zip', array('id'=>'OfficeZipcode','error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
				<tr>
					<td></td>
					<td class="noborder" colspan="3"><p><input type="checkbox" value="1" id="terms" onchange='showval()' name="data[User][terms]">Click if return document address is the same as office address</p></td>
				</tr>
				<tr><th>Return Document Address</th></tr>
				<tr><th colspan="4"><hr /></th></tr>
				<tr>
					<td width="25%"><label>Street address<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('Client.rd_street_address', array('id'=>'ReturnAddress','error'=>false,'label'=>false,'class'=>'text')));?></td>
				
					<td width="25%"><label>City<span class="mandatory">*</span></label></td>
					<td width="25%"><?php __($form->input('Client.rd_city', array('id'=>'ReturnCity','error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
				<tr >
					<td><label>State<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.rd_state', array('id'=>'ReturnState','error'=>false,'label'=>false,'options'=>$states,'class'=>'select_box','empty'=>'--Select--')));?></td>
				
					<td><label>Zip code<span class="mandatory">*</span></label></td>
					<td><?php __($form->input('Client.rd_zip', array('id'=>'ReturnZipcode','error'=>false,'label'=>false,'class'=>'text')));?></td>
				</tr>
			</table>
		</p>
	</div>
	<div>
		<p>
			<div id="upload_container">
<?php 
	$totalcr = (count($creqs) ==0) ? 1 : count($creqs);
	if(!empty($creqs)){
		foreach ($creqs as $key=>$creq):
?>
			<div class="form_block" id="divrow1" style="margin-bottom:3px;"><p class="fleft" style="margin-right:5px;margin-bottom:2px;width:25%;"><label><?php __('Client requirement '.++$key);?><span class="mandatory">*</span></label></p>	
			<textarea rows="4" style="width:71%" id="Creq1" class="text" name="data[ClientRequirements][requirements][]"><?php echo $creq['ClientRequirements']['requirements'];?></textarea>
			<div  class="float_div7 fright"><p><?php __($html->link('', array('controller'=>'client_requirements', 'action'=>'delete', $creq['ClientRequirements']['id'], $this->data['Client']['id']), array('class'=>'delete_btn', 'title'=>'Remove'))); ?></p></div>
			</div>	
<?php
		endforeach;
	} else {
?>
			<div class="form_block" id="divrow1">
				<p class="fleft" style="margin-right:5px;margin-bottom:2px;width:25%;"><label>Client requirement 1<span class="mandatory">*</span></label></p>
				<textarea rows="4" style="width:71%" id="Creq1" class="text" name="data[ClientRequirements][requirements][]"></textarea>
			</div>
<?php } ?>
	</div>
	<div style="display:block;" id="fileid" class="addtracks"><p><a href="javascript:void(0)" onclick="javascript:add_rows();" id='addMore' class="fright">Add another requirement</a></p>
		<input type="hidden" id="upload_count" name="upload_count" value="<?php echo ($totalcr);?>"/>
	</div>
	<p><?php __($form->hidden('Clientid',array('name'=>'data[Client][id]','value'=>$this->data['Client']['id'])));?></p>
	</p>
</div>
		
<?php
			}
			if($type == 'notaries') {
?><div><p>
		<input type="hidden" name="adm_falg" value="1" id="adm_falg">
		<input type="hidden" name="p_falg" value="1" id="p_falg">
		<input type="hidden" name="cp_falg" value="0" id="cp_falg">
		<input type="hidden" name="pswd_falg" value="0" id="pswd_falg">
<?php
		$ctype = 'notaries';
		$utype = 'N';
?><table  class="formtable">
		<tr><th>Personal Details</th></tr>
		<tr><th colspan="4"><hr /></th></tr>
		<tr>
			<td width="25%"><label>First name<span class="mandatory">*</span></label></td>
			<td width="25%"><?php __($form->input('Notary.first_name', array('id'=>'FirstName','label'=>false, 'class'=>'text')));?></td>
			<td width="25%"><label>Last name<span class="mandatory">*</span></label></td>
			<td width="25%"><?php __($form->input('Notary.last_name', array('id'=>'LastName','label'=>false, 'class'=>'text')));?></td>
		</tr>
		<tr>
			<td><label>Email address<span class="mandatory">*</span></label></td>
			<td><?php echo $form->input('Notary.email', array('id'=>'Email','label'=>false, 'class'=>'text'));?></td>
			<td><label>Twitter account</label></td>
			<td><?php __($form->input('Notary.twitter', array('id'=>'Twitter','label'=>false,'class'=>'text')));?></td>
		</tr>
		<tr>
			<td><label>Mobile Phone	<span class="mandatory">*</span></label></td>
			<td>
				<?php echo $form->input('Notary.cell_phone1', array('maxlength'=>'3','id'=>'CellPhone1','label'=>false,'error'=>false,'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 0,3)));?>
				<?php echo $form->input('Notary.cell_phone2', array('maxlength'=>'3','id'=>'CellPhone2','label'=>false,'error'=>false, 'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 3, 3)));?>
				<?php echo $form->input('Notary.cell_phone3', array('maxlength'=>'4','id'=>'CellPhone3','label'=>false,'error'=>false, 'class'=>'text tiny','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 6, 4)));?>
			</td>
			<td><label>Office Phone</label></td>
			<td>
				<?php echo $form->input('Notary.day_phone1', array('maxlength'=>'3','id'=>'DayPhone1','label'=>false,'error'=>false, 'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 0, 3)));?>
				<?php echo $form->input('Notary.day_phone2', array('maxlength'=>'3','id'=>'DayPhone2','label'=>false,'error'=>false, 'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 3, 3)));?>
				<?php echo $form->input('Notary.day_phone3', array('maxlength'=>'4','id'=>'DayPhone3','label'=>false,'error'=>false, 'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 6, 4)));?>
			</td>
		</tr>
		<tr>
			<td><label>Home Phone</label></td>
			<td>
				<?php echo $form->input('Notary.evening_phone1', array('maxlength'=>'3','id'=>'EveningPhone1','label'=>false,'error'=>false, 'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 0, 3)));?>
				<?php echo $form->input('Notary.evening_phone2', array('maxlength'=>'3','id'=>'EveningPhone2','label'=>false,'error'=>false, 'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 3, 3)));?>
				<?php echo $form->input('Notary.evening_phone3', array('maxlength'=>'4','id'=>'EveningPhone3','label'=>false,'error'=>false, 'class'=>'text tiny fleft','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 6, 4)));?>
			</td>

			<td><label>Website</label></td>
			<td><?php __($form->input('Notary.website', array('id'=>'Website','error'=>false,'label'=>false,'class'=>'text')));?></td>
			
		</tr>
		

		
		
		<tr>
			<td><label>Languages</label></td>
			<td><?php echo $form->input('Notary.languages',array('id'=>'Languages','label'=>false,'class'=>'select_box nobg','options'=>$langoptions,'multiple'=>'true', 'size'=>'5','empty'=>'N/A','selected' => $selectedLang)); ?><span class="mandatory">[ To select multiple languages: push the CTRL button when clicking additional languages ]</span>
			</td>
			
			<td><label>Notes</label></td>
			<td><?php echo $form->input('Notary.notes',array('id'=>'Notes','label'=>false,'div'=>false,'rows'=>'4', 'style'=>'width:90%',)); ?></td>
		</tr>
		
			
		<tr>
			<td><label>Other</label></td>
			<td><?php __($form->input('Notary.languages_other', array('id'=>'languages_other','label'=>false, 'class'=>'text')));?></td>
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
		<tr><th colspan="4">Mailing Address</th></tr>
		<tr><th colspan="4"><hr /></th></tr>
		<tr>
			<td><label>Street address<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.dd_address', array('id'=>'DocumentAddress','label'=>false,'class'=>'text')));?></td>
			<td><label>City<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.dd_city', array('id'=>'DocumentCity','label'=>false,'class'=>'text')));?></td>
		</tr>
		<tr>
			<td><label>State<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.dd_state', array('id'=>'DocumentState','label'=>false,'options'=>$states,'class'=>'select_box', 'empty'=>'--Select--')));?></td>
			<td><label>Zip code<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.dd_zip', array('id'=>'DocumentZipcode','label'=>false,'class'=>'text')));?></td>
		</tr>


		<tr><th>Professional Details</th></tr>
		<tr><th colspan="4"><hr /></th></tr>
		<tr>
			<td><label>Type</label></td>
			<td><?php echo $form->input('Notary.userstatus', array('class'=>'select_box','id'=>'notarytype','label'=>false,'error'=>false,'div'=>false,'options'=>$notaryoptions, 'onchange'=>'showtype()',));?></td>
			<td><label>Commission<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.commission', array('id'=>'Commission','label'=>false,'class'=>'text')));?></td>
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
			<td width="25%"><?php __($form->input('Notary.year_start_notary', array('id'=>'year_start_notary','label'=>false,'class'=>'text')));?></td>
			<td width="25%"><label>Expiration<span class="mandatory">*</span></label></td>
			<td width="25%"><?php echo $form->input('Notary.expiration',array('id'=>'Expiration','label'=>false,'class'=>'text','type'=>'text','readonly'=>true,'value'=> $counter->formatdate('nsdate',$this->data['Notary']['expiration'])));?></td>
		</tr>
			<td><label>Fees (<?php __(Configure::read('currency')); ?>)<span class="mandatory">*</span></label></td>
			<td><?php __($form->input('Notary.fees', array('id'=>'Fees','label'=>false, 'class'=>'text')));?></td>
			<td><label>Notify via</label></td>
			<td><?php echo $form->input('Notary.notify', array('class'=>'select_box','id'=>'Notify', 'error'=>false, 'label'=>false, 'div'=>false, 'options'=>$notifyoptions,'empty'=>'--Select--')); ?></td>
		</tr>
<?php __($form->hidden('Notaryid',array('name'=>'data[Notary][id]','value'=>$this->data['Notary']['id']))); ?>
	
		<tr>
			<td><label>Mistakes</label></td>
			<td><?php for($i=1;$i<=3;$i++){ ?>
			<input type="checkbox" value="1" <?php if($i<=$this->data['Notary']['mistakes']){echo "checked='checked'";}else{echo "";}?>id="mistakes" name="data[Notary][mistakes][]"><?php }?>
			</td>
			
		</tr>
		
		<tr>
			<td><label>What year did you start conducting loan document signings?	</label></td>
			<td><?php __($form->input('Notary.year_start_signings', array('id'=>'year_start_signings','label'=>false, 'class'=>'text')));?></td>
			<td><label>How many loan document signings have you conducted?	</label></td>
			<td><?php __($form->input('Notary.doc_signings_count', array('id'=>'doc_signings_count','label'=>false, 'class'=>'text')));?></td>
		</tr>
		
		
<?php 
$days = split(",",$this->data["Notary"]["days_available"]);	
$times = split(",",$this->data["Notary"]["time_available"]);	
$approved_titles = split(",",$this->data["Notary"]["approved_titles"]);	
$agree_nna = $this->data["Notary"]["agree_nna"];
$claims_against = $this->data["Notary"]["claims_against"];
$experience = split(",",$this->data["Notary"]["experience"]);	

$convicted_misdemeanor = $this->data["Notary"]["convicted_misdemeanor"];

$smartphone_carrier = trim($this->data["Notary"]["smartphone_carrier"]);	
$travel_distance = $this->data["Notary"]["travel_distance"];	
$smartphone_type = $this->data["Notary"]["smartphone_type"];	

?>
<script>

$(document).ready(function() {

    $('.daysChoice input').change(function() {
		var finalValue = "";
		$.each($(".daysChoice input:checked"), function()
		{
			finalValue += $(this).val() + ",";
		});
		
		$("#days_available").val(finalValue);
    });
	
	$('.time_available input').change(function() {
		var finalValue = "";
		$.each($(".time_available input:checked"), function()
		{
			finalValue += $(this).val() + ",";
		});
		
		$("#time_available").val(finalValue);
    });
	
	$('.approved_titles input').change(function() {
		var finalValue = "";
		$.each($(".approved_titles input:checked"), function()
		{
			finalValue += $(this).val() + ",";
		});
		
		$("#approved_titles").val(finalValue);
    });
	
	    $('.experience input').change(function() {
		var finalValue = "";
		$.each($(".experience input:checked"), function()
		{
			finalValue += $(this).val() + ",";
		});
		
		$("#experience").val(finalValue);
    });
	
	$('.agree_nna input').change(function() {		
		$("#agree_nna").attr('checked', ($(this).val() == "Yes"));
    });
	
		
	$('.claims_against input').change(function() {		
		$("#claims_against").attr('checked', ($(this).val() == "Yes"));
    });
	
	
	$('.convicted_misdemeanor input').change(function() {		
		$("#convicted_misdemeanor").attr('checked', ($(this).val() == "Yes"));
    });
	
	$('.smartphone_carrier').change(function() {	
		$("#smartphone_carrier").val($(".smartphone_carrier").val());
    });
	
	$('.travel_distance').change(function() {	
		$("#travel_distance").val($(".travel_distance").val());
    });
	
	$('.smartphone_type').change(function() {	
		$("#smartphone_type").val($(".smartphone_type").val());
    });
	
});


</script>
<style>
 #days_available, #time_available, #approved_titles, #agree_nna , #convicted_misdemeanor, #smartphone_carrier, #smartphone_type, #travel_distance, #claims_against, #experience  {display:none;}
 .daysChoice, .time_available, .approved_titles, .agree_nna , .convicted_misdemeanor, .smartphone_carrier, .claims_against, .experience  {margin-left:0px!important;padding-left:0px!important;}
 .daysChoice li, .time_available li , .approved_titles li, .agree_nna li, .convicted_misdemeanor li, .smartphone_carrier li, .claims_against li, .experience li {list-style:none!important;padding-left:0px!important;}
</style>
		
		<tr>
			<td valign="top"><label>Document signing experience</label></td>
			<td>
			
			<?php __($form->input('Notary.experience', array('id'=>'experience','error'=>false,'label'=>false,'class'=>'text')));?>

			
				<ul class="experience">
							<li class="gchoice_1_22_1">
								<input name="input_22.1" type="checkbox"  value="Purchase"  <?php  echo in_array("Purchase", $experience) ? "checked" : "" ?> id="choice_1_22_1" tabindex="16">
								<label for="choice_1_22_1" id="label_1_22_1">Purchase</label>
							</li>
							<li class="gchoice_1_22_2">
								<input name="input_22.2" type="checkbox"  value="Refinances"  <?php  echo in_array("Refinances", $experience) ? "checked" : "" ?> id="choice_1_22_2" tabindex="17">
								<label for="choice_1_22_2" id="label_1_22_2">Refinances</label>
							</li>
							<li class="gchoice_1_22_3">
								<input name="input_22.3" type="checkbox" value="REO"  <?php  echo in_array("REO", $experience) ? "checked" : "" ?> id="choice_1_22_3" tabindex="18">
								<label for="choice_1_22_3" id="label_1_22_3">REO</label>
							</li>
							<li class="gchoice_1_22_4">
								<input name="input_22.4" type="checkbox" value="Reverse mortgage"  <?php  echo in_array("Reverse mortgage", $experience) ? "checked" : "" ?> id="choice_1_22_4" tabindex="19">
								<label for="choice_1_22_4" id="label_1_22_4">Reverse mortgage</label>
							</li>
							<li class="gchoice_1_22_5">
								<input name="input_22.5" type="checkbox" value="Equity / HELOC"  <?php  echo in_array("Equity / HELOC", $experience) ? "checked" : "" ?> id="choice_1_22_5" tabindex="20">
								<label for="choice_1_22_5" id="label_1_22_5">Equity / HELOC</label>
							</li>
							<li class="gchoice_1_22_6">
								<input name="input_22.6" type="checkbox" value="Electronic notarization"  <?php  echo in_array("Electronic notarization", $experience) ? "checked" : "" ?> id="choice_1_22_6" tabindex="21">
								<label for="choice_1_22_6" id="label_1_22_6">Electronic notarization</label>
							</li>
							<li class="gchoice_1_22_7">
								<input name="input_22.7" type="checkbox" value="Remote (video) notarization"  <?php  echo in_array("Remote (video) notarization", $experience) ? "checked" : "" ?> id="choice_1_22_7" tabindex="22">
								<label for="choice_1_22_7" id="label_1_22_7">Remote (video) notarization</label>
							</li>
							<li class="gchoice_1_22_8">
								<input name="input_22.8" type="checkbox" value="Commercial loan packages"  <?php  echo in_array("Commercial loan packages", $experience) ? "checked" : "" ?> id="choice_1_22_8" tabindex="23">
								<label for="choice_1_22_8" id="label_1_22_8">Commercial loan packages</label>
							</li>
							<li class="gchoice_1_22_9">
								<input name="input_22.9" type="checkbox" value="Seller docs"  <?php  echo in_array("Seller docs", $experience) ? "checked" : "" ?> id="choice_1_22_9" tabindex="24">
								<label for="choice_1_22_9" id="label_1_22_9">Seller docs</label>
							</li>
							<li class="gchoice_1_22_11">
								<input name="input_22.11" type="checkbox" value="FHA/VA"   <?php  echo in_array("FHA/VA", $experience) ? "checked" : "" ?> id="choice_1_22_11" tabindex="25">
								<label for="choice_1_22_11" id="label_1_22_11">FHA/VA</label>
							</li>
							<li class="">
								<label>Other</label><?php __($form->input('Notary.experience_other', array('id'=>'experience_other','label'=>false, 'class'=>'text')));?>
							</li>
					</ul>
			
				
			</td>
			

		</tr>

		
		<tr>
			<td valign="top" ><label>What days are you available for signings?</label></td>
			<td valign="top">
			
	
						  <?php __($form->input('Notary.days_available', array('id'=>'days_available','label'=>false, 'class'=>'text')));?>
			
						<ul class="daysChoice">
							<li >
								<input name="input_41.1" type="checkbox" value="Monday" <?php  echo in_array("Monday", $days) ? "checked" : "" ?> id="choice_1_41_1" tabindex="31">
								<label for="choice_1_41_1" id="label_1_41_1">Monday</label>
							</li>
							<li class="gchoice_1_41_2">
								<input name="input_41.2" type="checkbox" value="Tuesday" <?php  echo in_array("Tuesday", $days) ? "checked" : "" ?> id="choice_1_41_2" tabindex="32">
								<label for="choice_1_41_2" id="label_1_41_2">Tuesday</label>
							</li>
							<li class="gchoice_1_41_3">
								<input name="input_41.3" type="checkbox" value="Wednesday" <?php  echo in_array("Wednesday", $days) ? "checked" : "" ?> id="choice_1_41_3" tabindex="33">
								<label for="choice_1_41_3" id="label_1_41_3">Wednesday</label>
							</li>
							<li class="gchoice_1_41_4">
								<input name="input_41.4" type="checkbox" value="Thursday" <?php  echo in_array("Thursday", $days) ? "checked" : "" ?> id="choice_1_41_4" tabindex="34">
								<label for="choice_1_41_4" id="label_1_41_4">Thursday</label>
							</li>
							<li class="gchoice_1_41_5">
								<input name="input_41.5" type="checkbox" value="Friday" <?php  echo in_array("Friday", $days) ? "checked" : "" ?>  id="choice_1_41_5" tabindex="35">
								<label for="choice_1_41_5" id="label_1_41_5">Friday</label>
							</li>
							<li class="gchoice_1_41_6">
								<input name="input_41.6" type="checkbox" value="Saturday" <?php  echo in_array("Saturday", $days) ? "checked" : "" ?>  id="choice_1_41_6" tabindex="36">
								<label for="choice_1_41_6" id="label_1_41_6">Saturday</label>
							</li>
							<li class="gchoice_1_41_7">
								<input name="input_41.7" type="checkbox" value="Sunday" <?php  echo in_array("Sunday", $days) ? "checked" : "" ?>  id="choice_1_41_7" tabindex="37">
								<label for="choice_1_41_7" id="label_1_41_7">Sunday</label>
							</li>
						</ul>		
			</td>

			<td valign="top"><label>When are you available to conduct loan document signings?</label></td>
		<td valign="top">
			
							
					<?php __($form->input('Notary.time_available', array('id'=>'time_available','label'=>false, 'class'=>'text')));?>

					<ul class="time_available">
						<li class="gchoice_1_25_1">
							<input name="input_25.1" type="checkbox" value="All Day" id="choice_1_25_1" <?php  echo in_array("All Day", $times) ? "checked" : "" ?> tabindex="38">
							<label for="choice_1_25_1" id="label_1_25_1">All Day</label>
						</li>
						<li class="gchoice_1_25_2">
							<input name="input_25.2" type="checkbox" value="Morning (8:00am-11:00am)" id="choice_1_25_2" <?php  echo in_array("Morning (8:00am-11:00am)", $times) ? "checked" : "" ?> tabindex="39">
							<label for="choice_1_25_2" id="label_1_25_2">Morning (8:00am-11:00am)</label>
						</li>
						<li class="gchoice_1_25_3">
							<input name="input_25.3" type="checkbox" value="Afternoon (12:00pm-5:00pm)" id="choice_1_25_3" <?php  echo in_array("Afternoon (12:00pm-5:00pm)", $times) ? "checked" : "" ?> tabindex="40">
							<label for="choice_1_25_3" id="label_1_25_3">Afternoon (12:00pm-5:00pm)</label>
						</li>
						<li class="gchoice_1_25_4">
							<input name="input_25.4" type="checkbox" value="Evening (5:00pm-9:00pm)" id="choice_1_25_4" <?php  echo in_array("Evening (5:00pm-9:00pm)", $times) ? "checked" : "" ?> tabindex="41">
							<label for="choice_1_25_4" id="label_1_25_4">Evening (5:00pm-9:00pm)</label>
						</li>
					</ul>


			
			</td>

		</tr>
		
		<tr>
			<td><label>How many loan document signings can you conduct in a single day?</label></td>
			<td><?php __($form->input('Notary.signings_per_day', array('id'=>'signings_per_day','label'=>false, 'class'=>'text')));?></td>
			<td><label>What do you charge a signing service for a refinance signing (EDOCS)?</label></td>
			<td><?php __($form->input('Notary.edocs_charge', array('id'=>'edocs_charge','label'=>false, 'class'=>'text')));?></td>
		</tr>
		
		<tr>
			<td valign="top"><label>If you are on the approved notary list for title companies?</label></td>
			<td valign="top">
							
				<?php __($form->input('Notary.approved_titles', array('id'=>'approved_titles','label'=>false, 'class'=>'text')));?>

				<ul class="approved_titles" id="input_1_38">
					<li class="gchoice_1_38_1">
						<input name="input_38.1" type="checkbox" value="Chicago Title" id="choice_1_38_1" <?php  echo in_array("Chicago Title", $approved_titles) ? "checked" : "" ?> tabindex="44">
						<label for="choice_1_38_1" id="label_1_38_1">Chicago Title</label>
					</li>
					<li class="gchoice_1_38_2">
						<input name="input_38.2" type="checkbox" value="Fidelity Title" id="choice_1_38_2" <?php  echo in_array("Fidelity Title", $approved_titles) ? "checked" : "" ?> tabindex="45">
						<label for="choice_1_38_2" id="label_1_38_2">Fidelity Title</label>
					</li>
					<li class="gchoice_1_38_3">
						<input name="input_38.3" type="checkbox" value="First American Title" id="choice_1_38_3" <?php  echo in_array("First American Title", $approved_titles) ? "checked" : "" ?> tabindex="46">
						<label for="choice_1_38_3" id="label_1_38_3">First American Title</label>
					</li>
					<li class="gchoice_1_38_4">
						<input name="input_38.4" type="checkbox" value="Lawyers Title" id="choice_1_38_4" <?php  echo in_array("Lawyers Title", $approved_titles) ? "checked" : "" ?> tabindex="47">
						<label for="choice_1_38_4" id="label_1_38_4">Lawyers Title</label>
					</li>
					<li class="">
						<label>Other</label><?php __($form->input('Notary.approved_titles_other', array('id'=>'approved_titles_other','label'=>false, 'class'=>'text')));?>
					</li>
				</ul>
		
			</td>
		</tr>
		
		<tr>
			<td><label>Do you agree to maintain and provide an annual NNA Certified & Background-Screened Notary Signing Agent Certificate and annual NNA Background Check?</label></td>
			<td>
			
				<?php __($form->input('Notary.agree_nna', array('id'=>'agree_nna','label'=>false, 'class'=>'checkbox')));?>
				<ul class="agree_nna" id="input_1_2711">
					<li class="gchoice_1_2711_0">
						<input name="input_2711" type="radio" value="Yes" id="choice_1_2711_0" <?php  echo $agree_nna == "1" ? "checked" : "" ?> tabindex="50">
						<label for="choice_1_2711_0" id="label_1_2711_0">Yes</label>
					</li>
					<li class="gchoice_1_2711_1">
						<input name="input_2711" type="radio" value="No" id="choice_1_2711_1" <?php  echo $agree_nna == "0" ? "checked" : "" ?> tabindex="51">
						<label for="choice_1_2711_1" id="label_1_2711_1">No</label>
					</li>
				</ul>
			
			</td>
		</tr>
		
		<tr>
			<td><label>Have you had any claims/judgments pertaining to real estate transactions and/or notarial transactions been filed against you in the past 10 years?</label></td>
			<td>
			
				<?php __($form->input('Notary.claims_against', array('id'=>'claims_against','label'=>false, 'class'=>'checkbox')));?>
				<ul class="claims_against" id="input_1_27">
					<li class="gchoice_1_27_0">
						<input name="input_27" type="radio" value="Yes" id="choice_1_27_0" <?php  echo $claims_against == "1" ? "checked" : "" ?> tabindex="50">
						<label for="choice_1_27_0" id="label_1_27_0">Yes</label>
					</li>
					<li class="gchoice_1_27_1">
						<input name="input_27" type="radio" value="No" id="choice_1_27_1" <?php  echo $claims_against == "0" ? "checked" : "" ?> tabindex="51">
						<label for="choice_1_27_1" id="label_1_27_1">No</label>
					</li>
				</ul>
			
			</td>
			<td><label>Have you been convicted of a misdemeanor or felony in the past 10 years?</label></td>
			<td>
			
					<?php __($form->input('Notary.convicted_misdemeanor', array('id'=>'convicted_misdemeanor','label'=>false, 'class'=>'checkbox')));?>
					<ul class="convicted_misdemeanor">
						<li class="gchoice_1_28_0">
							<input name="input_choice_1_28" type="radio" value="Yes" id="choice_1_28_0" <?php  echo $convicted_misdemeanor == "1" ? "checked" : "" ?> tabindex="50">
							<label for="choice_1_28_0" id="label_1_choice_1_28_0">Yes</label>
						</li>
						<li class="gchoice_1_28_1">
							<input name="input_choice_1_28" type="radio" value="No" id="choice_1_28_1" <?php  echo $convicted_misdemeanor == "0" ? "checked" : "" ?> tabindex="51">
							<label for="choice_1_28_1" id="label_1_choice_1_28_1">No</label>
						</li>
					</ul>
			
			</td>
		</tr>
		
		<tr>
			<td><label>What type of smarthphone do you have?</label></td>
			<td>
				<?php __($form->input('Notary.smartphone_type', array('id'=>'smartphone_type','label'=>false, 'class'=>'text')));?>
				<select class="smartphone_type" name="smartphone_type" tabindex="12">
					<option value="iPhone" <?php echo $smartphone_type == "iPhone" ? "selected" : "" ?>>iPhone</option>
					<option value="Android" <?php echo $smartphone_type == "Android" ? "selected" : "" ?>>Android</option>
					<option value="LG" <?php echo $smartphone_type == "LG" ? "selected" : ""?>>LG</option>
					<option value="BlackBerry" <?php echo $smartphone_type == "BlackBerry" ? "selected" : "" ?>>BlackBerry</option>
					<option value="I don't have a smartphone" <?php  echo $smartphone_type == "I don't have a smartphone" ? "selected" : "" ?>>I don't have a smartphone</option>
				</select>
			</td>
			
			<td><label>What carrier do you have?</label></td>
			<td>
				<?php __($form->input('Notary.smartphone_carrier', array('id'=>'smartphone_carrier','label'=>false, 'class'=>'text')));?>
				<select class="smartphone_carrier" name="smartphone_carrier" tabindex="12">
					<option value="Verizon" <?php echo $smartphone_carrier == "Verizon" ? "selected" : "" ?>>Verizon</option>
					<option value="AT&T" <?php echo $smartphone_carrier == "AT&T" ? "selected" : "" ?>>AT&amp;T</option>
					<option value="Sprint" <?php echo $smartphone_carrier == "Sprint" ? "selected" : ""?>>Sprint</option>
					<option value="T-mobile" <?php echo $smartphone_carrier == "T-mobile" ? "selected" : "" ?>>T-mobile</option>
				</select>
			
			
			</td>
		</tr>
		
		<tr>
			<td><label>How far are you willing to travel?</label></td>
			<td>
			
			<?php __($form->input('Notary.travel_distance', array('id'=>'travel_distance','label'=>false, 'class'=>'text')));?>
				<select class="travel_distance" name="travel_distance" tabindex="12">
					<option value="1-25 miles" <?php echo $travel_distance == "1-25 miles" ? "selected" : "" ?>>1-25 miles</option>
					<option value="1-50 miles" <?php echo $travel_distance == "1-50 miles" ? "selected" : "" ?>>1-50 miles</option>
					<option value="1-75 miles" <?php echo $travel_distance == "1-75 miles" ? "selected" : ""?>>1-75 miles</option>
					<option value="1-100 miles" <?php echo $travel_distance == "1-100 miles" ? "selected" : "" ?>>1-100 miles</option>
					<option value="100+ miles" <?php echo $travel_distance == "100+ miles" ? "selected" : "" ?>>100+ miles</option>
				</select>
			
			</td>
		</tr>
		
	</table>
</p></div>
<div><p>
	<div id="upload_container_zip">
<?php
	$zip = explode("|",$this->data['Notary']['zipcode']);
	$total = count($zip);
		for($i=1;$i<=$total;$i++){
?>
		<div class="form_block required" id="divrowzip<?php __($i); ?>" style="margin-bottom:3px;padding: 5px;">
		<p class="fleft" style="width:25%;"><label>Zip code covered <?php __($i); ?><span class="mandatory">*</span></label></p><div class="fleft" style="width:25%;"><?php echo $form->input('Notary.zipcode', array('id'=>'Zipcode'.$i,'label'=>false,'error'=>false,'value'=>$zip[$i-1],'name'=>"data[Notary][zipcode][]",'class'=>'text'));?></div><?php if($i>1) { ?><div class="float_div1"><p><a href="javascript:void(0)" onclick="javascript:delete_row_zip('<?php __($i); ?>')" class="delete_btn" title="Remove">Remove</a></p></div><?php } ?></div>
<?php	} ?>
		</div>
		<div style="display:block;" id="fileid" class="addtracks"><p><a href="javascript:void(0)" onclick="javascript:add_rows_zip();" id='addMore' class="fright">Add another zip code covered</a></p><input type="hidden" id="upload_count_zip" name="upload_count_zip" value="<?php echo $total;?>"/></div>
</p></div>
<?php	
	}
?>		<div><p>	
<table class="formtable">
		<tr><th>Login Information</th></tr>
		<tr><th colspan="4"><hr /></th></tr>
		<tr>
			<td width="25%"><label>Username<span class="mandatory">*</span></label></td>
			<td width="25%"><?php echo $form->input('username', array('id'=>'Username','label'=>false, 'class'=>'text'));?></td>
			<td width="25%"><label>Password</label></td>
			<td width="25%"><?php echo $form->input('password',array('id'=>'Password','label'=>false,'class'=>'text','maxlength'=>'25','value'=>'','div'=>false));?></td>
		</tr>
		<tr>
			<td colspan="4"><span class="mandatory">[ If you would like to change the password, enter a new one, otherwise leave this blank ]</span></td>
		</tr>
		<tr>
			<td colspan="4"><hr /><?php __($form->submit('Submit', array('div'=>false,'class'=>'submit small fleft'))); ?>
			<?php __($html->link('Cancel',array('controller'=>'users','type'=>$type,'action'=>'index'),array('div'=>false,'class'=>'normalbutton fleft'))); ?></td>
		</tr>
		<input type="hidden" name="a_falg" value="1" id="a_falg">
<?php
	echo $form->hidden('type', array('id'=>'type', 'value' => $ctype));
	echo $form->hidden('utype', array('id'=>'utype', 'value' => $utype));
	echo $form->input('id'); 
?>
	</table></p>
<?php
	echo $form->end();
?>
			</div>
		</div>
	</div>
</div>
<script>
$("#CompanyPhone").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){ 
     var test= $("#CompanyPhone").val();
	test = test.replace('-','').replace('-','');
	$("#CompanyPhone").val(test);


    }
});
$("#CompanyFax").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){ 
     var test= $("#CompanyFax").val();
	test = test.replace('-','').replace('-','');
	$("#CompanyFax").val(test);


    }
});
$("#DayPhone").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){
     var test= $("#DayPhone").val();
	test = test.replace('-','').replace('-','');
	$("#DayPhone").val(test);
    }
});
$("#EveningPhone").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){
     var test= $("#EveningPhone").val();
	test = test.replace('-','').replace('-','');
	$("#EveningPhone").val(test);


    }
});
$("#CellPhone").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){
     var test= $("#CellPhone").val();
	test = test.replace('-','').replace('-','');
	$("#CellPhone").val(test);


    }
});
$("#Fax").keydown(function(e){
    var keycode =  e.keyCode ? e.keyCode : e.which;
    
     if(keycode == 8){
     var test= $("#Fax").val();
	test = test.replace('-','').replace('-','');
	$("#Fax").val(test);


    }
});
function showval(){document.getElementById('ReturnAddress').value = document.getElementById("OfficeAddress").value;document.getElementById('ReturnCity').value = document.getElementById("OfficeCity").value;document.getElementById('ReturnState').value = document.getElementById("OfficeState").value;document.getElementById('ReturnZipcode').value = document.getElementById("OfficeZipcode").value;}function showvals(){document.getElementById('PaymentAddress').value=document.getElementById('DocumentAddress').value;document.getElementById('PaymentState').value = document.getElementById('DocumentState').value;document.getElementById('PaymentCity').value = document.getElementById('DocumentCity').value;document.getElementById('PaymentZipcode').value = document.getElementById('DocumentZipcode').value;}function showtxtb(){if(document.getElementById('how_did_u_hear').value =='R'){document.getElementById('ref').style.display = "block";}else{document.getElementById('ref').style.display="none";}}function showtxtother(){if(document.getElementById('Shipping_Carrier').value =='O'){document.getElementById('other').style.display="block";}else{document.getElementById('other').style.display="none";}}$('#Email').focusout(function() {var un= $('#Email').val();$("#Username").val(un);});$('#EmailAddress').focusout(function() {var un= $('#EmailAddress').val();$("#Username").val(un);});function showtype(){if(document.getElementById('notarytype').value =='P'){document.getElementById('paytype').style.display="block";}else{document.getElementById('paytype').style.display="none";}}</script>