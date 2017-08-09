Hi <?php __($orderdata['salutation']); ?>,<br /><br />
<?php
	switch ($orderdata['mailorderstatus']) {
		
		case '1':
			/*	When a new order is placed, mail to CLIENT	*/
			$details = 'Thank you for placing your request with '.Configure::read('sitename').'. Your current notary request has been successfully submitted to  '.Configure::read('sitename').'. You will receive Notary Information shortly. <br /><br />To view all signings, including this request, '.$html->link('LOG IN', Configure::read('WEB_URL')."login").' and go to "Current Signings". Further updates will be sent to you via e-mail and instantly available online.<br /><br />';
			$details .= 'Signing Information<br /><br />';
			$details .= 'Signing date: '.$counter->formatdate('nsdate', strtotime($orderdata['Order']['date_signing'])).'<br />';
			$details .= 'Borrower name: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].'<br />';
			$details .= 'Signing address: '.$orderdata['Order']['sa_street_address'].', '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].', '.$orderdata['Order']['sa_zipcode'].'<br />';
			$details .= 'Property address: '.$orderdata['Order']['pa_street_address'].', '.$orderdata['Order']['pa_city'].', '.$orderdata['Order']['pa_state'].', '.$orderdata['Order']['pa_zipcode'].'<br />';
			$details .= 'Home phone: '.$counter->tousphone($orderdata['Order']['home_phone']).'<br />';
			$details .= 'Work phone: '.$counter->tousphone($orderdata['Order']['work_phone']).'<br />';
			$details .= 'Cell phone: '.$counter->tousphone($orderdata['Order']['cell_phone']);
			break;
			
		case '10':
			/*	When a new order is placed, mail to NOTARY	*/
			$details = 'There is a signing available in  '.$orderdata['zipcode'].' on '.$counter->formatdate('nsdate', strtotime($orderdata['signing_date'])).'. Please call '.Configure::read('tollfreenumber').' ext '.Configure::read('extension').' and dial this 4-digit reference code when prompted: '.$orderdata['reference'].'<br /><br />'.'4-digit reference code: '.$orderdata['reference'];
			break;
		
		case '11':
			/*	When a new order is placed, mail to ADMIN	*/
			$details = 'Signing Information<br /><br />';
			$details .= 'Signing date: '.$counter->formatdate('nsdate', strtotime($orderdata['Order']['date_signing'])).'<br />';
			$details .= 'Borrower name: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].'<br />';
			$details .= 'Signing address: '.$orderdata['Order']['sa_street_address'].', '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].', '.$orderdata['Order']['sa_zipcode'].'<br />';
			$details .= 'Property address: '.$orderdata['Order']['pa_street_address'].', '.$orderdata['Order']['pa_city'].', '.$orderdata['Order']['pa_state'].', '.$orderdata['Order']['pa_zipcode'].'<br />';
			$details .= 'Home phone: '.$counter->tousphone($orderdata['Order']['home_phone']).'<br />';
			$details .= 'Work phone: '.$counter->tousphone($orderdata['Order']['work_phone']).'<br />';
			$details .= 'Cell phone: '.$counter->tousphone($orderdata['Order']['cell_phone']);
			break;
		
		case '20':
			/*	When a order is ASSIGNED, the below mail is sent to CLIENT	*/
			$details = 'The current request has been successfully assigned to '.$orderdata['notary']['Notary']['first_name'].' '.$orderdata['notary']['Notary']['last_name'].'. The notary\'s contact information is listed below.<br /><br />';
			$details .= 'Signing status: ASSIGNED<br /><br />';
			$details .= 'Notary Information<br /><br />';
			$details .= 'Name: '.$orderdata['notary']['Notary']['first_name'].' '.$orderdata['notary']['Notary']['last_name'].'<br />';
			$details .= 'Cell phone: '.$counter->tousphone($orderdata['notary']['Notary']['cell_phone']).'<br />';
			$details .= 'Day phone: '.$counter->tousphone($orderdata['notary']['Notary']['day_phone']).'<br />';
			$details .= 'Evening phone: '.$counter->tousphone($orderdata['notary']['Notary']['evening_phone']).'<br />';
			$details .= 'E-Mail address: '.$orderdata['notary']['Notary']['email'].'<br />';
			$details .= 'Document delivery address: '.$orderdata['notary']['Notary']['dd_address'].'<br />';
			$details .= 'City: '.$orderdata['notary']['Notary']['dd_city'].'<br />';
			$details .= 'State: '.$orderdata['notary']['Notary']['dd_state'].'<br />';
			$details .= 'Zip code: '.$orderdata['notary']['Notary']['dd_zip'].'<br />';
			
			if($orderdata['notes']) {
				$details .= '<br />ASSIGNED Notes: '.$orderdata['notes'].'<br />';
			}
			
			$details .= '<br />To view all signings, including this request, '.$html->link('LOGIN', Configure::read('WEB_URL')."login"). ' and go to "Current Signings". Further updates will be sent to you via e-mail and instantly available online.';
			break;
			
		case '21':
			/*	When a order is ASSIGNED, the below mail is sent to assigned NOTARY	*/
			$details = 'Congratulations! You have received a signing from '.Configure::read('sitename').'. Please contact the borrower immediately. You must '.$html->link('LOGIN', Configure::read('WEB_URL').'login').' to receive all signing instructions.<br /><br />';
			$details .= 'Borrower’s Information<br /><br />';
			$details .= 'Signing date: '.$counter->formatdate('nsdate', strtotime($orderdata['Order']['date_signing'])).'<br />';
			$details .= 'Borrower name: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].'<br />';
			$details .= 'Signing address: '.$orderdata['Order']['sa_street_address'].', '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].', '.$orderdata['Order']['sa_zipcode'].'<br />';
			$details .= 'Property address: '.$orderdata['Order']['pa_street_address'].', '.$orderdata['Order']['pa_city'].', '.$orderdata['Order']['pa_state'].', '.$orderdata['Order']['pa_zipcode'].'<br />';
			$details .= 'Home phone: '.$counter->tousphone($orderdata['Order']['home_phone']).'<br />';
			$details .= 'Work phone: '.$counter->tousphone($orderdata['Order']['work_phone']).'<br />';
			$details .= 'Cell phone: '.$counter->tousphone($orderdata['Order']['cell_phone']).'<br />';
			if($orderdata['notes']) {
				$details .= '<br />ASSIGNED Notes: '.$orderdata['notes'].'<br />';
			}
			
			$details .= '<br />To update this signing, '.$html->link('LOGIN', Configure::read('WEB_URL')."login"). ' and go to "Current Signings"';
			break;
			
		case '2':
			/*	When a order is Assigned itself and add notes from change staus tab, mail to CLIENT */
			$details = 'Please see the update of this file below. To view all signings, including this request, click '.$html->link('Current Signings', Configure::read('WEB_URL')."clients/myaccount/current-signings").'. Further updates will be sent to you via e-mail.<br /><br />';
			$details .= 'Signing status: ASSIGNED<br />';
			$details .= 'Notes: '.nl2br($orderdata['notes']).'<br />';
			break;
		case '3':
			/*	When a order is made UNSCHEDULED, mail to CLIENT*/
			$details = 'This file has been updated as UNSCHEDULED. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status UNSCHEDULED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].' <br />';
			if($orderdata['notes']) {
				$details .= '<br />UNSCHEDULED Notes: '.nl2br($orderdata['notes']).' <br />';
			}
			
			$details .= '<br />To view all signings, including this request, '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' and go to "Current Signings". Further updates will be sent to you via e-mail and instantly available online.';
			break;
			
		case '31':
			/*	When a order is made UNSCHEDULED, mail NOTARY*/
			$details = 'This file has been updated as UNSCHEDULED. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status UNSCHEDULED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].' <br />';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />UNSCHEDULED Notes: '.nl2br($orderdata['notes']).' <br />';
			}
			$details .= '<br />To update this signing, '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' and go to "Current Signings"';
			break;
			
		case '32':
			/*	When a order is made UNSCHEDULED, mail to ADMIN*/
			$details = 'Signing status UNSCHEDULED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'];
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />UNSCHEDULED Notes: '.nl2br($orderdata['notes']);
			}
			break;
			
		case '4':
			/*	When a order is made SCHEDULED, mail to CLIENT */
			$details = 'The current request has been successfully scheduled. Please see the appointment date and time below. To view all signings, including this request, click '.$html->link('Current Signings', Configure::read('WEB_URL')."clients/myaccount/current-signings").'. Further updates will be sent to you via e-mail.<br /><br />';
			$details .= 'Signing status: SCHEDULED<br /><br />';
			$details .= 'Appointment date and time: '.$counter->formatdate('nsdate', $orderdata['createddate']).' - '.$orderdata['appointmenttime'];
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />SCHEDULED Notes: '.nl2br($orderdata['notes']);
			}
			
			break;
		
		case '41':
			/*	When a order is made SCHEDULED, mail to NOTARY */
			$details = 'This file has been updated as SCHEDULED. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status SCHEDULED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].' <br /><br />';
			$details .= 'SCHEDULED Date: '.$orderdata['scheduleddate'].'<br />';
			$details .= 'SCHEDULED Time: '.$orderdata['scheduledtime'].'<br />';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />SCHEDULED Notes: '.nl2br($orderdata['notes']).'<br />';
			}
			$details .= '<br />To update this signing as SIGNING COMPLETED and provide tracking #, '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' and go to "Current Signings".';
			break;
		
		case '42':
			/*	When a order is made SCHEDULED, mail to CLIENT */
			$details = 'This file has been updated as SCHEDULED. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status SCHEDULED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].' <br /><br />';
			$details .= 'SCHEDULED Date: '.$orderdata['scheduleddate'].'<br />';
			$details .= 'SCHEDULED Time: '.$orderdata['scheduledtime'].'<br />';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />SCHEDULED Notes: '.nl2br($orderdata['notes']).'<br />';
			}
			$details .= '<br />To view all signings, including this request, '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' and go to "Current Signings". Further updates will be sent to you via e-mail and instantly available online.';
			break;
		
		case '5':
			/*	When a order is made NO SIGN, mail to CLIENT */
			$details = 'Please see the update of this file below. To view all signings, including this request, click '.$html->link('Current Signings', Configure::read('WEB_URL')."clients/myaccount/current-signings").'. Further updates will be sent to you via e-mail.<br /><br />';
			$details .= 'Signing status: NO SIGN';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />NO SIGN Notes: '.nl2br($orderdata['notes']);
			}
			break;
		
		case '51':
			/*	When a order is made NO SIGN, mail to NOTARY */
			$details = 'This file has been updated as NO SIGN. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status NO SIGN: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].' <br />';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />NO SIGN Notes: '.nl2br($orderdata['notes']).' <br />';
			}
			$details .= '<br />Thank you for your assistance with this file, we will contact you for future signings in your area.';
			break;
		
		case '52':
			/*	When a order is made NO SIGN, mail to CLIENT */
			$details = 'This file has been updated as NO SIGN. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status NO SIGN: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].' <br />';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />NO SIGN Notes: '.nl2br($orderdata['notes']).' <br />';
			}
			$details .= '<br />To view all signings, including this request, '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' and go to "Current Signings"';
			break;
		
		case '53':
			/*	When a order is made NO SIGN, mail to ADMIN */
			$details = 'Signing status NO SIGN: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'];
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />NO SIGN Notes: '.nl2br($orderdata['notes']);
			}
			break;
		
		case '60':
			/*	When a order is made PENDING, mail to CLIENT */
			$details = 'This request is currently PENDING. To view all signings, including this request, click '.$html->link('Current Signings', Configure::read('WEB_URL')."clients/myaccount/current-signings").'.<br /><br />';
			$details .= 'Signing status: PENDING';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />PENDING Notes: '.nl2br($orderdata['notes']);
			}
			break;
				
		case '61':
			/*	When a order is made PENDING, mail to CLIENT */
			$details = 'This file has been updated as PENDING until further instruction. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status PENDING: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].' <br />';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />PENDING Notes: '.nl2br($orderdata['notes']).' <br />';
			}
			$details .= '<br />To view all signings, including this request, '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' and go to "Current Signings"';
			break;

		case '62':
			/*	When a order is made PENDING, mail to NOTARY */
			$details = 'This file has been updated as PENDING until further instruction. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status PENDING: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].' <br />';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />PENDING Notes: '.nl2br($orderdata['notes']).' <br />';
			}
			$details .= '<br />Thank you for your assistance with this file, we will contact you for future signings in your area.';
			break;

		case '63':
			/*	When a order is made PENDING, mail to ADMIN */
			$details = 'Signing status PENDING: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'];
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />PENDING Notes: '.nl2br($orderdata['notes']);
			}
			break;

		case '7':
			/*	When a order is made NO SIGN, mail to CLIENT */
			$details = 'The current order has been successfully completed. To view all signings, including this request, click '.$html->link('Current Signings', Configure::read('WEB_URL')."clients/myaccount/current-signings").'. The invoice for this signing will be sent to you shortly.<br /><br />';
			$details .= 'Signing status: SIGNING COMPLETED';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />SIGNED COMPLETED Notes: '.nl2br($orderdata['notes']);
			}
			break;
			
		case '71':
			/*	When a order is SIGNED COMPLETED, mail to CLIENT */
			$details = 'This file has been updated as SIGNING COMPLETED. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details. The invoice for this signing will be sent to you shortly and available in the INVOICES section once you '.$html->link('LOGIN', Configure::read('WEB_URL')."login").'. <br /><br />';
			
			$details .= 'Signing status SIGNING COMPLETED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].' <br /><br />';
			$details .= $orderdata['shipping'].'<br />';
			
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />SIGNING COMPLETED Notes: '.nl2br($orderdata['notes']).' <br />';
			}
			$details .= '<br />To view all signings, including this request, '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' and go to "Current Signings". Further updates will be sent to you via e-mail and instantly available online.';
			break;
			
		case '72':
			/*	When a order is SIGNED COMPLETED, mail to NOTARY */
			$details = 'This file has been updated as SIGNING COMPLETED. Please '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' and provide tracking # for returning documents ASAP.<br /><br />';
			$details .= 'Signing status SIGNING COMPLETED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].'<br /><br />';
			$details .= $orderdata['shipping'].'<br />';
			
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />SIGNING COMPLETED Notes: '.nl2br($orderdata['notes']).'<br />';
			}
			$details .= '<br />Thank you for your assistance with this file, please remember to provide tracking # for returning documents.';
			break;
		
		case '73':
			/*	When a order is SIGNED COMPLETED, mail to ADMIN */
			$details = 'Signing status SIGNING COMPLETED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].'<br /><br />';
			$details .= $orderdata['shipping'];
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />SIGNING COMPLETED Notes: '.nl2br($orderdata['notes']);
			}
			break;
			
		case '8':
			/*	When a order is signed complete, status changed to INVOICED, mail to CLIENT */
			$details = 'The invoice for this signing is attached and available in the INVOICES section once you '.$html->link('LOGIN', Configure::read('WEB_URL')."login");
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />INVOICE Notes: '.nl2br($orderdata['notes']);
			}
			break;

		case '100':
			/*	When a order is made CANCELED, mail to CLIENT */
			$details = 'This request is currently CANCELED. To view all requests, including this request, click '.$html->link('Current Signings', Configure::read('WEB_URL')."clients/myaccount/current-signings").'.<br /><br />';
			$details .= 'Signing status: CANCELED';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />Notes: '.nl2br($orderdata['notes']);
			}
			break;
				
		case '101':
			/*	When a order is made CANCELED, mail to CLIENT */
			$details = 'This file has been updated as CANCELED. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status CANCELED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].'<br />';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />CANCELED Notes: '.nl2br($orderdata['notes']).'<br />';
			}
			$details .= '<br />To view all signings, including this request, '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' and go to "Current Signings"';
			break;

		case '102':
			/*	When a order is made CANCELED, mail to NOTARY */
			$details = 'This file has been updated as CANCELED. Please see notes below or '.$html->link('LOGIN', Configure::read('WEB_URL')."login").' to view further details.<br /><br />';
			$details .= 'Signing status CANCELED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'].'<br />';
			if(isset($orderdata['notes'])!='') {
				$details .= '<br />CANCELED Notes: '.nl2br($orderdata['notes']).'<br />';
			}
			$details .= '<br />Thank you for your assistance with this file, we will contact you for future signings in your area.';
			break;

		case '103':
			/*	When a order is made CANCELED, mail to ADMIN */
			$details = 'Signing status CANCELED: '.$orderdata['Order']['first_name'].' '.$orderdata['Order']['last_name'].' in '.$orderdata['Order']['sa_city'].', '.$orderdata['Order']['sa_state'].' '.$orderdata['Order']['sa_zipcode'];
			if(isset($orderdata['notes'])!='') {
				$details .= '<br /><br />CANCELED Notes: '.nl2br($orderdata['notes']);
			}
			break;
			
		case '200':
			/*	When a order is modifed by CLIENT */
			$details = 'This request is being modified.';
			break;
		
		default:
			$details = 'To view the assignment in the queue and other current signings login to '.Configure::read('sitename').'. The further update will be notified to you through email.';
			break;
	}
	__($details);
?>
<?php if(in_array($orderdata['mailorderstatus'], array('1', '10', '20', '21', '3', '31', '41', '42', '51', '52', '61', '62', '71', '72', '8', '101', '102'))) { ?>
	<br /><br />To your success,<br />
	<?php if(in_array($orderdata['mailorderstatus'], array('1','20','3', '42', '52', '61', '71','8','101'))) { ?>
	<?php __(Configure::read('ceo')); ?><br />
	<?php } ?>
	<?php __(Configure::read('sitename')); ?><br />
	<?php __(Configure::read('PARENT_WEB_URL')); ?><br />
	<?php __(Configure::read('tollfreenumber')); ?>
<?php } ?>	