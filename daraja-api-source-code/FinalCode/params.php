<?php
	date_default_timezone_set("Africa/Nairobi");


    require 'paymentsAPI.class.php';

    $consumerKey =  '';
    $consumerSecret = '';

    # This class contains the method for simulating the transaction
    $BusninessAPI = new MobilePayments($consumerKey, $consumerSecret);

	$ShortCode = '';
	$BusinessShortCode = '';
	$Initiator = '';
	$msisdn = '';
	$Timestamp = date('YmdHis');
	$Passkey = '';
	$Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);

	$securityCredential = '';

	# register url URLs
	$confirmationUrl = '';
	$validationUrl = '';

	/* b2b urls */
	$QueueTimeOutURL = '';
	$B2BResultURL = '';

	/* b2c urls */
	$B2CResultURL = '';
	$Occasion = '';


	/* reverse api urls */
	$reversalResultURL = '';


	/* lnmo api urls */
	$lnmoCallBackURL = '';

	/* transaction status api urls */
	$transactionStatusResultURL = '';

	/* account balance api urls */
	$AccountBalanceResultURL = '';
?>