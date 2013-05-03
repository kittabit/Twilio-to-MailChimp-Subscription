<?php
require_once('mailchimp.class.php');
require_once('config.php');

function submitEmail(){
	$api = new MCAPI($mc_api_key);
	
	if(!$_REQUEST['Body']){ 
		return "No Email Address Provided"; 
	} 

	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_REQUEST['Body'])) {
		return "Email Address Is Invalid, Please Try Again.";
	}	
	
	if($api->listSubscribe($mc_list_id, $_REQUEST['Body'], '') === true) {
		return $_REQUEST['Body']." Successfully Subscribed!";
	}else{
		return "Error, Please Try Again Later.";
	}	
}
	
header("Content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Sms><?php echo submitEmail(); ?></Sms>
</Response>