<?php
	require 'processTransactions.class.php';

	$processTransactions = new processTransactions;

	$jsonObject = file_get_contents('php://input');

	$transactionStatusJson = json_decode($jsonObject);

	if($transactionStatusJson->Result->ResultCode == 0){
		$processTransactions->transaction_status_process($transactionStatusJson);
		/*if($processTransactions->transaction_status_process($transactionStatusJson) == true){
			echo json_encode(['ResultCode' => 0, 'ResultDesc' => "Success, Response Received"]);
		}	
		else{
			echo json_encode(['ResultCode' => 1, 'ResultDesc' => "Failed, No Response Received"]);
		}*/
	}
	else{

		/**
		*
		* @todo Log API endpoint Access
		*
		*
		*/
		echo json_encode(['ResultCode' => 1, 'ResultDesc' => "Failed. Transaction Has Failed"]);
	}
