<?php
    /**
    *
    * This file helps in receiving simulation requests from your form.
    * The Post Request should be formatted only to accept amount and billref
    * as all the rest are provided for in the FinalCode/params.php
    *
    * This Code is provided in 'as is' no warranties whatsoever on whether it will work
    * and no assurances. By using it, you indemnify the source from any legal obligations.
    *
    */
	require '../FinalCode/params.php';


	/* Your POST request should contain: Amount, PartyB(Phone Number), Remarks and Occasion */
	$userCollectedData = $_POST;


	$CommandID = 'SalaryPayment';
	$endPointURL = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
	$curl_post_data = array(
	  'InitiatorName' => $Initiator,
	    'SecurityCredential' => $securityCredential,
	    'CommandID' => $CommandID,
	    'PartyB' =>$msisdn,
	    'PartyA' => $ShortCode,
	    'QueueTimeOutURL' => $QueueTimeOutURL,
	    'ResultURL' => $B2CResultURL,
	    'Occasion' => $Occasion
	);

	
	$curl_post_data = json_encode(array_merge($userCollectedData, $curl_post_data));
	echo $BusninessAPI->b2c_api($endPointURL, $curl_post_data);
?>