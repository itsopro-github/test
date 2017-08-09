<?php
class UsersController extends AppController {
	var $name = 'Users';	
	var $components = array('Upload');
	var $uses = array('User','Client', 'Notary','Assignment','Messages','Order','Payment','HistoryFees','ClientRequirements');
	
	function checkmail () {
		$this->layout = null;
		/* Test mail */
		$this->_sendNewMail(array('to'=>'administrator@interberry.com', 'cc'=>'renjith_chacko@interberry.com', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - Checking mail', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'checkemail', 'sendas'=>'html'));
		$this->_sendNewMail(array('to'=>'anidemmy@gmail.com', 'cc'=>'renjith_chacko@interberry.com', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - Checking mail', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'checkemail', 'sendas'=>'html'));
		$this->_sendNewMail(array('to'=>'anidemmy1@gmail.com', 'cc'=>'renjith_chacko@interberry.com', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - Checking mail', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'checkemail', 'sendas'=>'html'));
		$this->_sendNewMail(array('to'=>'anidemmy2@gmail.com', 'cc'=>'renjith_chacko@interberry.com', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - Checking mail', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'checkemail', 'sendas'=>'html'));		
	}
	
	function view($id = null) {
		$this->_checkPermission();
		if (!$id) {
			$this->Session->setFlash('Invalid user','error',array('display'=>'warning'));
			$this->redirect(array('action'=>'index'));
		}
		
		$creq = $this->ClientRequirements->find('all', array('conditions'=>array('ClientRequirements.user_id'=>$id)));
		$this->set('creqs', $creq);
			
		$this->User->Behaviors->attach('Containable');
		$usersdetails = $this->User->find('first', array('fields'=>array('Notary.first_name', 'Notary.last_name', 'Notary.cell_phone', 'Notary.day_phone', 'Notary.evening_phone', 'Notary.email','Notary.fax', 'Notary.dd_address', 'Notary.dd_state', 'Notary.dd_city', 'Notary.dd_zip', 'Notary.commission', 'Notary.expiration', 'Notary.p_address', 'Notary.p_state', 'Notary.p_city', 'Notary.p_zip'),'contain'=>array('Notary'),'conditions'=>array('User.id'=>$id)));
		$this->set('user', $usersdetails);
		$this->set('title_for_layout', Inflector::humanize($this->params['name']));
	}
	
	function signup() {
		if($this->Session->check('WUBSSEWR')) {
			$this->redirect(array('action'=>'myaccount'));
		}
		if (!empty($this->data)) {
			$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));
			$randkey = "";
			for($i=0; $i<32; $i++) {
				$randkey .= $inputs{mt_rand(0,61)};
			}
			$this->data['User']['randkey'] = $randkey;
			$this->data['User']['created'] = date("Y-m-d H:i:s");
			$this->data['User']['modified'] = date("Y-m-d H:i:s");
			
			if(isset($this->data['Client'])  and !empty($this->data['Client']) ) {
				$tm = 'Client';
				$this->data['User']['username'] = $this->data['Client']['email'];
				$this->data['User']['type'] = 'C';
				$this->data['User']['password'] = md5($this->data['Client']['last_name']);
			} else {
				$tm = 'Notary';
				$this->data['User']['username'] = $this->data['Notary']['email'];
				$this->data['User']['type'] = 'N';
				$this->data['User']['password'] = md5($this->data['Notary']['last_name']);
			}

			if ((!empty($this->data['Client']) or !empty($this->data['Notary'])) ) {
				$this->User->create();
				$userdata['User'] = $this->data['User'];
				$emailexists = $this->User->findByUsername($this->data['User']['username']);
				if($emailexists) {
					$this->set('error_messages', $this->User->validationErrors);
					$this->Session->setFlash('The email address already exists.','error',array('display'=>'error'));
				} elseif($this->User->save($userdata)) {
					if($this->data['User']['type'] == 'C'){
						//fees cannot be added from here
						unset($this->Client->validate['fees']);			
						$this->data['Client']['user_id'] = $this->User->id;
						$this->data['Client']['company_phone'] = $this->Miscellaneous->formatphone(array($this->data['Client']['company_phone1'],$this->data['Client']['company_phone2'],$this->data['Client']['company_phone3']));
						$this->data['Client']['company_fax'] = $this->Miscellaneous->formatphone(array($this->data['Client']['company_fax1'],$this->data['Client']['company_fax2'],$this->data['Client']['company_fax3']));
						$det = $this->Client->save($this->data);	
						if(!$det) {
							$this->set('error_messages', $this->User->Client->validationErrors);
							$this->Session->setFlash(''.$tm.' could not be saved. Please, try again.','error',array('display'=>'error'));
						} else {
							/* Send mail to clientregister@1hoursignings.com */
							$this->_sendNewMail(array('to'=>'clientregister@1hoursignings.net', 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - New registration', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'newregistration', 'sendas'=>'html'));
						}
						$pay = "";
					} elseif($this->data['User']['type'] == 'N') {	
						//fees cannot be added from here
						unset($this->Notary->validate['fees']);
						$this->data['Notary']['user_id'] = $this->User->id;
	/*
						$count = count($this->data['Notary']['zipcode']);
						for($i=1;$i<=$count;$i++) {
							if($this->data['Notary']['zipcode'][$i-1] != '') {
								$zip[].= $this->data['Notary']['zipcode'][$i-1];
							}
						}
						if($count and isset($zip)){
							$this->data['Notary']['zipcode'] = implode("|",$zip);
							unset($this->Notary->validate['zipcode']);
						} else {
							$this->data['Notary']['zipcode'] = "";
						}
				   		if(isset($this->data['Notary']['notarytype']) && $this->data['Notary']['notarytype'] =='P') {
							$this->data['Notary']['userstatus'] = 'P';
							$pays = $this->data['Notary']['payment'];
							$payamt = explode("|", $pays);
							$duration = $payamt['1'];
						 	$pay = $payamt['0'];
							if($duration == 'month'){
								$todayDate = date("Y-m-d"); // current date
								$dateOneMonthAdded = strtotime(date("Y-m-d", strtotime($todayDate)) . "+1 month");
                        		$date_end = date('Y-m-d', $dateOneMonthAdded);
								$this->data['Notary']['enddate'] = $date_end;
							} 
							if($duration == 'year'){ 
								$currentDate = date("Y-m-d"); // current date
								$dateOneYearAdded = strtotime(date("Y-m-d", strtotime($currentDate)) . " +1 year");
								$date_end = date('Y-m-d', $dateOneYearAdded);
								$this->data['Notary']['enddate'] = $date_end;
							}
						} */
							
/* 							$this->data['Notary']['fax'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['fax1'],$this->data['Notary']['fax2'],$this->data['Notary']['fax3']));

						if($this->data['Notary']['expiration'] <> ""  && $this->data['Notary']['expiration'] <> "0000-00-00"){
							$date = explode("-", $this->data['Notary']['expiration']);
							$this->data['Notary']['expiration'] = $date[2]."-".$date[0]."-".$date[1];
			   			}
 */	
 
						$experienceFields = $this->_experienceoptions();
						$newArray = array_keys($experienceFields);
						$experienceString = "";
						foreach ($_POST["experience"] as &$value) 
						{
							$experienceString .= $newArray[$value] . ",";
						}
						$this->data['Notary']['experience'] = $experienceString;
						
						$dayoptions = array_keys($this->_dayoptions());
						$concatString = "";
						foreach ($_POST["availabledays"] as &$value) 
						{
							$concatString .= $dayoptions[$value] . ",";
						}
						$this->data['Notary']['days_available'] = $concatString;
						
						$timeOptions = array_keys($this->_timeoptions());
						$concatString = "";
						foreach ($_POST["time_available"] as &$value) 
						{
							$concatString .= $timeOptions[$value] . ",";
						}
						$this->data['Notary']['time_available'] = $concatString;
						
						$approvedTitleFields = $this->_approvesoptions();
						$newArray = array_keys($approvedTitleFields);
						$approvedTitleString = "";
						foreach ($_POST["approved_titles"] as &$value) 
						{
							$approvedTitleString .= $newArray[$value] . ",";
						}
						$this->data['Notary']['approved_titles'] = $approvedTitleString;
							
						$languages = array_keys($this->_langoptions());
						$concatString = "";
						foreach ($_POST["languages"] as &$value) 
						{
							$concatString .= $languages[$value] . "|";
						}
						$this->data['Notary']['languages'] = $concatString;
													
						$this->data['Notary']['cell_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['cell_phone1'],$this->data['Notary']['cell_phone2'],$this->data['Notary']['cell_phone3']));
						$this->data['Notary']['day_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['day_phone1'],$this->data['Notary']['day_phone2'],$this->data['Notary']['day_phone3']));
						$this->data['Notary']['evening_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['evening_phone1'],$this->data['Notary']['evening_phone2'],$this->data['Notary']['evening_phone3']));

						$this->data['Notary']['expiration'] = '0000-00-00';
						$this->data['Notary']['enddate'] = '0000-00-00';
						unset($this->Notary->validate['zipcode']);
						$this->data['Notary']['zipcode'] = "";
						$this->data['Notary']['fax'] = "";
															
						$this->data['Notary']['p_address'] = $this->data['Notary']['dd_address'];
						$this->data['Notary']['p_city'] = $this->data['Notary']['dd_city'];
						$this->data['Notary']['p_state'] = $this->data['Notary']['dd_state'];
						$this->data['Notary']['p_zip'] = $this->data['Notary']['dd_zip'];
											
						
						$this->data['Notary']['twitter'] = "";
						$this->data['Notary']['commission'] = "0";
						$this->data['Notary']['year'] = "";
						$this->data['Notary']['print'] = "";
						$this->data['Notary']['esigning'] = "";
						$this->data['Notary']['wireless_card'] = "";
						$this->data['Notary']['work_with'] = "";
						$this->data['Notary']['how_hear'] = "";
						$this->data['Notary']['how_hear_ref'] = "";
						$this->data['Notary']['paid'] = "";
						$this->data['Notary']['payment'] = "";
	
	
						//$this->data['Notary']['agree_nna'] = 0;
						//$this->data['Notary']['claims_against'] = 0;
						//$this->data['Notary']['convicted_misdemeanor'] = 0;
						
						
						
						$det = $this->User->Notary->save($this->data);
						if(!$det) {
							$this->set('error_messages', $this->User->Notary->validationErrors);
							$this->Session->setFlash(''.$tm.' could not be saved. Please, try again.','error',array('display'=>'error'));	
						} else {
							/* Send mail to notaryregister@1hoursignings.com */
							$this->_sendNewMail(array('to'=>'notaryregister@1hoursignings.net', 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - New registration', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'newregistration', 'sendas'=>'html'));
						}
						$cid = $this->Notary->id;
					}
					if (!empty($det)) {
		                if(isset($pay) && $pay <> ""){
		                	$paymentdetails = array('pay'=>$pay,'cid'=>$cid);
		                	$this->Session->write('payment', $paymentdetails);
							$this->redirect(array('action'=>'accountpayment'));
						} else {
							if(isset($this->data['Notary']['notarytype']) && $this->data['Notary']['notarytype'] == 'B') {
								$this->_sendNewMail(array('to'=>$this->data['User']['username'],'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - New notary registration', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'emailverificationunpaid', 'sendas'=>'html'));
								$this->Session->setFlash('A '.Configure::read('sitename').' representative will contact you to verify your registration','error',array('display'=>'success'));
								$this->redirect(array('action'=>'login'));			
							} else {
								$this->set('shipoptions', $this->_shippingcarrier());
								$this->_sendNewMail(array('to'=>$this->data['User']['username'], 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - New account confirmation', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'emailverification', 'sendas'=>'html'));
								$this->Session->setFlash('A '.Configure::read('sitename').' representative will contact you to confirm your registration details ','error',array('display'=>'success'));
								$this->redirect(array('action'=>'login'));
							}
						}
					} else {
						$this->User->delete($this->User->id);
					} 
				} else {
					$this->set('error_messages', $this->User->validationErrors);
					$this->Session->setFlash('The user could not be registered. Please, try again.','error',array('display'=>'error'));
				}
			}
		}
		$this->loadModel('Contentpage');
		if($this->params['who'] == 'client') {
			$cid = '23';
		} elseif($this->params['who'] == 'beginner') {
			$cid = '24';
		} elseif($this->params['who'] == 'professional') {
			$cid = '25';
		}
		$pagecontent = $this->Contentpage->find('first', array('conditions'=>array('id'=>@$cid, 'status'=>1)));
		$this->set('contentpage', $pagecontent);
		$this->set('title_for_layout', $pagecontent['Contentpage']['pagetitle']);
		$this->set('payoptions', $this->_payOptions());
		$this->set('statusoptions', $this->_statusOptions());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('shipoptions', $this->_shipoptions());
		$this->set('hearoptions', $this->_hearoptions());
		$this->set('states', $this->_stateoptions());
		$this->set('notifyoptions', $this->_notifyVia());
		$this->set('langoptions', $this->_langoptions());
		$this->set('experienceoptions', $this->_experienceoptions());
		$this->set('dayoptions', $this->_dayoptions());
		$this->set('approvesoptions', $this->_approvesoptions());
		$this->set('timeoptions', $this->_timeoptions());
		$this->set('cnt_total', 1);
		$this->set('clientscdata',$this->_shippingcarrier());
	}
	
	function getSelectedItems($data) {
		$return = array();
		foreach ($data as $row) {
			$return[$row['name']] = $row['id'];
		}
		return $return;
	}
	
	function accountpayment() {
		$paymentdetails = $this->Session->read('payment');
		if(!$paymentdetails['cid']) {
			$this->Session->delete('payment');
			$this->Session->setFlash('The notary could not be registered. Please, try again.','error',array('display'=>'error'));
			$this->redirect(array('controller'=>'users','action'=>'signup','type'=>Inflector::slug('join our professional network'),'who'=>'professional'));			
		}
		$val = $paymentdetails['pay'];
		$cid = $paymentdetails['cid'];
		
	 	$value = Configure::read('currency').$val;
	 	$payment_path_success = Configure::read('WEB_URL').'users/successpayment/'.$cid ;
		$payment_path_decline = Configure::read('WEB_URL').'users/paymentdecline' ;
		$productsname = "";
		$count = 1 ;
		$paypalitems  = "" ;
		$paypalitems .= "<input type=\"hidden\" name=\"item_name_".$count."\" value=\"".$value."\">
	                     <input type=\"hidden\" name=\"item_number_".$count."\" value=\"".$count."\">
	                     <input type=\"hidden\" name=\"amount_".$count."\" value=\"".$val."\">" ;
       	$payment_form = "<form name=\"accountbuy\" action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_self\">
              				<input type=\"hidden\" name=\"business\" value=\"1hns_1311231476_biz@interberry.com\">
              				<input type=\"hidden\" name=\"charset\" value=\"utf-8\">
              				<input type=\"hidden\" name=\"upload\" value=\"1\">                      				
              				".$paypalitems."                      				
              				<input type=\"hidden\" name=\"cancel_return\" value=\"".$payment_path_decline."\">
		    				<input type=\"hidden\" name=\"custom\" value=\"".$cid."\">
							<input type=\"hidden\" name=\"cbt\" value=\"Complete Your Registration\">
              				<input type=\"hidden\" name=\"rm\" value=\"2\">
              				<input type=\"hidden\" name=\"return\" value=\"".$payment_path_success."\">				
              				<input type=\"hidden\" name=\"cmd\" value=\"_cart\">
              				<input type=\"hidden\" name=\"currency_code\" value=\"USD\">
              				<input type=\"hidden\" name=\"no_shipping\" value=\"1\">
              				<input type=\"hidden\" name=\"no_note\" value=\"1\">    		
              				<input type=\"hidden\" name=\"lc\" value=\"C2\">
              				<input type=\"hidden\" name=\"bn\" value=\"PP-BuyNowBF\">
              				</form>
              				<div style=\"display:none\"> ".Configure::read('sitename')." </div>
                          <script>document.accountbuy.submit();</script>";
		echo $payment_form;	
	}
			
	function successpayment($id=null){
     	$data = array('Notary'=>array('id'=>$id,'paid'=>'yes'));
       	$this->Notary->save($data, false, array('paid') );
        $cDetail = $this->Notary->find('first', array('recursive'=>0,'conditions'=>array('Notary.id'=>$id)));
        $this->Session->delete('payment');
        $this->set('mailcdata', $cDetail);
        
		/*
		*	Send the confirmation mail
		*/
		$this->_sendNewMail(array('to'=>$cDetail['Notary']['email'], 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - New notary registration', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'emailverificationpaid', 'sendas'=>'html'));
		$this->Session->setFlash('Payment successfull. Check your email and follow the instructions to verify your account','error',array('display'=>'success'));
		$this->redirect(array('action'=>'login'));  
	}
	
	function paymentdecline(){
		$this->Session->delete('payment');
		$this->Session->setFlash('Payment declined!','error',array('display'=>'error'));
		$this->redirect(array('controller'=>'users','action'=>'signup','type'=>Inflector::slug('join our professional network'),'who'=>'professional'));  
	}
	
	/************************************* 
	* User profile updation
	* modified by Renjith Chacko
 	**************************************/
	function edit() {

		$user_data = $this->_checkPermission();
		$usertypes = $this->whichtypeuser();
	   	$id = ($user_data['Notary']['id'] == '') ? $user_data['Client']['id'] : $user_data['Notary']['id'];
		$type = low($usertypes[$user_data['User']['type']]);
		if (!empty($this->data)) {
			if($user_data['User']['type']=='C') { //IF CLIENT
				$this->data['Client']['company_phone'] = $this->Miscellaneous->formatphone(array($this->data['Client']['company_phone1'],$this->data['Client']['company_phone2'],$this->data['Client']['company_phone3']));
				$this->data['Client']['company_fax'] = $this->Miscellaneous->formatphone(array($this->data['Client']['company_fax1'],$this->data['Client']['company_fax2'],$this->data['Client']['company_fax3']));
				$this->data['Client']['id'] = $id;
				unset($this->Client->validate['fees']);	
				if($this->Client->save($this->data['Client'])) {
					$this->Session->setFlash('The client details has been updated.','error',array('display'=>'success'));
					$this->redirect(array('controller'=>'users','action'=>'myaccount','type'=>$type));
				} else {
					$this->set('error_messages', $this->User->Client->validationErrors);
					$this->Session->setFlash('The client details could not be updated. Please, try again.','error',array('display'=>'error'));
				}
			} elseif($user_data['User']['type'] == 'N') { //IF NOTARY		
				$count = count($this->data['Notary']['zipcode']);
				for($i=0;$i<=$count;$i++) {
					if(@$this->data['Notary']['zipcode'][$i] != '') {
						$zip[].= @$this->data['Notary']['zipcode'][$i];
					}
					unset($this->Notary->validate['zipcode']);
				}
				$this->data['Notary']['zipcode'] = implode("|",$zip);
				
				$language = implode("|",$this->data['Notary']['languages']);
				$this->data['Notary']['languages']=$language;
													
				$this->data['Notary']['evening_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['evening_phone1'],$this->data['Notary']['evening_phone2'],$this->data['Notary']['evening_phone3']));
				$this->data['Notary']['day_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['day_phone1'],$this->data['Notary']['day_phone2'],$this->data['Notary']['day_phone3']));
				$this->data['Notary']['cell_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['cell_phone1'],$this->data['Notary']['cell_phone2'],$this->data['Notary']['cell_phone3']));
				$this->data['Notary']['fax'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['fax1'],$this->data['Notary']['fax2'],$this->data['Notary']['fax3']));	
				if($this->data['Notary']['expiration'] <> ""  && $this->data['Notary']['expiration'] <> "0000-00-00"){
					$date = explode("-", $this->data['Notary']['expiration']);
					$this->data['Notary']['expiration'] = $date[2]."-".$date[0]."-".$date[1];
	   			}
				$this->data['Notary']['id'] = $id;
				unset($this->Notary->validate['fees']);
				
				if($this->Notary->save($this->data['Notary'])) {
					if(isset($this->data['Notary']['fees']) and $this->data['Notary']['fees'] != "" and $this->data['Notary']['fees'] != $user_data['Notary']['fees']){
						//upon fees update, insert prev fees into history
						$this->HistoryFees->create();
						$hfees['HistoryFees']['user_id'] = $id;
						$hfees['HistoryFees']['fees'] = $this->data['Notary']['fees'];
						$this->HistoryFees->save($hfees);
					}
					$this->Session->setFlash('The notary details has been updated.','error',array('display'=>'success'));
					$this->redirect(array('controller'=>'users','action'=>'myaccount','type'=>$type));
				} else {
					$this->set('error_messages', $this->User->Notary->validationErrors);
					$this->Session->setFlash('The notary details could not be updated. Please, try again.','error',array('display'=>'error'));
				}
			} else {
				$this->Session->setFlash('Personal Information could not be saved ','error',array('display'=>'error'));
				$this->redirect(array('controller'=>'users','action'=>'myaccount','type'=>$type));
			}
		}
		if (empty($this->data)) {
			if($user_data['User']['type']=="N") {
				$this->data = $this->Notary->find('first', array('fields'=>array('Notary.id','Notary.first_name','Notary.last_name','Notary.cell_phone', 'Notary.day_phone', 'Notary.evening_phone', 'Notary.fax' , 'Notary.dd_address', 'Notary.dd_state', 'Notary.dd_city', 'Notary.dd_zip', 'Notary.p_address', 'Notary.p_city', 'Notary.p_state', 'Notary.p_zip', 'Notary.twitter', 'Notary.commission', 'Notary.expiration','Notary.year', 'Notary.email', 'Notary.zipcode', 'Notary.notify','Notary.print', 'Notary.esigning', 'Notary.wireless_card', 'Notary.work_with', 'Notary.how_hear' ,'Notary.how_hear_ref' ,'Notary.paid', 'Notary.fees' ,'Notary.payment' ,'Notary.userstatus' ,'Notary.enddate' ,'Notary.created' ,'Notary.modified','Notary.languages'),'conditions'=>array('Notary.id'=>$id)));
			} else {
				$this->data = $this->Client->find('first', array('fields'=>array('Client.id','Client.first_name','Client.last_name','Client.company','Client.division','Client.of_street_address','Client.of_city','Client.of_state','Client.of_zip','Client.email','Client.company_phone','Client.company_fax','Client.shipping_carrier','Client.shipping_account','Client.rd_street_address','Client.rd_city','Client.rd_state','Client.rd_zip','Client.shipping_carrier_other'),'conditions'=>array('Client.id'=>$id)));
			}
		}
		if(isset($this->data['Notary']['languages']) and $this->data['Notary']['languages']<>""){
			$lang = explode("|", $this->data['Notary']['languages']);
			$this->set('selectedLang', $lang);
		} else {
			$this->set('selectedLang', '');
		}
		$this->set('title_for_layout', 'Update My Account');
		$this->set('payoptions', $this->_payOptions());
		$this->set('statusoptions', $this->_statusOptions());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('hearoptions', $this->_hearoptions());
		$this->set('paidoptions', $this->_paidoptns());
		$this->set('langoptions', $this->_langoptions());
		$this->set('states', $this->_stateoptions());
		$this->set('clientscdata',$this->_shippingcarrier());
		$this->set('notifyoptions', $this->_notifyVia());
	}
	
	/************************************* 
	* User password reset
	* Renjith Chacko
 	**************************************/
	function changepassword() {
	    $user_data = $this->_checkPermission();
	    $usertype = ($user_data['Client']['id']!='') ? 'Client' : 'Notary';
		if (!empty($this->data)) {
			$this->data['User']['id'] = $user_data['User']['id'];
			$user_exists = $this->User->find('first',array('conditions'=>array('User.id'=>$user_data['User']['id'])));
        	$this->data['User']['currentpassword'] = md5($this->data['User']['currentpassword']);
        	$this->set('changeduserdata', array('name'=>$user_data[$usertype]['first_name'].' '.$user_data[$usertype]['last_name'], 'password'=>$this->data['User']['password']));
        	$this->data['User']['password'] = md5($this->data['User']['password']);
			if($user_exists['User']['password'] == $this->data['User']['currentpassword']) {
				unset($this->User->validate['username']);
				if ($this->User->save($this->data)) {
					$this->_sendNewMail(array('to'=>$user_data[$usertype]['email'], 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - Password reset', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'resetpassword', 'sendas'=>'html'));
					$this->Session->setFlash('The Settings has been changed successfully. Please check your mail','error',array('display'=>'success'));
					$this->redirect(array('action'=>'myaccount'));
				} else {
					$this->set('error_messages', $this->User->validationErrors);
					$this->Session->setFlash('The Settings could not be saved. Please, try again.','error',array('display'=>'error'));
				}
			} else {
				$this->set('error_messages', array('mismatch'=>'Please enter the current password'));
				$this->Session->setFlash('The Settings could not be saved. Please, try again.','error',array('display'=>'error'));
			}
		}
		$this->set('title_for_layout',Inflector::humanize('Change password'));
	}
	
	/* User login	*/
	function login(){
		if($this->Session->check('WUBSSEWR')) {
			$user_data = $this->_checkPermission();
			$usertype = $user_data['User']['type']=='C' ? 'clients' : 'notaries';
			$this->redirect(array('action'=>'myaccount', 'type'=>$usertype));
		}				
		$this->set('title_for_layout', 'Login');
		// redirect user if already logged in
		if(!empty($this->data)) {				
			if(($this->data['User']['username'] == '') || ($this->data['User']['password'] == '')) {
				$this->Session->setFlash('Username or password missing!', 'error', array('display'=>'warning'));
			} else {
				// see if the data validates
				$result = $this->check_login_data($this->data);
				$flag = 1;
				if($result['User']['type'] == 'N'){
					$date = date("Y-m-d");
					$enddate = date("Y-m-d", strtotime($result['Notary']['enddate']));
					$expirydate = date("Y-m-d", strtotime($result['Notary']['expiration']));
					//if current date exceeds the agreed date of registration (1 month/1 year)
					if($result['Notary']['userstatus'] == 'P' and $date > $enddate) { 
						$flag = 0;
					}
					//if current date exceeds the expiration date
					if($date > $expirydate) {
						$expirydate;
						$flag = 0;
					}
				}
				if($result['User']['type'] == 'N' && isset($result['Notary']['mistakes']) &&  $result['Notary']['mistakes'] == '3') {
					$flag=0;
				}
				if($result !== false && $flag==1) {
					$this->Session->write('WUBSSEWR', $result);
					$this->Session->setFlash('You have successfully signed in','error',array('display'=>'success'));
					$usertype = $this->whichtypeuser();
					$this->redirect(array('action'=>'myaccount','type'=>low($usertype[$result['User']['type']])));
				} else {
					if($flag == 0){
						$this->Session->setFlash('Your account expired, Please contact administrator.', 'error', array('display'=>'warning'));	
					} else {
						$this->Session->setFlash('Login details incorrect!', 'error', array('display'=>'error'));
					}
				}
			}
		}
		$this->loadModel('Contentpage');
		$this->set('content', $this->Contentpage->find('first', array('fields'=>'content', 'conditions'=>array('id'=>'16', 'status'=>1))));
	}
	
	/* Reset the password	*/
	function forgotpassword(){	
		$this->set('title_for_layout', 'Forgot Password');
		if (!empty($this->data)) {
			if($this->data['User']['email'] != '') {
				$em = $this->data['User']['email'];
				$this->User->Behaviors->attach('Containable');
				$uresult = $this->User->find('first', array('contain'=>array('Notary','Client'),'conditions'=>array('User.username'=>$em, 'User.status'=>'1')));
				if(!$uresult) {
					$this->Session->setFlash('Email not found, Please try again.','error', array('display'=>'error'));
					$this->redirect(array('controller'=>'users', 'action'=>'forgotpassword'));
				}
				$inputs = array_merge(range('z','a'), range('A','Z'), range(0,9));
				$newpwd = "";
				for($i=0; $i<7; $i++) {
					$newpwd .= $inputs{mt_rand(0, 61)};
				}	
				$fpresult['User']['dtype'] = $this->whichtypeuser($uresult['User']['type']);	
				$fpresult['User']['newpassword'] = $newpwd;	
				$fpresult['User']['name'] = ($uresult['User']['type']=='N') ? $uresult['Notary']['first_name'].' '. $uresult['Notary']['last_name'] : $uresult['Client']['first_name'].' '. $uresult['Client']['last_name'];
				if($uresult) {
					$this->set('forgotpassworddata', $fpresult);
					$this->_sendNewMail(array('to'=>$em, 'cc'=>'', 'bcc'=>'', 'subject'=>Configure::read('sitename').' - Forgot password', 'replyto'=>Configure::read('replyemail'), 'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'forgotpassword', 'sendas'=>'html'));
					$this->User->Query("UPDATE users SET password = '".md5($newpwd)."' WHERE id = ".$uresult['User']['id']);				
					$this->Session->setFlash('The new password has been sent to your email address.','error', array('display'=>'success'));
					$this->redirect(array('controller'=>'users', 'action'=>'login'));
				} else {
					$this->Session->setFlash('Email not found, Please try again.','error', array('display'=>'error'));
					$this->redirect(array('controller'=>'users', 'action'=>'forgotpassword'));
				}
			} else {
				$this->Session->setFlash('Email not found, Please try again.','error', array('display'=>'error'));
				$this->redirect(array('controller'=>'users', 'action'=>'forgotpassword'));
			}
		} 
	}
	
	function check_login_data($data) {	
		// init
		$return = FALSE;
		// find user with passed username
		$this->User->Behaviors->attach('Containable');
		$login_data = $this->User->find('first', array('fields'=>array('User.id','User.username','User.type','Client.id','Client.first_name','Client.last_name','Client.email','Notary.id','Notary.user_id','Notary.first_name','Notary.last_name','Notary.userstatus','Notary.expiration','Notary.enddate','Notary.email','Notary.fees','Notary.mistakes'),'contain'=>array('Client','Notary'),'conditions'=>array('User.status'=>'1','User.username'=>$data['User']['username'],'User.password'=>md5($data['User']['password']))));
		
		
		// not found
		if(!empty($login_data)) {					
			$return = $login_data;
		}
		return $return;
	}
	
	function logout() {
		$this->_checkPermission();
		if($this->Session->check('WUBSSEWR')) {			
			/* Delete the login session */
			$this->Session->delete('WUBSSEWR');				
		}		
		$this->Session->setFlash('You have successfully signed out','error',array('display'=>'success'));
		$this->redirect(array('action'=>'login'));		
	}
	
	function myaccount() {
		$this->_checkPermission();
		$this->User->recursive = -2;
		$this->set('title_for_layout', 'Dashboard');
	}
	
	function verify($id){
		$this->layout = null;
		$this->User->Behaviors->attach('Containable'); 
		$reguser = $this->User->find('first',array('conditions'=>array('randkey'=>$id),'fields'=>array('User.id','User.username','User.password','User.type')));
		if($reguser) {
			$this->User->id = $reguser['User']['id'];
			unset($this->User->validate['username']);
			unset($this->User->validate['password']);
			unset($this->User->validate['confirmpassword']);
	        /* Needs to be get approved from the Administrator */
			$this->data['User']['randkey'] = '';
			$this->User->save($this->data);
			
			$utype = $reguser['User']['type'];
			if ($utype == 'C') {
				$ty = 'clients'; $tm = 'Client';
				$user = $this->User->Client->find('first',array('conditions'=>array('Client.user_id'=>$reguser['User']['id']),'fields'=>array('Client.email')));
				 $em = $user['Client']['email'];
			} else { 
				$ty = 'notaries'; $tm = 'Notary';
				$user = $this->Notary->find('first',array('conditions'=>array('Notary.user_id'=>$reguser['User']['id']),'fields'=>array('Notary.email')));
				 $em = $user['Notary']['email'];
			 }

			$this->Session->setFlash('Your account has been verified.','error',array('display'=>'success'));
		
			$this->redirect(array('action'=>'login'));
		} else {
			$this->Session->setFlash('Your account is already verified.','error', array('display'=>'error'));
			$this->redirect(array('action'=>'login'));
		}
	}
	
	/* _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/ ADMIN AREA _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/ */
	function admin_index() {
		$type = isset($this->params['type']) == '' ? $this->params['named']['type'] : $this->params['type'];
		//escaping from the initial search session
		if(!empty($this->params['page']) and intval($this->params['page']) <=0) {
			if(isset($_SESSION['search'])) unset($_SESSION['search']);
			$this->redirect(array('type'=>$type,'action'=>'index'));
		}
		
		if((isset($this->params['type']) && $this->params['type']<>"") or (isset($this->params['named']['type']) && $this->params['named']['type']<>"")) {
			$type = isset($this->params['type'])=='' ? $this->params['named']['type'] :$this->params['type'];
			if($type=='clients') {
				$tm = 'Client';
				$condition[] = array('User.type'=>'C');
				$containmodels = array('Client');
				$fields = array('User.id','User.username','User.status','User.created','Client.first_name','Client.last_name','Client.company','Client.of_zip','Client.created');
			} else {
				$tm = 'Notary';
				$condition[] = array('User.type'=>'N');
				$containmodels = array('Notary');
				$fields = array('User.id','User.username','User.status','User.created','Notary.first_name','Notary.last_name','Notary.userstatus','Notary.zipcode','Notary.dd_zip','Notary.created');
				$this->set('notaryoptions', $this->_notaryoptions());
			}
		}
		
		if(isset($_SESSION['search']['condition']) and !empty($_SESSION['search']['condition'])) {
			$condition[] = array(implode(' AND ', @$_SESSION['search']['condition']));
		}
		$this->User->Behaviors->attach('Containable');
		$this->paginate = array('contain'=>$containmodels, 'conditions'=>@$condition, 'order'=>'User.created DESC', 'fields'=>$fields);
		$this->set('users', $this->paginate('User'));
		$this->set('statusoptions', $this->_statusOptions());
		$this->set('yesnooptions', $this->_ynoptns());
		$this->set('usertype', $type);
		$this->set('usermodel', $tm);
		$this->set('statusoptns', $this->_statusOptions('p'));
		$this->set('states', $this->_stateoptions());
		$this->set('langoptions', $this->_langoptions());
	}
	
	function admin_view() {
		$id = $this->params['id'];
		if (!$id) {
			$this->Session->setFlash('Invalid user','error',array('display'=>'success'));
			$this->redirect(array('action'=>'index'));
		}
		$type = $this->params['type'];
		if($type == 'clients') {
			$users = $this->Client->find('first',array('conditions'=>array('Client.user_id'=>$id),'fields'=>array('Client.id')));	
			$this->set('model', 'Client');
			$this->set('type', 'clients');
			
			$creq = $this->ClientRequirements->find('all', array('conditions'=>array('ClientRequirements.user_id'=>$id)));
			$this->set('creqs', $creq);
			
			$this->set('user', $this->Client->read(null, $users['Client']['id']));
			$orders = $this->Order->find('all', array(
			 'fields' => array('Order.id','Order.orderstatus_id','Order.first_name','Order.last_name','Order.date_signing','Order.sa_state', 'Order.sa_city', 'Order.user_id', 'Order.track_shipping_info','Order.tracking_no', 'Order.attended_by','Order.file', 'Order.created','Order.modified'),
			 'conditions' => array('Order.user_id' => $id),
			 'recursive' => 0
			 ));
			
			 $this->set('orders', $orders);
			 
		} else {
			$users = $this->Notary->find('first',array('conditions'=>array('Notary.user_id'=>$id),'fields'=>array('Notary.id')));	
			$this->set('model', 'Notary');
			$this->set('type', 'notaries');
			$this->set('user', $this->Notary->read(null, $users['Notary']['id']));
			
			// view orders assigned to notary
			$allAssg = $this->Assignment->find('all', array('order'=>'Assignment.created DESC','fields' => array('Assignment.id','Assignment.created','Assignment.order_id','Assignment.user_id','Assignment.details','Order.id', 'Order.user_id', 'Order.first_name', 'Order.last_name', 'Order.orderstatus_id'),'conditions' => array('Assignment.user_id' => $id,'Assignment.status' =>'A'),'recursive' => 0));
			
			$this->set('assignments', $allAssg);
		}
		$fees = $this->HistoryFees->find('all',array('order'=>array('HistoryFees.created DESC'),'conditions'=>array('HistoryFees.user_id'=>$id),'fields'=>array('HistoryFees.id','HistoryFees.fees','HistoryFees.created')));
		$this->set('history', $fees);
		$this->set('usertype', $type);	
		$this->set('statusoptions', $this->_statusOptions());

		$this->set('statusoptns', $this->_statusOptions('p'));
		$this->set('notaryoptions', $this->_notaryoptions());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('hearoptions', $this->_hearoptions());
		$this->set('notifyoptions', $this->_notifyVia());
		$this->set('langoptions', $this->_langoptions());
		$this->set('clientscdata',$this->_shippingcarrier());
	}
	
	function send_notary_to_quickbooks($notaryData)
	{
		$url = 'https://hooks.zapier.com/hooks/catch/1734225/t17air/';
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/application/json",
				'method'  => 'POST',
				'content' => '{"GivenName": "' . $notaryData["first_name"] . '", "FamilyName": "' . $notaryData["last_name"] . '", "PrimaryEmailAddr": "' . $notaryData["email"] . '", "Mobile" :"' . $notaryData["cell_phone"] . '", "BillAddr" : {"CountrySubDivisionCode": "' . $notaryData["p_state"] . '", "City": "' . $notaryData["p_city"] . '", "PostalCode" : "' . $notaryData["p_zip"] . '", "Line1" : "' . $notaryData["p_address"] . '"}, "TermRef" : "2", "Vendor1099" : true, "Active": true }'
			)
		);
				
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
	}
	
	function send_client_to_quickbooks($clientData)
	{
		$url = 'https://hooks.zapier.com/hooks/catch/1734225/t17auf/';		
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/application/json",
				'method'  => 'POST',
				'content' => '{"CompanyName" :  "' . $clientData["company"] . '" , "GivenName": "' . $clientData["first_name"] . '", "FamilyName": "' . $clientData["last_name"] . '", "PrimaryEmailAddr": "' . $clientData["email"] . '", "PrimaryPhone" :"' . $clientData["company_phone"] . '", "BillAddr" : {"CountrySubDivisionCode": "' . $clientData["of_state"] . '", "City": "' . $clientData["of_city"] . '", "PostalCode" : "' . $clientData["of_zip"] . '", "Line1" : "' . $clientData["of_street_address"] . '"},  "ShipAddr" : {"CountrySubDivisionCode": "' . $clientData["rd_state"] . '", "City": "' . $clientData["rd_city"] . '", "PostalCode" : "' . $clientData["rd_zip"] . '", "Line1" : "' . $clientData["rd_street_address"] . '"}, "SalesTermRef" : "5" , "CurrencyRef" : { "name" : "United States Dollar", "value" : "USD"  } , "Active" : true       }'
			)
		);
				
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
	}
	
	
	function admin_add() {

		if(isset($this->params['type']) && $this->params['type']!=""){
			$type = $this->params['type'];
		}
		
		if (!empty($this->data)) {
			/* Random key for confirmation mail */
			$inputs = array_merge(range('z','a'), range(0,9), range('A','Z'));
			$randkey = "";
			for($i=0; $i<32; $i++){
				$randkey .= $inputs{mt_rand(0,61)};
			}
           	if($this->data['User']['confirmpassword']) {$this->data['User']['password'] = md5($this->data['User']['confirmpassword']);} else {$this->data['User']['password'] = ''; }
			$this->data['User']['randkey'] = $randkey;
			if ((!empty($this->data['Client']) or !empty($this->data['Notary'])) ) {
				$this->User->create();
				if(isset($this->data['Client']) and !empty($this->data['Client']) ) {
					$type = 'clients';
					$this->data['User']['type'] = 'C';
				} else {
					$type = 'notaries';
					$this->data['User']['type'] = 'N';
				}
				$userdata['User'] = $this->data['User'];
				unset($userdata['User']['confirmpassword']);
				$emailexists = $this->User->findByUsername($this->data['User']['username']);
				if($emailexists) {
					$this->set('error_messages', $this->User->validationErrors);
					$this->Session->setFlash('The email address already exists.','error',array('display'=>'error'));
				} elseif($this->User->save($userdata)) {
					if($type == 'clients') {	
						$this->data['Client']['company_phone'] = $this->Miscellaneous->formatphone(array($this->data['Client']['company_phone1'],$this->data['Client']['company_phone2'],$this->data['Client']['company_phone3']));
						$this->data['Client']['company_fax'] = $this->Miscellaneous->formatphone(array($this->data['Client']['company_fax1'],$this->data['Client']['company_fax2'],$this->data['Client']['company_fax3']));
						$this->data['Client']['user_id'] = $this->User->id;
			
						$isadded = $this->User->Client->save($this->data);
						if(!$isadded) {	
							$this->set('error_messages', $this->User->Client->validationErrors);
							$this->Session->setFlash('The '.Inflector::singularize($type).' could not be saved. Please, try again.', 'error', array('display'=>'error'));
						} 
						else 
						{					
							$this->send_client_to_quickbooks( $this->data['Client']);
							$total = count($this->data['ClientRequirements']['requirements']);
						    for($i=0;$i<$total;$i++) {
								$this->ClientRequirements->create();
							 	$creq['ClientRequirements']['user_id'] = $this->User->id;
								$creq['ClientRequirements']['requirements'] = $this->data['ClientRequirements']['requirements'][$i];
								$this->ClientRequirements->save($creq);
						    }						
						}
					} elseif($type == 'notaries') {	
						$count = count($this->data['Notary']['zipcode']);
						$this->data['Notary']['evening_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['evening_phone1'],$this->data['Notary']['evening_phone2'],$this->data['Notary']['evening_phone3']));
						$this->data['Notary']['day_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['day_phone1'],$this->data['Notary']['day_phone2'],$this->data['Notary']['day_phone3']));
						$this->data['Notary']['cell_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['cell_phone1'],$this->data['Notary']['cell_phone2'],$this->data['Notary']['cell_phone3']));
						$this->data['Notary']['fax'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['fax1'],$this->data['Notary']['fax2'],$this->data['Notary']['fax3']));
						$this->data['Notary']['user_id'] = $this->User->id;
						for($i=1;$i<=$count;$i++) {
							if($this->data['Notary']['zipcode'][$i-1] != '') {
								$zip[].= $this->data['Notary']['zipcode'][$i-1];
							}
						}
						if($count and isset($zip)){
							$this->data['Notary']['zipcode'] = implode("|",$zip);
							unset($this->Notary->validate['zipcode']);
						} else {
							$this->data['Notary']['zipcode'] = "";
						}
						if($this->data['Notary']['languages']<>""){
		   					$language = implode("|",$this->data['Notary']['languages']);
							$this->data['Notary']['languages'] = $language;
						}
						if($this->data['Notary']['expiration'] <> ""  && $this->data['Notary']['expiration'] <> "0000-00-00"){
							$date = explode("-", $this->data['Notary']['expiration']);
							$this->data['Notary']['expiration'] = $date[2]."-".$date[0]."-".$date[1];
			   			}
			   			if($this->data['Notary']['enddate'] <> ""  && $this->data['Notary']['enddate'] <> "0000-00-00"){
							$edate = explode("-", $this->data['Notary']['enddate']);
							$this->data['Notary']['enddate'] = $edate[2]."-".$edate[0]."-".$edate[1];
			   			}
						

						$isadded = $this->User->Notary->save($this->data);
			   			if(!$isadded) {
			   				$this->set('error_messages', $this->User->Notary->validationErrors);
							$this->Session->setFlash('The '.Inflector::singularize($type).' could not be saved. Please, try again.','error',array('display'=>'error'));	
			   			}
						else
						{
							$this->send_notary_to_quickbooks( $this->data['Notary']);
						}
						
						
					}
					if (!empty($isadded)){
						$this->Session->setFlash('The '.Inflector::singularize($type).' has been saved','error',array('display'=>'success'));
						$this->redirect(array('controller'=>'users', 'action'=>'index', 'type'=>$type));
						exit;
					} else {
						$this->User->delete($this->User->id);
					}
				} else {
					$this->set('error_messages', $this->User->validationErrors);
					$this->Session->setFlash('The '.Inflector::singularize($type).' could not be saved. Please, try again.','error',array('display'=>'error'));	
				}
			}
		} 
		$this->set('usertype', $type);	
		$this->set('statusoptions', $this->_statusOptions());
		$this->set('statusoptns', $this->_statusOptions('p'));
		$this->set('notaryoptions', $this->_notaryoptions());
		$this->set('payoptions', $this->_payOptions());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('hearoptions', $this->_hearoptions());
		$this->set('paidoptions', $this->_paidoptns());
		$this->set('states', $this->_stateoptions());
		$this->set('notifyoptions', $this->_notifyVia());
		$this->set('langoptions', $this->_langoptions());
		$this->set('clientscdata',$this->_shippingcarrier());
		$this->set('cnt_total', 1);
	}

	function admin_edit($id = null) {
		if($id == ""){
			$id = $this->params['id'];
		}
		if(isset($this->params['type']) && $this->params['type'] != "") {
			$type = $this->params['type'];
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid user','error',array('display'=>'error'));
			$this->redirect(array('type'=>$type,'action'=>'index'));
			exit();
		}
		$this->User->Behaviors->attach('Containable');
		$currentmodel = Inflector::classify($this->params['type']);
		$user = $this->User->find('first', array('contain'=>array($currentmodel), 'conditions'=>array($currentmodel.'.user_id'=>$id, 'User.id'=>$id)));
		if (!$user && empty($this->data)) {
			$this->Session->setFlash('Invalid user selected','error',array('display'=>'error'));
			$this->redirect(array('type'=>$type, 'action'=>'index'));
			exit();
		}
		if(isset($this->params['type']) && $this->params['type']=="clients") {
			$creq = $this->ClientRequirements->find('all', array('conditions'=>array('ClientRequirements.user_id'=>$id)));
			$this->set('creqs', $creq);
		}
		if (!empty($this->data)) {
			/*	 If the admin approves the user, send the mail to the user email address */

			if(isset($this->data['User']['astatus']) and $this->data['User']['astatus'] == '1'){

				$this->data['User']['status'] = '1';
				$maildata['firstname'] = $this->data[$currentmodel]['first_name'];
				$maildata['lastname'] = $this->data[$currentmodel]['last_name'];
				$maildata['type'] = $type;
				$this->set('mailuserdata', $maildata);
				$this->_sendNewMail(array('to'=>$this->data[$currentmodel]['email'], 'cc'=>'', 'bcc'=>'', 'subject'=>'Welcome to '.Configure::read('sitename'), 'replyto'=>Configure::read('replyemail'),'from'=>Configure::read('fromemail'), 'layout'=>'email', 'template'=>'emailwelcome', 'sendas'=>'html'));
			}
			/*	unset the validation for password as this not mandatory for admin editing	*/
			unset($this->User->validate['username']);
			unset($this->User->validate['password']);
			if($this->data['User']['password']!= "") {
				$this->data['User']['password'] = md5($this->data['User']['password']);
			} else {
				$this->data['User']['password'] = $user['User']['password'];
			}

			$this->data['User']['type'] = $user['User']['type'];
			$this->data['User']['id'] = $user['User']['id'];
			if ($this->User->save($this->data['User'])) {
				if($currentmodel == 'Client') {
					$res = $this->ClientRequirements->query("DELETE FROM client_requirements WHERE user_id = ".$this->User->id) ;
					$this->data['Client']['company_phone'] = $this->Miscellaneous->formatphone(array($this->data['Client']['company_phone1'],$this->data['Client']['company_phone2'],$this->data['Client']['company_phone3']));
					$this->data['Client']['company_fax'] = $this->Miscellaneous->formatphone(array($this->data['Client']['company_fax1'],$this->data['Client']['company_fax2'],$this->data['Client']['company_fax3']));
					$det = $this->User->Client->save($this->data);	
					
					if($this->data['User']['status'] == "1" && !empty($det))
					{
						$client_user_details = $this->User->find('first', array('fields'=>array('Client.company',  'Client.first_name', 'Client.last_name', 'Client.company_phone',  'Client.email', 'Client.of_state', 'Client.of_city', 'Client.of_zip', 'Client.of_street_address'   , 'Client.rd_state', 'Client.rd_city', 'Client.rd_zip', 'Client.rd_street_address'),'contain'=>array('Client'),'conditions'=>array('User.id'=>$id)));
						$this->send_client_to_quickbooks( $client_user_details['Client']);
					}
					
					$this->set('error_messages', $this->User->Client->validationErrors);
					$this->Session->setFlash('The Client could not be saved. Please, try again.','error',array('display'=>'error'));	
					$total = count($this->data['ClientRequirements']['requirements']);
					for($i=0;$i<$total;$i++) {
						$this->ClientRequirements->create();
					 	$creq['ClientRequirements']['user_id'] = $this->User->id;
						$creq['ClientRequirements']['requirements'] = $this->data['ClientRequirements']['requirements'][$i];
						$this->ClientRequirements->save($creq);
				    }
					
					
		
				} elseif($currentmodel == 'Notary') {
				unset($this->Notary->validate['p_address']);
				unset($this->Notary->validate['p_zip']);
				unset($this->Notary->validate['p_state']);
				unset($this->Notary->validate['p_city']);
					
					$this->data['Notary']['evening_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['evening_phone1'],$this->data['Notary']['evening_phone2'],$this->data['Notary']['evening_phone3']));
					$this->data['Notary']['day_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['day_phone1'],$this->data['Notary']['day_phone2'],$this->data['Notary']['day_phone3']));
					$this->data['Notary']['cell_phone'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['cell_phone1'],$this->data['Notary']['cell_phone2'],$this->data['Notary']['cell_phone3']));
					$this->data['Notary']['fax'] = $this->Miscellaneous->formatphone(array($this->data['Notary']['fax1'],$this->data['Notary']['fax2'],$this->data['Notary']['fax3']));
					$mistake = "";
					for($m=0;$m<3;$m++) {
						if(isset($this->data['Notary']['mistakes'][$m]) && $this->data['Notary']['mistakes'][$m]!= '') {
							$mistake = $mistake+$this->data['Notary']['mistakes'][$m];
						}
					}
					$this->data['Notary']['mistakes'] = $mistake;
					$count = count($this->data['Notary']['zipcode']);
					for($i=0;$i<$count;$i++) {
						if($this->data['Notary']['zipcode'][$i] != '') {
							$zip[].= $this->data['Notary']['zipcode'][$i];
						}
						unset($this->Notary->validate['zipcode']);
					}
					$this->data['Notary']['zipcode'] = implode("|",$zip);
					if(isset($user['Notary']['fees']) && $user['Notary']['fees']!= ""){
						if($this->data['Notary']['fees'] != "" && $user['Notary']['fees'] != $this->data['Notary']['fees']) {
							//upon fees update, insert prev fees into historyfees tbl	
							$this->HistoryFees->create();
							$hfees['HistoryFees']['user_id'] = $id;
							$hfees['HistoryFees']['fees'] = $user['Notary']['fees'];
							$this->HistoryFees->save($hfees);
						} else {
							$this->data['Notary']['fees'] = $user['Notary']['fees'];
						}
			        } 
			        $language = implode("|",$this->data['Notary']['languages']);
					$this->data['Notary']['languages'] = $language;
					if($this->data['Notary']['expiration'] <> ""  && $this->data['Notary']['expiration'] <> "0000-00-00"){
						$date = explode("-", $this->data['Notary']['expiration']);
						$this->data['Notary']['expiration'] = $date[2]."-".$date[0]."-".$date[1];
		   			}
		   			if($this->data['Notary']['enddate'] <> ""  && $this->data['Notary']['enddate'] <> "0000-00-00"){
						$edate = explode("-", $this->data['Notary']['enddate']);
						$this->data['Notary']['enddate'] = $edate[2]."-".$edate[0]."-".$edate[1];
		   			}
					
	
					$det = $this->User->Notary->save($this->data);

					if($this->data['User']['status'] == "1" && !empty($det))
					{
						$notary_user_details = $this->User->find('first', array('fields'=>array('Notary.first_name', 'Notary.last_name', 'Notary.cell_phone',  'Notary.email', 'Notary.p_address', 'Notary.p_state', 'Notary.p_city', 'Notary.p_zip'),'contain'=>array('Notary'),'conditions'=>array('User.id'=>$id)));
						$this->send_notary_to_quickbooks($notary_user_details['Notary']);
					}
					
					$this->set('error_messages', $this->User->Notary->validationErrors);
					$this->Session->setFlash('The Notary could not be saved. Please, try again.','error',array('display'=>'error'));


					
				}
				if (!empty($det)){
					$this->Session->setFlash($currentmodel.' saved successfully','error',array('display'=>'success'));
					$this->redirect(array('controller'=>'users','action'=>'index','type'=>$this->params['type'],'id'=>''));
					exit();
				}
			} else {
				unset($this->Client->validate['password']);	
				$this->set('error_messages', $this->User->validationErrors);	
				$this->Session->setFlash($currentmodel.' could not be saved ','error',array('display'=>'error'));
			}
		} else {
			$this->data = $user;
		}
		if(isset($this->data['Notary']['languages']) and $this->data['Notary']['languages']<>""){
			$lang = explode("|",$this->data['Notary']['languages']);
			$this->set('selectedLang', $lang);
		} else {
			$this->set('selectedLang', '');
		}
		
		$this->set('model', $currentmodel);
		$this->set('type', $this->params['type']);
		$this->set('statusoptions', $this->_statusOptions());
		$this->set('statusoptns', $this->_statusOptions('p'));
		$this->set('notaryoptions', $this->_notaryoptions());
		$this->set('payoptions', $this->_payOptions());
		$this->set('paidoptions', $this->_paidoptns());
		$this->set('ynoptions', $this->_ynoptns());
		$this->set('hearoptions', $this->_hearoptions());
		$this->set('states', $this->_stateoptions());
		$this->set('usertype', $type);	
		$this->set('notifyoptions', $this->_notifyVia());
		$this->set('langoptions', $this->_langoptions());
		$this->set('clientscdata',$this->_shippingcarrier());
	}
	
	function admin_delete($id = null) {
		$id = $this->params['id'];
		if (!$id) {
			$this->Session->setFlash('Invalid id for user','error',array('display'=>'error'));
			$this->redirect(array('action'=>'index'));
		}
		if ($id){
			$userassflag = $usersmsgflag = $usersorderflag = $userspayflag=$comment="";
			$usersassg = $this->Assignment->find('first',array('conditions'=>array('Assignment.user_id'=>$id,'Assignment.status'=>'A'),'fields'=>array('Assignment.id')));	
		
			if($usersassg['Assignment']['id']){
				$userassflag='1';
				$comment.='Assignments';
			}
			$usersmsg = $this->Messages->find('first',array('conditions'=>array('Messages.user_id'=>$id),'fields'=>array('Messages.id')));
			if($usersmsg['Messages']['id']){
				$usersmsgflag='1';
				if($userassflag==1){
					$comment.=' and Messages';
				}else{
					$comment.=' Messages';
				}
			}
			
			$usersorder = $this->Order->find('first',array('conditions'=>array('Order.user_id'=>$id),'fields'=>array('Order.id')));
			if($usersorder['Order']['id']){
				$usersorderflag='1';
				if($userassflag==1 || $usersmsgflag==1){
					$comment.=' and Orders';
				}else{
					$comment.=' Orders';
				}
			}
			
			$userspay = $this->Payment->find('first',array('conditions'=>array('Payment.user_id'=>$id),'fields'=>array('Payment.id')));
            if($userspay['Payment']['id']){
				$userspayflag='1';
				if($userassflag==1 || $usersmsgflag==1 || $usersorderflag==1){
					$comment.=' and Payments';
				}else{
					$comment.=' Payments';
				}
			}
			if($userassflag==1 || $usersmsgflag==1 || $usersorderflag==1 || $userspayflag==1){
				$this->Session->setFlash('Cannot delete, user exists in '.$comment,'error',array('display'=>'error'));
				$this->redirect(array('type'=>$this->params['type'],'action'=>'index'));
			}
		}
		
		if($this->params['type']=='clients') {
			$users = $this->Client->find('first',array('conditions'=>array('Client.user_id'=>$id),'fields'=>array('Client.id')));	
            $type='Client';
			$this->Client->delete($users['Client']['id']);
		} else {
			$users = $this->Notary->find('first',array('conditions'=>array('Notary.user_id'=>$id),'fields'=>array('Notary.id')));	
			$type='Notary';
			$this->Notary->delete($users['Notary']['id']);
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash($type.' deleted successfully','error',array('display'=>'success'));
			$this->redirect(array('type'=>$this->params['type'],'action'=>'index'));
		}
		$this->Session->setFlash($type.' was not deleted','error',array('display'=>'error'));
		$this->redirect(array('type'=>$this->params['type'],'action'=>'index'));
	}
	
	function admin_search() {
		
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$search_condition = array();
		$search_params = array();
		$type = $this->data['User']['type'];
		$model = $this->data['User']['model'];
		
		if(!empty($this->data)) {
			if(isset($this->data['User']['name']) and trim($this->data['User']['name'])!='') {
				$search_condition[] = $model.".first_name LIKE '%" . $this->data['User']['name'] . "%' ";
				$search_params['name'] = $this->data['User']['name'];
			}
			if(isset($this->data['User']['email']) and trim($this->data['User']['email'])!='') {
				$search_condition[] = $model.".email LIKE '%" . $this->data['User']['email'] . "%' ";
				$search_params['email'] = $this->data['User']['email'];
			}
			if($type<>"notaries"){
				if(isset($this->data['User']['company']) and trim($this->data['User']['company'])!='') {
					$search_condition[] = $model.".company LIKE '%" . $this->data['User']['company'] . "%' ";
					$search_params['company'] = $this->data['User']['company'];
				}
				if(isset($this->data['User']['of_city']) and trim($this->data['User']['of_city'])!='') {
					$search_condition[] = $model.".of_city LIKE '%" . $this->data['User']['of_city'] . "%' ";
					$search_params['of_city'] = $this->data['User']['of_city'];
				}
				if(isset($this->data['User']['of_state']) and trim($this->data['User']['of_state'])!='') {
					$search_condition[] = $model.".of_state LIKE '%" . $this->data['User']['of_state'] . "%' ";
					$search_params['of_state'] = $this->data['User']['of_state'];
				}
			} else {
				if(isset($this->data['User']['zipcode']) and trim($this->data['User']['zipcode'])!='') {
					$search_condition[] = $model.".zipcode LIKE '%" . $this->data['User']['zipcode'] . "%' ";
					$search_params['zipcode'] = $this->data['User']['zipcode'];
				}
				if(isset($this->data['User']['of_city']) and trim($this->data['User']['of_city'])!='') {
					$search_condition[] = $model.".dd_city LIKE '%" . $this->data['User']['of_city'] . "%' ";
					$search_params['of_city'] = $this->data['User']['of_city'];
				}
				if(isset($this->data['User']['of_state']) and trim($this->data['User']['of_state'])!='') {
					$search_condition[] = $model.".dd_state LIKE '%" . $this->data['User']['of_state'] . "%' ";
					$search_params['of_state'] = $this->data['User']['of_state'];
				}
				if(isset($this->data['User']['languages']) and trim($this->data['User']['languages'])!='') {
					$search_condition[] = $model.".languages LIKE '%" . $this->data['User']['languages'] . "%' ";
					$search_params['languages'] = $this->data['User']['languages'];
				}
				if(isset($this->data['User']['attorney']) and trim($this->data['User']['attorney'])!='') {
					$search_condition[] = "Notary.work_with = '" . $this->data['User']['attorney'] . "' ";
					$search_params['attorney'] = $this->data['User']['attorney'];
				}
			}
			if(isset($this->data['User']['status']) and trim($this->data['User']['status'])!='') {
				$search_condition[] = " User.status ='" . $this->data['User']['status'] ."'";
				$search_params['status'] = $this->data['User']['status'];
			}
		}
		
		$_SESSION['search']['condition'] = $search_condition;
		$_SESSION['search']['params'] = $search_params;
		$this->redirect(array('type'=>$type,'action'=>'index'));
	}
	
	function admin_clear() {
		/* Unset the session for new criteria */
		$this->__clearsearch();
	}
	
	function check_client($value){
		$this->layout = null;
		$flag = 0;
		$cond = "";
		$search_condition[] = "Client.first_name LIKE '%" . $value. "%' ";
		$data_array = $this->Client->find('all',array('conditions'=>$search_condition));
		$this->set('cdetails', @$data_array['User']['first_name']);
	}

	/*	Export Clients/Notaries to CSV */
	function admin_export(){
		$model = $this->params['form']['checkmodel'];
		if($model == 'Client'){
			$type = 'clients';
		} else {
			$type = 'notaries';
		}
	 	if(!empty($this->data['User']['chkb'])){
	 		$usrIds = implode(",",$this->data['User']['chkb']); 
	       	$userIds = "(".$usrIds.")";
	       	$conditions = array("$model.user_id IN $userIds");
			if($model == 'Notary'){
				$csvdata = $this->Notary->find('all', array('fields'=>array('Notary.first_name','Notary.last_name','Notary.email','Notary.cell_phone','Notary.fax','Notary.p_address','Notary.p_city','Notary.p_state','Notary.p_zip'),'conditions' => $conditions));
				$this->exporttocsv($csvdata, 'notary');
			} else {
				$csvdata = $this->Client->find('all', array('fields'=>array('Client.company','Client.first_name','Client.last_name','Client.email','Client.company_phone','Client.company_fax','Client.of_street_address','Client.of_city','Client.of_state','Client.of_zip'),'conditions' => $conditions));
				$this->exporttocsv($csvdata, 'client');
			}
		} else {
	 		$this->Session->setFlash('Please select the '.$type.' to be exported','error',array('display'=>'warning'));
 			$this->redirect(array('type'=>$type,'action'=>'index'));
 			exit();
	 	}
	 }
	 
	 /*	Export Clients/Notaries to CSV */
	function admin_import(){
		$this->layout = null;
		if(!empty($this->data['User']['importfile'])){
	 		$this->Upload->upload($this->data['User']['importfile'], realpath('').'/'.Configure::read('IMPORT_PATH'), null, null, array('csv'));
	 		$this->importcsv($this->Upload->result, $this->data['User']['importype']);
		} else {
	 		$this->Session->setFlash('Please upload the file to be imported', 'error', array('display'=>'warning'));
 			$this->redirect(array('type'=>$this->data['User']['importype'],'action'=>'index'));
 			exit();
	 	}
	 }
}
?>