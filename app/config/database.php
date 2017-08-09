<?php
class DATABASE_CONFIG {

	var $test = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '192.168.0.3',
		'login' => 'char01',
		'password' => 'interberry',
		'database' => 'wbsw_db',
		'prefix' => '',
	);
	
	var $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'hoursign_wbsw',
		'password' => 'iberry123',
		'database' => 'hoursign_wbsw',
		'prefix' => '',
	);
}
