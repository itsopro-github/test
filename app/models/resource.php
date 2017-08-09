<?php
class Resource extends AppModel {
	var $name = 'Resource';
	var $displayField = 'title';
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Title is mandatory.',
				'allowEmpty' => false,
				'required' => false
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Description is mandatory.',
				'allowEmpty' => false,
				'required' => false
			),
		),
	/*	'helplink' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Help link is mandatory.',
				'allowEmpty' => false,
				'required' => false
			),
		),

		'resourcefile' => array('rule3'=>array('rule'=>array('extension', array('pdf')),'required' => true,'message' => 'Please supply a valid resource file ')),
		*/
		'category' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Category is mandatory.',
				'allowEmpty' => false,
				'required' => false
			),
		)
	);
}
?>