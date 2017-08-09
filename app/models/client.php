<?php
class Client extends AppModel {
	
	var $name = 'Client';
	
	var $displayField = 'first_name';

	var $virtualFields = array('fullname' => 'CONCAT(Client.first_name, " ", Client.last_name)');

	var $validate = array(
		'company' => array('rule1' => array('rule' => 'notEmpty','required' => true,'message'=>'Company is mandatory')),
	    'first_name' => array('rule2' => array('rule' => 'notEmpty','required' => true,'message'=>'First Name is mandatory')),
	    'last_name' => array('rule3' => array('rule' => 'notEmpty','required' => true,'message'=>'Last Name is mandatory')),
	    'email' => array('rule4' => array('rule' => 'email','required' => true,'message'=>'Please supply a valid email')),
	    'company_phone'=>array('rule' => '/^[0-9]{10,10}$/i','message' => 'Please enter a valid phone number, only numbers allowed'),	  
	    'company_fax'=> array('rule23' => array('rule' =>'/^[0-9]{10,10}$/i','allowEmpty' =>true,'message'=>'Please supply valid fax number, only numbers allowed')),
	    'fees' => array('rule7' => array('rule' => 'notEmpty','required' => true,'message'=>'Fees is mandatory')),
	    'of_street_address' => array('rule8' => array('rule' => 'notEmpty','required' => true,'message'=>'Office street address is mandatory')),
	    'of_city' => array('rule9' => array('rule' => 'notEmpty','required' => true,'message'=>'Office city is mandatory')),
	     'of_state' => array('rule10' => array('rule' => 'notEmpty','required' => true,'message'=>'Office state is mandatory')),
	     'of_zip' => array('rule11' => array('rule' => 'postal','required' => true,'message'=>'Please enter a valid office zip code')),
	     'rd_street_address' => array('rule12' => array('rule' => 'notEmpty','required' => true,'message'=>'Return street address is  mandatory')),
	     'rd_city' => array('rule13' => array('rule' => 'notEmpty','required' => true,'message'=>'Return document city  is mandatory')),
	     'rd_state' => array('rule14' => array('rule' => 'notEmpty','required' => true,'message'=>'Return document state  is mandatory')),
	     'rd_zip' => array('rule15' => array('rule' => 'postal','required' => true,'message'=>'Please enter a valid return document zip code'))
    );
	
    //The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>