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

	/* simulate transaction request. This are the details on your FinalCode/params.php */
	$endPointURL = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
	$initData = ['ShortCode' => $ShortCode, 'CommandID' => 'CustomerPayBillOnline', 'Msisdn' => $msisdn];

	/* This is your form data. Expected values are Amount and $billRef */
	$AccountData = $_POST;

	/* Combine the Array and json_encode it */
	$curl_post_data = json_encode(array_merge($AccountData, $initData));
	
	/* Make the API Call */
	echo $BusninessAPI->simulate_transaction($endPointURL, $curl_post_data);
?>