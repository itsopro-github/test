<?php
class Message extends AppModel {
	var $name = 'Message';
	var $validate = array(
		'to_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'To field is mandatory.',
				'allowEmpty' => false,
				'required' => false,
			),
		),
		'subject' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Subject is mandatory.',
				'allowEmpty' => false,
				'required' => false,
			),
		),
		'body' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Message is mandatory.',
				'allowEmpty' => false,
				'required' => false,
			),
		),
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