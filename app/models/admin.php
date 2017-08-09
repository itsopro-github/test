<?php
class Admin extends AppModel {
	var $name = 'Admin';
	
	var $validate = array(
		'name' => array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Name is mandatory.')),
		'username' => array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Username is mandatory.')
						),
		'password' => array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Password is mandatory.'),
							'rule2'=>array('rule'=>array('minLength', 6),'message'=>'Password should contain minimum 6 characters'),
							'rule3'=>array('rule'=>'validatePwd','message'=>'Password and Confirm Password does not match'),
					   		),
		'email' => array('rule1'=>array('rule'=>'email','message'=>'Please enter valid email.')),
			
						'type' => array('rule8'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Type is mandatory.'))
	);

	
	function validatePwd() {
		if(@$this->data['Admin']['password'] == @$this->data['Admin']['confirmpassword']) {
			
			@$this->data['Admin']['password'] = md5(@$this->data['Admin']['password'].Configure::read('Security.salt'));
            return true;
        } else {
        	return false;
        }   
    }
    
    	
	
}
?>