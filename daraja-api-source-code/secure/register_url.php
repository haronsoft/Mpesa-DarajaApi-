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

	/* register the URLS for validation and confirmation */
	$endPointURL = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
	$curl_post_data = json_encode(['ShortCode' => $ShortCode, 'ResponseType' => 'Completed','ConfirmationURL' => $confirmationUrl, 'ValidationURL' => $validationUrl]);

	/* This expects a GET request to send the URLs to the M-PESA Gateway */
	$res = $BusninessAPI->register_urls($endPointURL, $curl_post_data);
	print_r($res);

?>