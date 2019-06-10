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

	/* Your POST request should Contain; TransactionID, Amount, Remarks and Occasion. The rest Provide for in the FinalCode/params.php */
	$userCollectedData = $_POST;
	$CommandID = 'SalaryPayment';
	$endPointURL = 'https://sandbox.safaricom.co.ke/mpesa/reversal/v1/request';

	$array_base = array(
		  'Initiator' => $Initiator,
		  "ReceiverParty" => $ShortCode,
		  'SecurityCredential' => $securityCredential,
		  'CommandID' => 'TransactionReversal',
		  'RecieverIdentifierType' => '11',
		  'ResultURL' => $reversalResultURL,
		  'QueueTimeOutURL' => $QueueTimeOutURL
		);

	$curl_post_data = json_encode(array_merge($userCollectedData, $array_base));


	echo $BusninessAPI->reverse_transaction($endPointURL, $curl_post_data);
?>