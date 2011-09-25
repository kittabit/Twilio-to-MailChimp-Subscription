<?php
function submitEmail(){
	require_once('mailchimp.class.php');	
	$api = new MCAPI('590f84584c16b435a6e40de076edbbba-us2');
	$mailChimpListId = "9c0699c6bd";
	
	if(!$_REQUEST['Body']){ 
		return "No Email Address Provided"; 
	} 

	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_REQUEST['Body'])) {
		return "Email Address Is Invalid, Please Try Again.";
	}	
	
	if($api->listSubscribe($mailChimpListId, $_REQUEST['Body'], '') === true) {
		return $_REQUEST['Body']." Successfully Subscribed!";
	}else{
		return "Error, Please Try Again Later.";
	}	
}
	
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
    <Sms><?php echo submitEmail(); ?></Sms>
</Response>