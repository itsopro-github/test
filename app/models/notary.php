<?php
class Notary extends AppModel {
	var $name = 'Notary';
	var $displayField = 'name';
	
	var $validate = array(
	    'first_name' => array('rule1' => array('rule' => 'notEmpty','required' => true,'message'=>'First Name is mandatory')),
	    'last_name' => array('rule2' => array('rule' => 'notEmpty','required' => true,'message'=>'Last Name is mandatory')),
	    'email' => array('rule3' => array('rule' => 'notEmpty','required' => true,'message'=>'Please supply a valid email')),
	    'cell_phone'=>array('rule16' => array('rule' =>'/^[0-9]{10,10}$/i','message' => 'Please enter a valid cell phone number, only numbers allowed')),
	    'day_phone'=> array('rule4' => array('rule' =>'/^[0-9]{10,10}$/i','allowEmpty' =>true,'message'=>'Please supply valid day phone number, only numbers allowed')),
	    'evening_phone'=> array('rule17' => array('rule' =>'/^[0-9]{10,10}$/i','allowEmpty' =>true,'message'=>'Please supply valid evening phone number, only numbers allowed')),
	    'fax'=> array('rule23' => array('rule' =>'/^[0-9]{10,10}$/i','allowEmpty' =>true,'message'=>'Please supply valid fax number, only numbers allowed')),
	    'dd_address' => array('rule5' => array('rule' => 'notEmpty','required' => true,'message'=>'Document Delivery address is mandatory')),
	    'fees' => array('rule18' => array('rule' => 'notEmpty','required' => true,'message'=>'fees is mandatory')),
	    'dd_state' => array('rule6' => array('rule' => 'notEmpty','required' => true,'message'=>'Document Delivery state is mandatory')),
		'dd_city' => array('rule7' => array('rule' => 'notEmpty','required' => true,'message'=>'Document Delivery city is mandatory')),
		'dd_zip' => array('rule8' => array('rule' => 'postal','required' => true,'message'=>'Please enter a valid document delivery zip code')),
		'p_address' => array('rule9' => array('rule' => 'notEmpty','required' => true,'message'=>'Payment address is mandatory')),
		'p_city' => array('rule10' => array('rule' => 'notEmpty','required' => true,'message'=>'Payment city is mandatory')),
		'p_state' => array('rule11' => array('rule' => 'notEmpty','required' => true,'message'=>'Payment state is mandatory')),
		'p_zip' => array('rule12' => array('rule' => 'postal','required' => true,'message'=>'Please enter a valid payment zip code')),
		'commission'=>array('rule13'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Commission is mandatory.'),
						'rule14'=>array('rule'=>'alphaNumeric','message'=>'Only alphabets and numbers allowed for Commission')),
		'expiration' => array('rule15' => array('rule' => 'notEmpty','required' => true,'message'=>'Expiration is mandatory')),
    	'zipcode' => array('rule16' => array('rule' => 'postal','required' => true,'message'=>'Zip code covered is mandatory'))
    );
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Assignment' => array(
			'className' => 'Assignment',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
		function getLastQuery()
		{
		    $dbo = $this->getDatasource();
		    $logs = $dbo->_queriesLog;
			$query = end($logs); 
			return $query['query'];
		   
		}
		
}
?>