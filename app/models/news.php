<?php
class News extends AppModel {
	var $name = 'News';
	var $displayField = 'title';
	
	var $validate = array('title' => array('rule1'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Title is mandatory.')),
                  		'description' => array('rule2'=>array('rule'=>'notEmpty','required'=>true,'message'=>'Description is mandatory.')));
}
?>