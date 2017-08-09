<?php
App::import('Sanitize');

class AppController extends Controller {
		
	var $helpers = array('Html', 'Form', 'Javascript', 'Session','Counter','Link','Time');
	var $components = array('Session','Email','Miscellaneous');
	var $uses = array('News','Users', 'Clients','Notaries','Contentpage');

	/**
	* Error controlling, Redirecting the page to Home page
	*/
	function beforeRender () {
		if($this->name == 'CakeError') {
			//$this->redirect(array('controller'=>'pages', 'action'=>'display'));
			//exit;
		}
	}
	
	function beforeFilter() {
		/*
		*	Check for admin or user login
		*/
		if(isset($this->params['admin']) && $this->params['admin']) {
			$this->layout = 'admin';
			$this->_checkAdmin();
		} else {
			$this->_newsandevents();
			$this->_followtwt();
			$this->_followfb();
			$this->_followin();
			$this->_getintouch();
			$this->_checkUser();
			$this->_checkMessageAccess();			
		}
		if(!isset($this->params['admin'])) {
			$this->layout = 'inner';
		}
		if($this->params['controller'] == 'pages' and !isset($this->params['admin'])) {
			$this->layout = 'home';
		}
		$this->set('misc', $this->Miscellaneous);
	}
	
	/**********************************************
	* This function checks whether the admin is logged-in or not and the admin access, 
	* currently used in admin. 
	* Renjith Chacko
	*************************************************/
	function _checkAdmin($type=null) {
		$admin_data = $this->Session->read('WBSWAdmin');
		if(isset($admin_data['Admin']['id']) != '') {
			if(isset($type)!='') {
				if($admin_data['Admin']['type'] != $type) {
					$this->Session->setFlash('You are not permitted to access this page.','error',array('display'=>'warning'));
					$this->redirect(array('controller'=>'admins','action'=>'dashboard'));
				}
			}
			$this->set('admindata', $admin_data);
		} else {
			$this->Session->setFlash('Please login to access Admin Console.','error',array('display'=>'warning'));
			$this->redirect(array('controller'=>'admins','action'=>'login'));
		}
	}
	
	/*********************************
	* This function checks whether the website user is logged-in or not
	* Renjith Chacko
	**********************************/
	function _checkUser() {
		$user_data = $this->Session->read('WUBSSEWR');
		if(isset($user_data['User']['id']) != '') {
			$this->set('usersession', $user_data);
		}
	}

	/**************************************
	* This function checks whether the logged in user is allowed to access messages
	* Renjith Chacko
	*********************************************/
	function _checkMessageAccess($whois=null) {
		$user_data = $this->Session->read('WUBSSEWR');
		if($user_data['User']['type'] != 'N' and $this->params['controller']=='messages') {
			$this->redirect(array('controller'=>'users','action'=>'logout'));
		}
	}
	
	/*******************************************
	* This function checks whether the logged in user is allowed to access Orders
	**********************************************/
	function _checkOrderAccess($whois=null) {
		$user_data = $this->Session->read('WUBSSEWR');
		if($user_data['User']['type'] != 'N' and $this->params['controller']=='assignments') {
			$this->redirect(array('controller'=>'users','action'=>'logout'));
		}
	}
	
	/*
	* This function checks whether the logged in user is allowed to access Order view
	*/
	function _checkView($whois=null) {
		$user_data = $this->Session->read('WUBSSEWR');
		if($user_data['User']['type'] != 'C' and isset($this->params['named']['u'])) {
			$this->redirect(array('controller'=>'users','action'=>'logout'));
		}
	}
	
	/*
	* This function adds the status options in the list box, to accept/deny user-used in adminside. 
	*/
	function _statusOptions($type=null) {
		if($type=='p'){
			$status_options = array('2'=>'Pending','1'=>'Active','0'=>'Inactive');
		} else {
			$status_options = array('1'=>'Active','0'=>'Inactive');
		}
		return $status_options;
	}
	
	function _docinfooptions() {
			$di_options = array('N'=>'New','R'=>'Re-sign');
			return $di_options;
	}
	
	
	function _doctypesoptionsslt() {
			$di_options = array('S'=>'Single doc','O'=>'Refinance(1st)','T'=>'1st/2nd','R'=>'Reverse Mortgage','P'=>'Purchase','E'=>'Seller docs','F'=>'FHA/VA','M'=>'Misc');
			return $di_options;
	}
	
	function _doctypeoptions() {
			$di_options = array(''=>'Select','E'=>'EDOCS','P'=>'PICK UP Docs','O'=>'Overnight');
			return $di_options;
	}
	
	function _pdftypeoptions() {
			$r_options = array('C'=>'Escrow docs','L'=>'Loan Docs','M'=>'MISC');
			return $r_options;
	}
	
	function _paidoptns(){
		$paid_options = array('yes'=>'Yes','no'=>'No');
		return $paid_options;
	}
	
	function _paidoptions(){
		$paid_options = array('0'=>'Not Paid','1'=>'Paid');
		return $paid_options;
	}
	
	function _ynoptns(){
		$yn_options = array('Y'=>'Yes','N'=>'No');
		return $yn_options;
	}
	
	function _nyoptns(){
		$yn_options = array(''=>'Select','N'=>'No','Y'=>'Yes');
		return $yn_options;
	}
	
	function _shipoptions($carrier=null){
		$s_options = array('F'=>'FedEx','U'=>'UPS','D'=>'DHL','G'=>'GSO','E'=>'Overnite Express','O'=>'Other');
		if($carrier){
			return $s_options = $s_options[$carrier];
		} else {
			return $s_options;
		}
	}
	
	function _hearoptions(){
		$h_options = array('W'=>'Website/Internet Search','C'=>'Company contacted me direct','M'=>'Direct Mail','R'=>'Referral');
		return $h_options;
	}
	
	/*
	* This function adds the amount options in the list box for proffesional notary sign up. 
	*/
	function _payOptions() {
		$pay_options = array('2.95|month' => Configure::read('currency').'2.95/mo', '29.95|year' => 'Save 15% '.Configure::read('currency').'29.95/year');
		return $pay_options;
	}
	
	function _admintypeOptions() {
		$pay_options = array('M'=>'Manager', 'E'=>'Employee');
		return $pay_options;
	}
	
	/*
	* This function adds the notaries options in adminside. 
	*/
	function _notaryoptions() {
		$notary_options = array('B'=>'Basic','P'=>'VIP');
		return $notary_options;
	}
 
/*
	* This function adds the months 
	*/
	function _monthoptions() {
		$month_options = array (
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );

		return $month_options;
	}
	
	
	/*
	* This function adds the states used in the 1hns. 
	*/
	function _stateoptions($code=null) {
		$state_list = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois",'IN'=>"Indiana",'IA'=>"Iowa",'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland",'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma",'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");
		return $state_list;
	}
	
		
	/*
	* This function adds the languages used in the 1hns. 
	*/
	function _langoptions() {
		$lang_list = array('ASL'=>"ASL (American Sign Language)",'Arabic'=>"Arabic",'Armenian'=>"Armenian",'Chinese'=>"Chinese",'Chinese-Mandarin'=>"Chinese (Mandarin)",'Dutch'=>"Dutch",'French'=>"French",'German'=>"German",'Greek'=>"Greek",'Hebrew'=>"Hebrew",'Hindi'=>"Hindi",'Italian'=>"Italian",'Japanese'=>"Japanese",'Korean'=>"Korean",'Persian'=>"Persian",'Polish'=>"Polish",'Portuguese'=>"Portuguese",'Romanian'=>"Romanian",'Russian'=>"Russian",'Spanish'=>"Spanish",'Swedish'=>"Swedish",'Tagalog'=>"Tagalog",'Thai'=>"Thai",'Turkish'=>"Turkish",'Vietnamese'=>"Vietnamese");
		return $lang_list;
	}
	
	function _experienceoptions() {
		$experience_list = array('Purchase'=>"Purchase",'Refinances'=>"Refinances",'REO'=>"REO",'Reverse mortgage'=>"Reverse mortgage",'Equity / HELOC'=>"Equity / HELOC",'Electronic notarization'=>"Electronic notarization",'Remote (video) notarization'=>"Remote (video) notarization",'Commercial loan packages'=>"Commercial loan packages",'Seller docs'=>"Seller docs",'FHA/VA'=>"FHA/VA");
		return $experience_list;
	}
	
	function _dayoptions() {
		$dayoptions_list = array('Monday'=>"Monday",'Tuesday'=>"Tuesday",'Wednesday'=>"Wednesday",'Thursday'=>"Thursday",'Friday'=>"Friday",'Saturday'=>"Saturday",'Sunday'=>"Sunday");
		return $dayoptions_list;
	}
		
	function _timeoptions() {
		return array('All Day'=>"All Day",'Morning (8:00am-11:00am)'=>"Morning (8:00am-11:00am)",'Afternoon (12:00pm-5:00pm)'=>"Afternoon (12:00pm-5:00pm)",'Evening (5:00pm-9:00pm)'=>"Evening (5:00pm-9:00pm)");
	}
	
	function _approvesoptions() {
		$dayoptions_list = array('Chicago Title'=>"Chicago Title",'Fidelity Title'=>"Fidelity Title",'First American Title'=>"First American Title",'Lawyers Title'=>"Lawyers Title");
		return $dayoptions_list;
	}
	/****************************************************
	* This function adds the usertypes in the website. 
	****************************************************/
	function whichtypeuser($usertype=null) {
		$usertype_options = array('C'=>'Clients','N'=>'Notaries');
		if($usertype){
			return $usertype = low($usertype_options[$usertype]);
		} else {
			return $usertype_options;
		}
	}
	
	/***********************************************
	* This function adds the usertypes in the website. 
	*****************************************************/
	function assignmentstatus() {
		$assignmentstatus = array('A'=>'Accepted','R'=>'Rejected','P'=>'Pending');
		return $assignmentstatus;
	}
	
	/***********************************************
	* This function adds the resource category in the website. 
	*****************************************************/
	function resourceCategory() {
		$assignmentstatus = array('1'=>'Document Viewers','2'=>'Application / W-9','3'=>'Rescission Calendar','4'=>'3 Strikes Rule','5'=>'Find a Fed Ex / UPS Location','6'=>'Reverse Mortgage','7'=>'Marital States','8'=>'Witness States');
		return $assignmentstatus;
	}
	
	
	/*********************************************************************
	* This function checks whether the user have any permission on accessing the page
	* else redirect to login
	* return - signed in session
	* Renjith Chacko
	**********************************************************************/
	function _checkPermission() {
		$userdata = $this->Session->read('WUBSSEWR');
		if(isset($userdata['User']['id']) == '') {
			$this->redirect(array('controller'=>'users','action'=>'login'));
		} 
		return $userdata;
	}
	
	/********************************************************************
	*	Renjith Chacko
	*	get the news and events in the website pages
	*********************************************************************/
	function _newsandevents() {
		$this->set('webnews', $this->News->find('all',array('order'=>'News.created DESC','limit'=>'3','fields'=>array('News.id','News.title','News.image','News.description'),'conditions'=>array('News.status'=>'1'))));
	}
		
	
	function _followtwt() {
		$this->set('webtwt', $this->Contentpage->find('first', array('fields'=>'content', 'conditions'=>array('id'=>'27', 'status'=>1))));
	}
	function _followfb() {
		$this->set('webfb', $this->Contentpage->find('first', array('fields'=>'content', 'conditions'=>array('id'=>'28', 'status'=>1))));
	}
	
	function _followin() {
		$this->set('webin', $this->Contentpage->find('first', array('fields'=>'content', 'conditions'=>array('id'=>'29', 'status'=>1))));
	}
	
	function _getintouch() {
		$this->set('webgetintouch', $this->Contentpage->find('first', array('fields'=>'content', 'conditions'=>array('id'=>'30', 'status'=>1))));
	}
	/********************************************************************
	*	Renjith Chacko
	*	Clear the search values from the session
	*********************************************************************/
	function __clearsearch () {
		/* Unset the session for new criteria */
		if(isset($_SESSION['search'])) unset($_SESSION['search']);
		$this->redirect($this->referer());
	}

	/* Get all the controllers - Renjith Chacko	*/
	function __getControllers() {
		return array('pages' =>'Home','users'=>'Users','contentpages'=>'Content Pages');
	}
	
	/********************************************************************
	*	Contact Us page on Website
	*********************************************************************/
	function contact() {
		$this->layout = 'inner';
		$this->set('title_for_layout','Contact Us');
		if(!empty($this->data)){
			$this->set('mailuserdata',$this->data);
			$this->_sendNewMail(array('to'=>Configure::read('infoemail'),'bcc'=>'','subject'=>Configure::read('sitename').' - Contact us','replyto'=>'','from'=>$this->data['News']['email'],'layout'=>'email','template'=>'contactus','sendas'=>'html'));
			$this->Session->setFlash('Message sent successfully','error',array('display'=>'success'));
			$this->redirect($this->referer());
		}
	}

	/***************************************************************
	*	To send a message using a template, simply pass the parameters of the message as an array to the method. 
	*	Renjith Chacko
	*	array('to'=>'','cc'=>'', 'bcc'=>'','subject'=>'','replyto'=>'','from'=>'','layout'=>'','template'=>'','sendas'=>'')
	*****************************************************************/
	function _sendNewMail($mailarray = array()) {
		$this->Email->to = @$mailarray['to'];
		if(@$mailarray['cc']){
			$this->Email->cc = @$mailarray['cc'];
		}
		if(@$mailarray['bcc']){
			$this->Email->bcc = array(@$mailarray['bcc']);
		}
		$this->Email->subject = @$mailarray['subject'];
		$this->Email->replyTo = @$mailarray['replyto'];
		$this->Email->from = @$mailarray['from'];
		if(@$mailarray['attachments']){
			$this->Email->filePaths = array(@$mailarray['filePaths']);
			$this->Email->attachments = array(@$mailarray['attachments']); 
		}
		$this->Email->layout = @$mailarray['layout'];
		$this->Email->template = @$mailarray['template'];
		$this->Email->additionalParams = Configure::read('adminemail');
		$this->Email->sendAs = @$mailarray['sendas'];
		
		$this->Email->send();
	}
		
	
	/********************************************************************
	*	Exports invoice to .csv file 
	*********************************************************************/
	function exportintocsv($arr=null) {
		$csv_output = "";
		$fields = array('No','Borrower','Client (Company)','File','Notary','Fees','Invoice date','Invoice doc','Invoice Comments','Status','Paid date');
		$i = 0;
		foreach ($fields as $key=>$val) {
			$csv_output .= $val.", ";
			$i++;
		}
		$csv_output .= "\n";
		$countt = '1';
		foreach($arr as $eachinv) {
			if($eachinv['Invoice']['status'] == '1'){
				$status = "Paid";
			} else {
				$status = "Not Paid";
			}
			if($eachinv['Invoice']['paiddate']=='0000-00-00 00:00:00'){
				$pdate = "";
			} else {
				$pdate = $this->Miscellaneous->dateFormat($eachinv['Invoice']['paiddate']);
			}
			$csv_output .= $countt.", ";
			$csv_output .= $eachinv['Order']['first_name']." ".$eachinv['Order']['last_name'].", ";
			$csv_output .= $this->Miscellaneous->getCompName($eachinv['Order']['user_id']).", ";
			$csv_output .= $eachinv['Order']['file'].", ";
			$csv_output .= $this->Miscellaneous->getNotaryName($eachinv['Invoice']['order_id']).", ";
			$csv_output .= Configure::read('currency').$eachinv['Invoice']['totalfees'].", ";
			$csv_output .= $this->Miscellaneous->dateFormat($eachinv['Invoice']['created']).", ";
			$csv_output .= $eachinv['Invoice']['invoicedoc'].", ";
			$csv_output .= $eachinv['Invoice']['comments'].", ";
			$csv_output .= $status.", ";
			$csv_output .= $pdate;
			$csv_output .= "\n";
			$countt++;
		}
		$filename = Inflector::slug(Configure::read('sitename'))."_invoices_".date("Y-m-d_H-i",time());
		header("Content-type: application/csv");
		header("Content-disposition: csv" . date("Y-m-d") . ".csv");
		header( "Content-disposition: filename=".$filename.".csv");
		print $csv_output;
		exit;
	}
	
	/********************************************************************
	*	Exports clients/notaries to CSV file 
	*********************************************************************/
	function exporttocsv($arr=null, $type=null) {
		$csv_output = $fields = "";
		if($type == 'client') {
			$fields = array('No','Company','First name', 'Last name','Email address', 'Cell number', 'Fax number', 'Bill To Address', 'City', 'State', 'Zip code');
		} elseif($type == 'notary') {
			$fields = array('No', 'First name', 'Last name', 'Email address', 'Cell number',  'Fax number', 'Bill To Address', 'City', 'State', 'Zip code');
		} elseif($type == 'invoice') { 
			$fields = array('No','Borrower','Client (Company)','File','Notary','Fees','Invoice date','Invoice doc','Invoice Comments','Status','Paid date');
		}
		$i = 0;
		foreach ($fields as $key=>$val) {
			$csv_output .= $val.", ";
			$i++;
		}
		$csv_output .= "\n";
		$countt = '1';
		foreach($arr as $eachinv) {
			$csv_output .= $countt.", ";
			foreach($eachinv[Inflector::humanize($type)] as $csvfield):
				$csv_output .= $csvfield.',';
			endforeach;
			$csv_output .= "\n";
			$countt++;
		}
		$filename = Inflector::slug(Configure::read('sitename')).$type.date("Y-m-d_H-i",time());
		header("Content-type: application/csv");
		header("Content-disposition: csv" . date("Y-m-d") . ".csv");
		header("Content-disposition: filename=".$filename.".csv");
		print $csv_output;
		exit;
	}

	/********************************************************************
	*	Import clients/notaries from a CSV file TODO
	*********************************************************************/
	function importcsv ($fileloc, $userimtype) {
		$file_handle = fopen(Configure::read('WEB_URL').Configure::read('IMPORT_PATH')."/".$fileloc, "r");
		while (!feof($file_handle) ) {
			$fetcheddata = fgetcsv($file_handle, 1024);
			if($fetcheddata[0]>0) {
				$this->User->create();
				$userdata['User']['type'] = substr(Inflector::humanize($userimtype), 0, 1);
				if($userdata['User']['type']=='C') {
					$userdata['User']['username'] = $fetcheddata[4];
					$userdata['User']['password'] = md5($fetcheddata[3]);
				} else {
					$userdata['User']['username'] = $fetcheddata[3];
					$userdata['User']['password'] = md5($fetcheddata[2]);
				}
				$this->User->save($userdata);
				if($userdata['User']['type'] == 'C') {
					$this->Client->create();
					$userdata['Client']['user_id'] = $this->User->id;
					$userdata['Client']['company'] = $fetcheddata[1];
					$userdata['Client']['first_name'] = $fetcheddata[2];
					$userdata['Client']['last_name'] = $fetcheddata[3];
					$userdata['Client']['email'] = $fetcheddata[4];
					$userdata['Client']['company_phone'] = $fetcheddata[5];
					$userdata['Client']['company_fax'] = $fetcheddata[6];
					$userdata['Client']['of_street_address'] = $fetcheddata[7];
					$userdata['Client']['of_city'] = $fetcheddata[8];
					$userdata['Client']['of_state'] = $fetcheddata[9];
					$userdata['Client']['of_zip'] = $fetcheddata[10];
					unset($this->Client->validate);
					$this->Client->save($userdata);
				}
				if($userdata['User']['type'] == 'N') {
					$this->Notary->create();
					$userdata['Notary']['user_id'] = $this->User->id;
					$userdata['Notary']['first_name'] = $fetcheddata[1];
					$userdata['Notary']['last_name'] = $fetcheddata[2];
					$userdata['Notary']['email'] = $fetcheddata[3];
					$userdata['Notary']['cell_phone'] = $fetcheddata[4];
					$userdata['Notary']['fax'] = $fetcheddata[5];
					$userdata['Notary']['p_address'] = $fetcheddata[6];
					$userdata['Notary']['p_city'] = $fetcheddata[7];
					$userdata['Notary']['p_state'] = $fetcheddata[8];
					$userdata['Notary']['p_zip'] = $fetcheddata[9];
					unset($this->Notary->validate);
					$this->Notary->save($userdata);
				}
			}
		}
		fclose($file_handle);
		unlink(realpath('').'/'.Configure::read('IMPORT_PATH')."/".$fileloc);
 		$this->Session->setFlash('The data has been imported', 'error', array('display'=>'success'));
		$this->redirect(array('controller'=>'users', 'action'=>'index', 'type'=>$userimtype));
		exit;
	}
	
	/**********************************************************************************************
	* This function adds the status options in the list box, to accept/deny user-used in adminside. 
	***********************************************************************************************/
	function _notifyStatus($type=null) {		
		$status_notify = array( '1'=>'Read','0'=>'Not read');
		return $status_notify;
	}	
	
	
	function _rmainoptions($type=null) {		
		$status_notify = array( '1'=>'Total # of requests received','2'=>'Total # of NO SIGNS','3'=>'Total # of COMPLETED signings','4'=>'Total # of signings a notary has completed','5'=>'Total # of mistakes specific notaries have completed (per incidents)','6'=>'Number of Notaries');
		return $status_notify;
	}
	
	
	function _rsuboptions($type=null) {		
		$status_notify = array( '1'=>'Daily Report','2'=>'Weekly Report','3'=>'Monthly Report','4'=>'Yearly Report');
		return $status_notify;
	}
	/**********************************************************************************************
	* This function adds the status options in the list box, to accept/deny user-used in adminside. 
	***********************************************************************************************/
	function _notifyVia($type=null) {		
		$status_notify = array( 'T'=>'Text Message','E'=>'Email','B'=>'Both');
		return $status_notify;
	}
	
	/*******************************************************
	* Force downloading the file - Renjith Chacko
	********************************************************/
	function _downloadfile($file = null) {
		header("Content-type: application/force-download");
		header("Content-Transfer-Encoding: Binary");
		header("Content-length: ".filesize($file));
		header("Content-disposition: attachment; filename=".basename($file));
		readfile($file); 
	}

		
	/*******************************************************
	* Notary fee section for order 
	********************************************************/
	function _feetypeoptions() {
			$ft_options = array('1'=>'Basic fee','2'=>'Edocs','3'=>'Second','4'=>'Additional trip','5'=>'Excess mileage','6'=>'No sign');
			return $ft_options;
	}
	
	/**********************************************************************************************
	* This function adds the reports generator options
	********************************************************************************************/
	function _generatedreportof() {		
		$reportof = array('1'=>'Total # of orders received','2'=>'Total # of NO SIGNS','3'=>'Total # of COMPLETED signings','4'=>'Total # of signings a notary has completed','5'=>'Total # of mistakes specific notaries have completed (per incidents)','6'=>'Number of Notaries');
		return $reportof;
	}

	/**********************************************************************************************
	* This function adds the type of reports generated for
	***********************************************************************************************/
	function _generatedreportby() {		
		$reportby = array('1'=>'Daily','2'=>'Weekly','3'=>'Monthly','4'=>'Yearly','5'=>'Notary');
		return $reportby;
	}
	
	/* Prefer to use this one */
	function _shippingcarrier($type=null) {		
		$sc_option = array('F'=>'FedEx','U'=>'UPS','D'=>'DHL','G'=>'GSO','E'=>'Overnite Express','O'=>'Other');
		if($type) {
			return $sc_option[$type];
		}
		return $sc_option;
	}
	
	function _hropt() {		
		$houroptions = array('15'=>'15Mins Left','30'=>'30Mins Left','45'=>'45Mins Left');
		return $houroptions;
	}
	
	function _notarymistake() {		
		$houroptions = array('0'=>'0','1'=>'1','2'=>'2','3'=>'3');
		return $houroptions;
	}

	function _hhtype() {		
		$reportby = array('1'=>'Client','2'=>'Notary',''=>'Both');
		return $reportby;
	}
}