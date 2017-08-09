<?php 
App::import('Vendor', 'Twilio', array ('file' => 'twilio/twilio.php')); 
class TwilioComponent extends Object{
    var $controller;
 
    function startup( &$controller ) {
        $this->controller = &$controller;
    }

    function sendSMS($msgdetails){
    	if($msgdetails){
	       	//Twilio REST API version
			$ApiVersion = 	"2010-04-01";	
			//Set our AccountSid and AuthToken
			$AccountSid = 	"ACac0c774cb1414ada98e6d431b9f25620";
			$AuthToken 	= 	"824a95f908000109174f6e1422d909de";	
			//Instantiate a new Twilio Rest Client
			$client 	= 	new TwilioRestClient($AccountSid, $AuthToken);	
			//make an associative array of server admins
			//Iterate over all our server admins
			foreach ($msgdetails as $msgdetail) {
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
					"POST", array(
		  			"To" => $msgdetail['number'],
					"From" => Configure::read('twiliofrom'),
					"Body" => "Hello, there is a signing in ".$msgdetail['zipcode']." on ".$msgdetail['date'].". To claim this signing, please call 1 Hour Signings at 1(888)504-5517 and dial reference # ".$msgdetail['reforderid']." when prompted."
				));
				if($response->IsError)
					$msg = "Error: {$response->ErrorMessage}<br/>";
				else
					$msg = "Sent message to ".$msgdetail['name']."<br/>";
			} 
    	} else {
    		$msg = "No numbers found";
    	}
    	return $msg;
    }      
}
?>