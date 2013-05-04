<?php
require_once('mailchimp.class.php');

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set("display_errors", false);
ini_set('log_errors', true);
ini_set('html_errors', false); 

// TODO logging needs to be added

function submitEmail() {
	require_once('config.php');

	$api = new MCAPI($mc_api_key);
	
	if(empty($_REQUEST['Body'])){ 
		return $error_no_email;
	}

	error_log("Processing: ".print_r($_REQUEST, true));

	$body = strtolower($_REQUEST['Body']);
	$matches = array();

	// http://stackoverflow.com/questions/3901070/in-php-how-do-i-extract-multiple-e-mail-addresses-from-a-block-of-text-and-put
	if(!preg_match("/[a-z0-9_\-\+]+@[a-z0-9\-]+\.(?:[a-z]{2,3})(?:\.[a-z]{2})?/i", $body, $matches)) {
		return $error_invalid_email;
	}

	$email = $matches[0];

	$merge_vars = array(
		'SOURCE' => 'TXT'
	);

	// the twilio (us) phone # is always: +1xxxyyyzzzz
	if(!empty($_REQUEST['From'])) {
		$phone_matches = array();

		if(!preg_match("/(1?(-?\d{3})-?)?(\d{3})(-?\d{4})/", $_REQUEST['From'], $phone_matches)) {
			$merge_vars['PHONE'] = $phone_matches[2] . '-' . $phone_matches[3] . '-' . $phone_matches[4];
		}
	}
	
	if($api->listSubscribe($mc_list_id, $email, $merge_vars) === true) {
		return htmlentities(sprintf($success_confirm_subscription, $email));
	} else {
		error_log($api->errorCode . ": " . $api->errorMessage);

		if($api->errorCode == 214) {
			return $error_already_subscribed;
		} else {
			return $error_general;
		}
	}	
}
	
header("Content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Sms><?php echo submitEmail(); ?></Sms>
</Response>