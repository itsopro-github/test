<?php
class Contentpage extends AppModel {
	var $name = 'Contentpage';
	var $displayField = 'name';
	
	
	var $validate = array('name' => array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Name is mandatory.')),
                  		'pagetitle' => array('rule2'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Page title is mandatory.')),
                  		'content' => array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Content is mandatory.')));
}
?>