<?php
#Miscellaneous component includes all misc fucntion.
class MiscellaneousComponent extends Object {
 
    var $controller = null;	
    var $components = array('Session');
    
    function startup(&$controller){
    	$this->controller = $controller;
	}
	
  	//Get any User info 
	function getUserName($id){
		$getuser = "SELECT first_name, last_name FROM notaries WHERE user_id = '".$id."'";
		$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);
		return $resuser[0]['notaries']['first_name'];
	}
	
  	//Get any admin info 
	function getAdminName($id){
		$getuser = "SELECT name,id FROM admins WHERE id =".$id;
		$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);			
		return $resuser[0]['admins']['name'];
	}
	
	//Get any admin info 
	function getAdminupdate($id){
		$getuser = "SELECT count(*) as no FROM signinghistories WHERE status = '0' AND added_by = 'N' AND order_id =".$id;
		$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);		
		if($resuser[0][0]['no']<>0) {
			return true;
		} else {
			return false;
		}
	}
	
	//Get sender info 
	function gettracking($id, $track=false){
		$getuser = "SELECT track_shipping_info, tracking_no  FROM orders WHERE id = '".$id."'";
		$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);
		if($track) {
			if($resuser[0]['orders']['track_shipping_info']=='F') {
				$trackingno = '<a href="'.Configure::read('fedextracking').$resuser[0]['orders']['tracking_no'].'" target="_blank">'.$resuser[0]['orders']['tracking_no'] .'</a>';
			} elseif($resuser[0]['orders']['track_shipping_info']=='U') {
				$trackingno = '<a href="'.Configure::read('upstracking').$resuser[0]['orders']['tracking_no'].'" target="_blank">'. $resuser[0]['orders']['tracking_no'] .'</a>';
			} elseif($resuser[0]['orders']['track_shipping_info']=='D') {
				$trackingno = '<a href="'.Configure::read('dhltracking').'" target="_blank">'. $resuser[0]['orders']['tracking_no'] .'</a>';
			} elseif($resuser[0]['orders']['track_shipping_info']=='G') {
				$trackingno = '<a href="'.Configure::read('gsotracking').'" target="_blank">'. $resuser[0]['orders']['tracking_no'] .'</a>';
			} elseif($resuser[0]['orders']['track_shipping_info']=='E') {
				$trackingno = '<a href="'.Configure::read('overniteexpress').'" target="_blank">'. $resuser[0]['orders']['tracking_no'] .'</a>';
			} else {
				$trackingno = $resuser[0]['orders']['tracking_no'];
			}
			return $trackingno;
		}
		return $resuser[0]['orders']['tracking_no'];
	}

	//Get sender info 
	function getsender($type,$id){
		if($type=='A'){
			$getuser = "SELECT name FROM admins WHERE id = '".$id."'";
			$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);
			if($resuser) {
				return "Admin / ".$resuser[0]['admins']['name'];	
			}
			return false;
		} else {
			if($type == 'C'){
				$getuser = "SELECT  first_name, last_name FROM clients WHERE user_id = '".$id."'";
				$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);
				return "Client / ".$resuser[0]['clients']['first_name'];
			}
			if($type == 'N'){
				$getuser = "SELECT first_name, last_name FROM notaries WHERE user_id = '".$id."'";
				$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);
				return "Notary / ".$resuser[0]['notaries']['first_name'];
			}
			if($type == 'NN'){
				$getuserid = "SELECT user_id FROM assignments WHERE signinghistory_id = '".$id."'";
				$resuserid = $this->controller->{$this->controller->modelNames[0]}->query($getuserid);
				$getuser = "SELECT first_name, last_name FROM notaries WHERE user_id = '".$resuserid[0]['assignments']['user_id']."'";
				$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);		
				return @$resuser[0]['notaries']['first_name']." ".@$resuser[0]['notaries']['last_name'];
			}
		}
	}
	
	//Get client company from user id
	function getCompName($id){
		$getuser = "SELECT company FROM clients WHERE user_id = '".$id."'";
		$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);
		if(isset($resuser[0]['clients']['company'])) {
			return $resuser[0]['clients']['company'];
		} else {
			return "NA";
		}
	}
	
	//Get client company from user id
	function getDivName($id){
		$getuser = "SELECT division FROM clients WHERE user_id = '".$id."'";
		$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);
		if(isset($resuser[0]['clients']['division'])) {
			return $resuser[0]['clients']['division'];
		} else {
			return "NA";
		}
	}
	
	//Get notary assigned from order id
	function getNotaryName($id){
		$getuser = "SELECT user_id FROM assignments WHERE order_id = '".$id."' and status='A'";
		$resultuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);
		if(isset($resultuser['0']['assignments']['user_id']) && $resultuser['0']['assignments']['user_id']<>""){
			$getusername = "SELECT first_name,last_name FROM notaries WHERE user_id = '".$resultuser['0']['assignments']['user_id']."'";
			$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getusername);
			if(isset($resuser[0]['notaries']['first_name']) && isset($resuser[0]['notaries']['last_name'])){
				return $resuser[0]['notaries']['first_name']." ".$resuser[0]['notaries']['last_name'];
			}
		} else {
			return "NA";	
		}
	}
	
	//Get notary fee from order id
	function getnotaryfee($id){
		$getfee	= "SELECT fees FROM notaries WHERE user_id = '".$id."'";
		$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getfee);
			if(isset($resuser[0]['notaries']['fees']) ){
				return $resuser[0]['notaries']['fees'];
			}
		}
	
	//Get Appointment date from order id
	function getApptdttime($id=null){
		$getinfo = "SELECT appointment_time FROM signinghistories WHERE order_id = '".$id."' ORDER BY id DESC";
		$getoinfo = "SELECT orderstatus_id,created FROM orders WHERE id = '".$id."' ";
		$resultinfo	= $this->controller->{$this->controller->modelNames[0]}->query($getinfo);
		$resultoinfo = $this->controller->{$this->controller->modelNames[0]}->query($getoinfo);
		if(!empty($resultinfo) && $resultinfo['0']['signinghistories']['appointment_time']<>"" && ($resultoinfo['0']['orders']['orderstatus_id']=='4' || $resultoinfo['0']['orders']['orderstatus_id']=='7')){
			return date("m-d-Y", strtotime($resultoinfo['0']['orders']['created']))." ".$resultinfo['0']['signinghistories']['appointment_time'];
		} else {
			return "NA";
		}
	}
	
	//Get any User onfo 
	function getClientEmail($oid){
		$getorder =	"SELECT user_id FROM orders WHERE id = '".$oid."'";
		$resorder = $this->controller->{$this->controller->modelNames[0]}->query($getorder);
		$uid = $resorder[0]['orders']['user_id'];
		$getuser = "SELECT email, first_name,last_name FROM clients WHERE user_id = '".$uid."'";
		$resuser = $this->controller->{$this->controller->modelNames[0]}->query($getuser);
		return $resuser[0]['clients'];
	}
		
	function dateFormat($date){
		$fdate=date('m-d-Y g:ia', strtotime($date));
		return $fdate;
	}
	
	function date_format($date){
		$fdate=date('m-d-Y', strtotime($date));
		return $fdate;
	}
		
	//get status from orderstatuses
	function _orderStatus($sid=null) {
		$getstat = "SELECT status FROM orderstatuses WHERE id = '".$sid."'";
		$resstat = $this->controller->{$this->controller->modelNames[0]}->query($getstat);
		return $resstat[0]['orderstatuses']['status'];
	}

	//format the phone number for inserting to the table
	function formatphone($phone) {
		//return str_replace("-", "", $phone);
		return implode("", $phone);
	}
	
	//format the phone number for inserting to the table
	function splitphone($phone, $start=0, $end=0) {
		return substr($phone, $start, $end);
	}

}
?>
