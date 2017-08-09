<?php
class Signinghistory extends AppModel {
	var $name = 'Signinghistory';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

		var $validate = array(
		'orderstatus_id'=>array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Order Status is mandatory.')),
		//'notes'=>array('rule2'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Notes is mandatory.')),
	    'appointment_time'=>array('rule3'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Appointment time is mandatory.')));
	
	var $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Notary' => array(
			'className' => 'Notary',
			'foreignKey' => 'user_id',
			'conditions' => 'Signinghistory.user_id = Notary.user_id',
			'fields' => '',
			'order' => ''
		),
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'user_id',
			'conditions' => 'Signinghistory.user_id = Client.user_id',
			'fields' => '',
			'order' => ''
		),
		'Orderstatus' => array(
			'className' => 'Orderstatus',
			'foreignKey' => 'orderstatus_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>