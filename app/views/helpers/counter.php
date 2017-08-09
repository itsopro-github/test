<?php
/**
 * Class which overides/extends the AppHelper class to add additional fnctionalites to be used through out the application
 * @author Renjith Chacko
 * @version 1.0 
 */

class CounterHelper extends AppHelper {
	
	var $helpers = array('Time');
	
	function counters($currcount) {
		$pagenumber = isset($this->params['page']) == '' ? @$this->params['named']['page'] : $this->params['page'];
		if(isset($pagenumber) != '')  {
			$currcount = ($pagenumber -1) * $this->params['paging'][$this->params['models'][0]]['options']['limit'] + $currcount;
		}
		return $currcount;
	}
	
	function tousphone($number) {
		if(isset($number)!='' and is_numeric($number)) {
			$number = ereg_replace('[^0-9]', '', $number);
			$len = strlen($number);
			if($len == 7)
				$number = preg_replace('/([0-9]{3})([0-9]{4})/', '$1-$2', $number);
			elseif($len == 10)
				$number = preg_replace('/([0-9]{3})([0-9]{3})([0-9]{4})/', '$1-$2-$3', $number);
			return $number;
		}
	}
	
	/****************************************************
	* This function adds the usertypes in the website. 
	****************************************************/
	function usertypes($type) {
		$usertypes = array('C'=>'Clients','N'=>'Notaries');
		if($type=='') return $usertypes;
		return $usertypes[$type];
	}
	
	function formatdate($type,$date) {
		if(isset($date) and $date != '0000-00-00') {
			return $this->Time->format(Configure::read($type),$date);
		} else {
			return false;
		}
	}
	
	function shippingcarrier($type=null) {		
		$sc_option = array('F'=>'FedEx','U'=>'UPS','D'=>'DHL','G'=>'GSO','E'=>'Overnite Express','O'=>'Other');
		if($type) {
			return $sc_option[$type];
		}
		return $sc_option;
	}

}