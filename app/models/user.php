<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';
	
	var $validate = array(
		'username'=>array('rule1'=>array('rule'=>'notempty','message'=>'Username must be specified')),		
		'password'=>array('rule3'=>array('rule'=>'notempty','message'=>'Password must be specified'))
	);

	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasOne = array(
		'Client'=>array(
			'className'=>'Client',
			'foreignKey'=>'user_id',
			'dependent'=>false,
			'conditions'=>'',
			'fields'=>'',
			'order'=>'',
			'limit'=>'',
			'offset'=>'',
			'exclusive'=>'',
			'finderQuery'=>'',
			'counterQuery'=>''
		),
		'Notary'=>array(
			'className'=>'Notary',
			'foreignKey'=>'user_id',
			'dependent'=>false,
			'conditions'=>'',
			'fields'=>'',
			'order'=>'',
			'limit'=>'',
			'offset'=>'',
			'exclusive'=>'',
			'finderQuery'=>'',
			'counterQuery'=>''
		)
	
	);
	var $hasMany = array(
		'Assignment'=>array(
			'className'=>'Assignment',
			'foreignKey'=>'user_id',
			'dependent'=>false,
			'conditions'=>'',
			'fields'=>'',
			'order'=>'',
			'limit'=>'',
			'offset'=>'',
			'exclusive'=>'',
			'finderQuery'=>'',
			'counterQuery'=>''
		),
		'Message'=>array(
			'className'=>'Message',
			'foreignKey'=>'user_id',
			'dependent'=>false,
			'conditions'=>'',
			'fields'=>'',
			'order'=>'',
			'limit'=>'',
			'offset'=>'',
			'exclusive'=>'',
			'finderQuery'=>'',
			'counterQuery'=>''
		),
		'Order'=>array(
			'className'=>'Order',
			'foreignKey'=>'user_id',
			'dependent'=>false,
			'conditions'=>'',
			'fields'=>'',
			'order'=>'',
			'limit'=>'',
			'offset'=>'',
			'exclusive'=>'',
			'finderQuery'=>'',
			'counterQuery'=>''
		),
		'Payment'=>array(
			'className'=>'Payment',
			'foreignKey'=>'user_id',
			'dependent'=>false,
			'conditions'=>'',
			'fields'=>'',
			'order'=>'',
			'limit'=>'',
			'offset'=>'',
			'exclusive'=>'',
			'finderQuery'=>'',
			'counterQuery'=>''
		)
	);
	
}
?>