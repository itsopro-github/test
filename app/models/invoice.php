<?php
class Invoice extends AppModel {
	var $name = 'Invoice';
	var $displayField = 'id';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	/*var $validate = array(
					'totalfees'=>array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Fees is mandatory.'),
									'rule2'=>array('rule'=>'checknum','message' => 'Fees is not valid.')),
					);*/

	var $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function checknum() {
	 	if(! preg_match("/^[0-9.]+$/",$this->data['Invoice']['totalfees'])){
	 		return false;
	   	} else {
	  		return true;
	   	}
	}

	
}
?>