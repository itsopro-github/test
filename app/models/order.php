<?php
class Order extends AppModel {
	var $name = 'Order';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
		
	var $validate = array(
		'first_name'=>array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'First Name is mandatory.')),
	    'last_name'=>array('rule2'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Last name is mandatory.')),
	   	'home_phone'=>array('rule3' => array('rule'=>'/^[0-9]{10,10}$/i','message' => 'Please enter a valid home phone number.')),
	    'work_phone'=> array('rule4' => array('rule'=>'/^[0-9]{10,10}$/i','allowEmpty' =>true,'message'=>'Please supply valid work phone number, only numbers allowed')),
	    'cell_phone'=> array('rule5' => array('rule'=>'/^[0-9]{10,10}$/i','allowEmpty' =>true,'message'=>'Please supply valid cell phone number, only numbers allowed')),
	    'alternative_phone'=> array('rule21' => array('rule' =>'/^[0-9]{10,10}$/i','allowEmpty' =>true,'message'=>'Please supply valid alternate phone number, only numbers allowed')),
	    'file'=>array('rule6'=>array('rule'=>'notEmpty','required'=>true,'message'=>'File number is mandatory.')),
	    'date_signing'=>array('rule16'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Date of signing is mandatory.')),
	    'sa_street_address'=>array('rule17'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Signing address is mandatory.')),
	    'sa_state'=>array('rule18'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Signing state is mandatory.')),
	    'sa_city'=>array('rule7'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Signing city is mandatory.')),
	    'sa_zipcode'=>array('rule8'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Signing zip code is mandatory.'),
	     'rule19'=>array('rule'=>array('postal',null,'us'),'message'=>'Signing zip code is not valid')),	  
	    'pa_street_address'=>array('rule20'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Property address is mandatory.')),
	    'pa_state'=>array('rule10'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Property state is mandatory.')),
	    'pa_city'=>array('rule11'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Property city is mandatory.')),
	    'pa_zipcode'=>array('rule12'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Property zip code is mandatory.'),
	     					'rule13'=>array('rule'=>array('postal',null,'us'),'message'=>'Property zip code is not valid')),  
	    'doc_info'=>array('rule14'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Document info is mandatory.')),
	    'doc_submit'=>array('rule15'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Document type is mandatory.'))
    );
	
	var $belongsTo = array(
		'User'=>array(
			'className'=>'User',
			'foreignKey'=>'user_id',
			'conditions'=>'',
			'fields'=>'',
			'order'=>''
		),
		'Orderstatus'=>array(
			'className'=>'Orderstatus',
			'foreignKey'=>'orderstatus_id',
			'conditions'=>'',
			'fields'=>'',
			'order'=>''
		),
			'Clients'=>array(
			'className'=>'Clients',
			'foreignKey'=>'',
			'conditions'=>'Order.user_id=Clients.user_id',
			'fields'=>'',
			'order'=>''
		),
		'Assignment'=>array(
			'className'=>'Assignment',
			'foreignKey'=>'',
			'dependent' => false,
			'conditions'=>'Order.id=Assignment.order_id',
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
		
		'Orderdetail'=>array(
			'className'=>'Orderdetail',
			'foreignKey'=>'order_id',
			'dependent' => false,
			'conditions'=>'',
			'fields'=>'',
			'order'=>'',
			'limit'=>'',
			'offset'=>'',
			'exclusive'=>'',
			'finderQuery'=>'',
			'counterQuery'=>''
		),
		'OrderEdoc'=>array(
			'className'=>'OrderEdoc',
			'foreignKey'=>'order_id',
			'dependent' => false,
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