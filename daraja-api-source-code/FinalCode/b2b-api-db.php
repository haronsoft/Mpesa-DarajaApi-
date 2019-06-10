<?php
	require 'processTransactions.class.php';

	$processTransactions = new processTransactions;

	$jsonObject = file_get_contents('php://input');
	$b2bJson = json_decode($jsonObject);

	/* 
	*
	* Process only successful Transactions 
	*/

	if($b2bJson->Result->ResultCode == 0){
		$processTransactions->b2b_process($b2bJson);
	}

	/**
	* @source v1.0
	* @todo
	* Catch Errors and give a detailed description
	* You should know that if an error occured, M-PESA will not resend the transaction if the error was
	* on our end, so, once it fails you need to manually counter check, or use
	* @transaction-status $biz->transaction_status($endPoint, $curl_post_data)
	*
	**/

	/* Transaction Failed due to an error on our end/an error with safaricom servers. Probably worth a retry if you believe this is in error */
	else{
		echo "Transaction Failed before you knew it";
	}