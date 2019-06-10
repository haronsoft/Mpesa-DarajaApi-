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


	/* Your POST request should contain PartyA == PhoneNumber,  Amount, AccountReference and TransactionDesc */
	$AccountData = $_POST;
	$endPoint = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
	$basicData = array(
	    //Fill in the request parameters with valid values
	    'BusinessShortCode' => $BusinessShortCode,
	    'Password' => $Password,
	    'Timestamp' => $Timestamp,
	    'TransactionType' => 'CustomerPayBillOnline',
	    'PartyB' => $BusinessShortCode,
	    'CallBackURL' => $lnmoCallBackURL,
	    'TransactionDesc' => 'online e-topup'
	  );

	$curl_post_data = array_merge($basicData, $AccountData);
	//var_dump($curl_post_data);

	$response = $BusninessAPI->lipa_na_mpesa_online($endPoint, json_encode($curl_post_data));
	echo $response;

?>