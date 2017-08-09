<?php
	Configure::write('debug', 0);
	Configure::write('log', false);
	Configure::write('App.encoding', 'UTF-8');
	Configure::write('Routing.prefixes', array('admin'));
	Configure::write('Cache.disable', true);
	define('LOG_ERROR', 2);
	Configure::write('Session.save', 'php');
	Configure::write('Session.cookie', 'CPHNS');
	Configure::write('Session.timeout', '80');
	Configure::write('Session.start', true);
	Configure::write('Session.checkAgent', true);
	Configure::write('Security.level', 'medium');
	Configure::write('Security.salt', 'DYhG93b0qyJfIxfs2guVoUubWwvniR2Ghtijner');
	Configure::write('Security.cipherSeed', '768593096574535424967496836456');
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');
	
	Cache::config('default', array('engine' => 'File'));
	
	Configure::write('WEB_URL', FULL_BASE_URL.'/');
	Configure::write('PARENT_WEB_URL', 'http://www.1hoursignings.com/');
	Configure::write('IMAGE_PATH', 'http://www.1hoursignings.net/img/');
	Configure::write('siteurl', 'http://www.1hoursignings.net/');
	Configure::write('sitename', '1 Hour Signings');	

	Configure::write('ceo', 'Ginger Armosilla');

	Configure::write('infoemail', 'info@1hoursignings.net');
	Configure::write('fromemail', 'noreply@1hoursignings.net');
	Configure::write('replyemail', 'noreply@1hoursignings.net');
	Configure::write('displayemail', 'info@1hoursignings.com');
	Configure::write('adminemail', 'info@1hoursignings.net');
	Configure::write('notaryupdate', 'notaryupdate@1hoursignings.net');
	Configure::write('clientupdate', 'clientupdate@1hoursignings.net');

	Configure::write('nsphonenumber', '562-219-2666');
	Configure::write('nsfaxnumber', '562-219-2666');
	Configure::write('tollfreenumber', '1(800) 717-8591'); 
	Configure::write('extension', '201');
	Configure::write('twiliofrom', '(562) 219-2666');
	Configure::write('fedextracking', 'http://fedex.com/Tracking?tracknumber_list=');
	Configure::write('upstracking', 'https://wwwapps.ups.com/WebTracking/processInputRequest?AgreeToTermsAndConditions=yes&loc=en_US&Requester=trkinppg&tracknum=');
	Configure::write('dhltracking', 'http://track.dhl-usa.com/TrackByNbr.asp?nav=Tracknbr');
	Configure::write('gsotracking', 'http://www.gso.com/Tracking');
	Configure::write('overniteexpress', 'http://www.norcoovernite.com/v2/NorcoOvernite.mvc');
	
	Configure::write('currency', '$');
	
	Configure::write('copyright', '&copy;'.date('Y').' '.Configure::read('sitename').'. All Rights Reserved.');

	/* NEWS */
	Configure::write('NEWS_IMAGE_PATH', 'files/news/');
	Configure::write('NEWS_THUMB_IMAGE_PATH', 'files/news/thumb/');
	Configure::write('ORDERS_PATH', 'files/orders/');	
	
	/* EDOCS */
	Configure::write('EDOC_FILE_PATH', 'files/edocs/');
	/* Tutorials */
	Configure::write('TUTORIAL_PATH', 'files/tutorials/');
	/* Resources */
	Configure::write('RESOURCE_PATH', 'files/resources/');
	/* Invoices*/
	Configure::write('INVOICE_FILE_PATH','files/invoices/');
	
	/* Date and time format used in website and admin */
	Configure::write('nsdate','m-d-Y');
	Configure::write('nsdatetime','m-d-Y h:i:s');
	Configure::write('nsdatetimemeridiem','m-d-Y h:i:s a');
