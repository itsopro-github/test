<?php echo $html->css(array('ui.all')); ?>
<?php echo $html->css(array('ui.core')); ?>
<?php e($javascript->link('ui.datepicker')); ?>
<script type="text/javascript">$(function(){$('#Expiration').datepicker({changeMonth:true,changeYear:true,yearRange:'2010:2022'});});</script>	
<?php __($html->tag('h3', 'Personal Details'));?>
<div class="form_block required">
	<p><label class="form_label">First Name<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.first_name',array('id'=>'FirstName','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Last Name<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.last_name',array('id'=>'LastName','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Email Address<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.email',array('id'=>'EmailAddress','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</p>
</div>

<div class="form_block  required">
	<p><label class="form_label">Mobile Phone<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.cell_phone1', array('maxlength'=>'3', 'id'=>'CellPhone1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 0, 3)));?>
	<?php echo $form->input('Notary.cell_phone2', array('maxlength'=>'3', 'id'=>'CellPhone2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 3, 3)));?>
	<?php echo $form->input('Notary.cell_phone3', array('maxlength'=>'4', 'id'=>'CellPhone3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['cell_phone'], 6, 4)));?>
	</p></div>
<div class="form_block ">
	<p><label class="form_label">Office Phone</label>
	<?php echo $form->input('Notary.day_phone1', array('maxlength'=>'3','id'=>'DayPhone1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 0, 3)));?>
	<?php echo $form->input('Notary.day_phone2', array('maxlength'=>'3','id'=>'DayPhone2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 3, 3)));?>
	<?php echo $form->input('Notary.day_phone3', array('maxlength'=>'4','id'=>'DayPhone3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['day_phone'], 6, 4)));?>
	</p></div>
<div class="form_block ">
	<p><label class="form_label">Home Phone</label>
	<?php echo $form->input('Notary.evening_phone1', array('maxlength'=>'3','id'=>'EveningPhone1','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 0, 3)));?>
	<?php echo $form->input('Notary.evening_phone2', array('maxlength'=>'3','id'=>'EveningPhone2','error'=>false,'label'=>false, 'class'=>'text_box tiny1 fleft','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 3, 3)));?>
	<?php echo $form->input('Notary.evening_phone3', array('maxlength'=>'4','id'=>'EveningPhone3','error'=>false,'label'=>false, 'class'=>'text_box tiny1','value'=>$misc->splitphone(@$this->data['Notary']['evening_phone'], 6, 4)));?>
	</p></div>


<?php __($html->tag('h3', 'Mailing Address'));?>
<div class="form_block required">
	<p><label class="form_label">Street Address<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.dd_address',array('id'=>'DocumentAddress','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">City<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.dd_city',array('id'=>'DocumentCity','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">State<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.dd_state',array('id'=>'DocumentState','label'=>false,'error'=>false,'class'=>'select_box','options'=>$states)); ?>
	</p>
</div>
<div class="form_block required">
	<p><label class="form_label">Zip Code<span class="mandatory">*</span></label>
	<?php echo $form->input('Notary.dd_zip',array('id'=>'DocumentZipcode','label'=>false,'error'=>false,'class'=>'text_box')); ?>
	</p>
</div>

<div class="form_block">
	<p><label class="form_label">Website<span class="mandatory"></span></label>
	<?php echo $form->input('Notary.website',array('id'=>'Website','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</p>
</div>

<div class="form_block">
	<p>
		<label class="form_label">What documents do you have experience conducting a signing?</label>

	<ul style="margin:0px;padding:0px;">
	
	<?php 
		$counter = 0;
		foreach ($experienceoptions as &$value) 
		{
			echo '<li style="background-image:none;margin:0px;padding:0px;">';
			echo '<input name="experience[]" id="experience_' . $counter . '" type="checkbox"  value="' . $counter . '">';
			echo '<label style="display:inline;font-weight:bold;font-size:100%;" for="experience_' . $counter . '">' . $value . '</label>';
			echo '</li>';
			$counter++;
		}
		
			echo '<li style="background-image:none;margin:0px;padding:0px;">';
			echo '<input name="experience[]" id="experience_other" type="checkbox"  value="' . $counter . '">';
			echo '<label style="display:inline;font-weight:bold;font-size:100%;" for="experience_other">Other</label>';
			echo '</li>';
	?>	
	</ul>
	
	<div id="other_experience" style="display:none;">
	<script>
	$('#experience_other').change(function(){
		var c = this.checked ? 	$('#other_experience').show() : 	$('#other_experience').hide();
	});
	</script>
	<p>Please indicate the Other types of documents you have experience notarizing.</p>
	<?php echo $form->input('Notary.experience_other',array('id'=>'experience_other','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</div>
	</p>
</div>

<div class="form_block">
	<p><label class="form_label">What year did you become a notary?</label>
	<?php echo $form->input('Notary.year_start_notary',array('id'=>'year_start_notary','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</p>
</div>

<div class="form_block">
	<p><label class="form_label">What year did you start conducting loan document signings?</label>
	<?php echo $form->input('Notary.year_start_signings',array('id'=>'year_start_signings','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</p>
</div>

<div class="form_block">
	<p><label class="form_label">How many loan document signings have you conducted?</label>
	<?php echo $form->input('Notary.doc_signings_count',array('id'=>'doc_signings_count','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</p>
</div>

<div class="form_block">
	<p>
		<label class="form_label">What days are you available for signings? (Please check all that apply)</label>

	<ul style="margin:0px;padding:0px;">
	
	<?php 
		$counter = 0;
		foreach ($dayoptions as &$value) 
		{
			echo '<li style="background-image:none;margin:0px;padding:0px;">';
			echo '<input name="availabledays[]" id="availabledays_' . $counter . '" type="checkbox"  value="' . $counter . '">';
			echo '<label style="display:inline;font-weight:bold;font-size:100%;" for="availabledays_' . $counter . '">' . $value . '</label>';
			echo '</li>';
			$counter++;
		}
	?>	
	</ul>
	</p>
</div>

<div class="form_block">
	<p>
		<label class="form_label">When are you available to conduct loan document signings? (Please check all that apply)</label>

	<ul style="margin:0px;padding:0px;">
	
	<?php 
		$counter = 0;
		foreach ($timeoptions as &$value) 
		{
			echo '<li style="background-image:none;margin:0px;padding:0px;">';
			echo '<input name="time_available[]" id="time_available_' . $counter . '" type="checkbox"  value="' . $counter . '">';
			echo '<label style="display:inline;font-weight:bold;font-size:100%;" for="time_available_' . $counter . '">' . $value . '</label>';
			echo '</li>';
			$counter++;
		}
	?>	
	</ul>
	
	</p>
</div>


<div class="form_block">
	<p><label class="form_label">How many loan document signings can you conduct in a single day?</label>
	<?php echo $form->input('Notary.signings_per_day',array('id'=>'signings_per_day','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</p>
</div>


<div class="form_block">
	<p><label class="form_label">What do you charge a signing service for a refinance signing (EDOCS)?</label>
	<?php echo $form->input('Notary.edocs_charge',array('id'=>'edocs_charge','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</p>
</div>


<div class="form_block">
	<p>
		<label class="form_label">If you are on the approved notary list for title companies, check all that apply</label>

	<ul style="margin:0px;padding:0px;">
	
	<?php 
		$counter = 0;
		foreach ($approvesoptions as &$value) 
		{
			echo '<li style="background-image:none;margin:0px;padding:0px;">';
			echo '<input name="approved_titles[]" id="approved_titles_' . $counter . '" type="checkbox"  value="' . $counter . '">';
			echo '<label style="display:inline;font-weight:bold;font-size:100%;" for="approved_titles_' . $counter . '">' . $value . '</label>';
			echo '</li>';
			$counter++;
		}
		
			echo '<li style="background-image:none;margin:0px;padding:0px;">';
			echo '<input name="approved_titles[]" id="approved_titles_other" type="checkbox"  value="' . $counter . '">';
			echo '<label style="display:inline;font-weight:bold;font-size:100%;" for="approved_titles_other">Other</label>';
			echo '</li>';
	?>	
	</ul>
	<div id="other_notary_list" style="display:none;">
	<script>
	$('#approved_titles_other').change(function(){
		var c = this.checked ? 	$('#other_notary_list').show() : 	$('#other_notary_list').hide();
	});
	</script>
	<p>If you're an approved notary for a title company not listed, please indicate the title company below.</p>
	<?php echo $form->input('Notary.approved_titles_other',array('id'=>'approved_titles_other','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</div>
	
	</p>
</div>


<div class="form_block ">
	<p><label class="form_label">Do you agree to maintain and provide an annual NNA Certified & Background-Screened Notary Signing Agent Certificate and annual NNA Background Check?</label> 
		<input type="radio" name="data[Notary][agree_nna]"  id="agree_nna_true" value="1" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="agree_nna_true">Yes</label> <br />
		<input type="radio" name="data[Notary][agree_nna]"  id="agree_nna_false" value="0" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="agree_nna_false">No</label>
	</p>
</div>


<div class="form_block ">
	<p><label class="form_label">Have you had any claims/judgments pertaining to real estate transactions and/or notarial transactions been filed against you in the past 10 years**?</label> 
		<input type="radio" name="data[Notary][claims_against]"  id="claims_against_true" value="1" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="claims_against_true">Yes</label> <br />
		<input type="radio" name="data[Notary][claims_against]"  id="claims_against_false" value="0" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="claims_against_false">No</label><br />
		<span>**Term applicable in all States with the exception of CA, CO, KS, MD, MA, MT, NV, NH, NM, NY, WA for which the term specified herein shall be 7 years.</span><br />
	</p>
</div>


<div class="form_block ">
	<p><label class="form_label">Have you been convicted of a misdemeanor or felony in the past 10 years**?*</label> 
		<input type="radio" name="data[Notary][convicted_misdemeanor]" id="convicted_misdemeanor_true" value="1" />   <label style="display:inline;font-weight:bold;font-size:100%;" for="convicted_misdemeanor_true">Yes</label>   <br />
		<input type="radio" name="data[Notary][convicted_misdemeanor]" id="convicted_misdemeanor_false" value="0" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="convicted_misdemeanor_false">No</label><br />
		<span>**Term applicable in all States with the exception of CA, CO, KS, MD, MA, MT, NV, NH, NM, NY, WA for which the term specified herein shall be 7 years.</span><br />
	</p>
</div>

<div class="form_block">
	<p>
		<label class="form_label">Additional languages</label>

	<ul style="margin:0px;padding:0px;">
	
	<?php 
		$counter = 0;
		foreach ($langoptions as &$value) 
		{
			echo '<li style="background-image:none;margin:0px;padding:0px;">';
			echo '<input name="languages[]" id="languages_' . $counter . '" type="checkbox"  value="' . $counter . '">';
			echo '<label style="display:inline;font-weight:bold;font-size:100%;" for="languages_' . $counter . '">' . $value . '</label>';
			echo '</li>';
			$counter++;
		}
		
			echo '<li style="background-image:none;margin:0px;padding:0px;">';
			echo '<input name="languages[]" id="languages_other" type="checkbox"  value="' . $counter . '">';
			echo '<label style="display:inline;font-weight:bold;font-size:100%;" for="languages_other">Other</label>';
			echo '</li>';
	?>	
	</ul>
	
	<div id="other_language_list" style="display:none;">
	<script>
	$('#languages_other').change(function(){
		var c = this.checked ? 	$('#other_language_list').show() : 	$('#other_language_list').hide();
	});
	</script>
	<p>If you selected "Other," please specify the other language(s) you speak here.</p>
	<?php echo $form->input('Notary.languages_other',array('id'=>'languages_other','label'=>false,'error'=>false,'class'=>'text_area')); ?>
	</div>
	
	</p>
</div>


<div class="form_block ">
	<p><label class="form_label">What type of smarthphone do you have?</label> 
		<input type="radio" name="data[Notary][smartphone_type]" id="smartphone_type_1" value="iPhone" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="smartphone_type_1">iPhone</label>  <br />
		<input type="radio" name="data[Notary][smartphone_type]" id="smartphone_type_2" value="Android" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="smartphone_type_2">Android</label> <br />
		<input type="radio" name="data[Notary][smartphone_type]" id="smartphone_type_3" value="LG" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="smartphone_type_3">LG</label>  <br />
		<input type="radio" name="data[Notary][smartphone_type]" id="smartphone_type_4" value="BlackBerry" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="smartphone_type_4">BlackBerry</label>  <br />
		<input type="radio" name="data[Notary][smartphone_type]" id="smartphone_type_5" value="I don't have a smartphone" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="smartphone_type_5">I don't have a smartphone</label>  <br />
	</p>
</div>


<div class="form_block ">
	<p><label class="form_label">What carrier do you have?</label> 
		<input type="radio" name="data[Notary][smartphone_carrier]" id="smartphone_carrier_1" value="Verizon" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="smartphone_carrier_1">Verizon</label>  <br />
		<input type="radio" name="data[Notary][smartphone_carrier]" id="smartphone_carrier_2" value="AT&T" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="smartphone_carrier_2"> AT&amp;T</label><br />
		<input type="radio" name="data[Notary][smartphone_carrier]" id="smartphone_carrier_3" value="Sprint" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="smartphone_carrier_3">Sprint</label>  <br />
		<input type="radio" name="data[Notary][smartphone_carrier]" id="smartphone_carrier_4" value="T-mobile" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="smartphone_carrier_4">T-mobile</label>  <br />
	</p>
</div>


<div class="form_block ">
	<p><label class="form_label">How far are you willing to travel?<label> 
		<input type="radio" name="data[Notary][travel_distance]" id="travel_distance_1" value="1-25 miles" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="travel_distance_1">1-25 miles</label>  <br />
		<input type="radio" name="data[Notary][travel_distance]" id="travel_distance_2" value="1-50 miles" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="travel_distance_2">1-50 miles</label> <br />
		<input type="radio" name="data[Notary][travel_distance]" id="travel_distance_3" value="1-75 miles" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="travel_distance_3">1-75 miles</label> <br />
		<input type="radio" name="data[Notary][travel_distance]" id="travel_distance_4" value="1-100 miles" /><label style="display:inline;font-weight:bold;font-size:100%;" for="travel_distance_4"> 1-100 miles</label>  <br />
		<input type="radio" name="data[Notary][travel_distance]" id="travel_distance_5" value="100+ miles" /> <label style="display:inline;font-weight:bold;font-size:100%;" for="travel_distance_5">100+ miles</label> <br />
	</p>
</div>


<input type="hidden" name="c_falg" value="0" id="c_falg" >
<?php echo $form->input('Notary.notarytype',array('type'=>'hidden','value'=>'B'));?>
<script>$("#DayPhone").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#DayPhone").val();test = test.replace('-','').replace('-','');$("#DayPhone").val(test);}});$("#EveningPhone").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#EveningPhone").val();test = test.replace('-','').replace('-','');$("#EveningPhone").val(test);}});$("#CellPhone").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test= $("#CellPhone").val();test = test.replace('-','').replace('-','');$("#CellPhone").val(test);}});$("#Fax").keydown(function(e){var keycode=e.keyCode ? e.keyCode : e.which;if(keycode == 8){var test = $("#Fax").val();test = test.replace('-','').replace('-','');$("#Fax").val(test);}});function showtxtb() {if(document.getElementById('how_did_u_hear').value =='R'){document.getElementById('ref').style.display = "block";}else{document.getElementById('ref').style.display = "none";	}}</script>