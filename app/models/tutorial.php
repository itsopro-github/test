<?php
class Tutorial extends AppModel {
	var $name = 'Tutorial';
	var $displayField = 'title';
	
	var $validate = array('title' => array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Title is mandatory.')),
						
	'description' => array('rule2'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Description is mandatory.')));
}
?>